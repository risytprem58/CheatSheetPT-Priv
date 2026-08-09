# Web Directory Brute Force

**Web Directory Brute Force** digunakan untuk mencari direktori, file,
endpoint, dan resource tersembunyi pada web server menggunakan wordlist.

Tools yang umum digunakan:

```text
Dirsearch    # Directory/file enumeration
Feroxbuster  # Fast & recursive directory enumeration
Dirb         # Directory enumeration klasik
Ffuf         # Fast & flexible fuzzing
```

## Dirsearch

Digunakan untuk melakukan enumeration directory dan file pada web server.

```bash
dirsearch -u http://<TARGET>:PORT/
# Scan menggunakan wordlist default bawaan Dirsearch

dirsearch -u http://<TARGET>:PORT/ -w /usr/share/wordlists/dirb/common.txt
# -w: Menambahkan custom wordlist pilihanmu
```

## Feroxbuster

Digunakan untuk directory enumeration yang cepat dan mendukung
**recursive scanning**.

```bash
feroxbuster -u http://<TARGET>:PORT/ -w /usr/share/wordlists/dirb/common.txt
# -w: Path ke file custom wordlist
```

## Dirb

Tools directory enumeration klasik yang tersedia pada Kali Linux.

```bash
dirb http://<TARGET>:PORT/
# Scan menggunakan wordlist default Dirb

dirb http://<TARGET>:PORT/ /usr/share/wordlists/dirb/common.txt
# Menggunakan custom wordlist
# Dirb TIDAK memakai flag -w
# Wordlist langsung ditaruh setelah URL

# Scan khusus mencari file PHP, TXT, dan ZIP
dirb http://10.10.10.6:8000/ /usr/share/dirb/wordlists/common.txt -X .php,.txt,.zip -r
# -X: Extension file yang ingin dicari
# -r: Recursive scan

# Scan dengan mode senyap, simpan hasil, dan delay 50ms
dirb http://10.10.10.6:8000/ -S -z 50 -o laporan_dirb.txt
# -S: Silent mode
# -z 50: Delay 50ms antar request
# -o: Menyimpan hasil ke file

# Scan halaman internal yang membutuhkan login
dirb http://10.10.10.6:8000/admin/ -c "PHPSESSID=a1b2c3d4e5f6..."
# -c: Mengirim HTTP Cookie/session
```

## Ffuf

Digunakan untuk fuzzing yang cepat dan fleksibel. `FUZZ` pada URL akan
digantikan dengan setiap entry dari wordlist.

```bash
ffuf -u http://<TARGET>:PORT/FUZZ -w /usr/share/wordlists/dirb/common.txt
# -u: URL target
# FUZZ: Posisi yang akan diganti dengan isi wordlist
# -w: Wordlist
```

Contoh filtering berdasarkan HTTP status:

```bash
ffuf -u http://<TARGET>:PORT/FUZZ \
-w /usr/share/wordlists/dirb/common.txt \
-mc 200,300-399

# -mc: Match HTTP status code
# 200: Resource ditemukan
# 300-399: Redirect
```

## Wordlist Default Kali Linux

Wordlist digunakan sebagai daftar nama directory/file yang akan diuji.

### Dirb

```bash
/usr/share/wordlists/dirb/common.txt
# Paling sering dipakai untuk pengecekan awal

/usr/share/wordlists/dirb/big.txt
# Lebih lengkap dari common.txt
```

### Dirbuster

```bash
/usr/share/wordlists/dirbuster/directory-list-2.3-small.txt
# Ukuran sedang dan relatif efisien

/usr/share/wordlists/dirbuster/directory-list-2.3-medium.txt
# Sangat lengkap dan umum digunakan
```

### Jika File Masih Terkompresi

Jika file Dirbuster tidak ditemukan atau masih dalam format `.gz`,
ekstrak terlebih dahulu:

```bash
sudo gzip -d /usr/share/wordlists/dirbuster/directory-list-2.3-medium.txt.gz
```

## Status Code yang Perlu Diperhatikan

```text
200 → OK / resource ditemukan
301 → Permanent Redirect
302 → Temporary Redirect
307 → Temporary Redirect
308 → Permanent Redirect
401 → Unauthorized
403 → Forbidden
404 → Not Found
500 → Internal Server Error
```

**Keterangan:**

```text
200 → Endpoint dapat diakses
3xx → Endpoint melakukan redirect
401 → Membutuhkan autentikasi
403 → Endpoint ada tetapi akses ditolak
404 → Resource tidak ditemukan
500 → Terjadi error pada server
```

## Alur Pemeriksaan

```text
Target
   ↓
Pilih Wordlist
   ↓
Directory Enumeration
   ↓
HTTP Response
   ↓
Filter Status / Size
   ↓
Temukan Endpoint Menarik
   ↓
Validasi Manual
```

> **Catatan:** response `403` tetap perlu diperhatikan karena dapat
> menunjukkan bahwa directory/file tersebut memang ada tetapi aksesnya
> dibatasi. Response `3xx` juga dapat mengungkap lokasi atau endpoint lain.
