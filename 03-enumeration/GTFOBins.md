# GTFOBins / LOLBAS

**GTFOBins** digunakan untuk mencari cara memanfaatkan binary Unix/Linux
yang memiliki konfigurasi atau permission tertentu, misalnya **SUID** atau
**sudo**.

**LOLBAS** merupakan referensi serupa untuk binary/program pada **Windows**.

## GTFOBins

Untuk **setiap binary SUID atau binary yang dapat dijalankan melalui sudo**,
cek referensi:

**[GTFOBins](https://gtfobins.github.io)**

```text
Cari nama binary
      ↓
Pilih binary
      ↓
Cek bagian "SUID" atau "Sudo"
      ↓
Periksa teknik yang tersedia
```

### Contoh Binary Umum

```text
find        # File search utility
vim         # Text editor
less        # Pager
awk         # Text processing
mawk        # AWK implementation
env         # Menjalankan command dengan environment tertentu
python      # Python interpreter
perl        # Perl interpreter
bash        # Shell
tar         # Archive utility
nano        # Text editor
cp          # Copy files
dd          # Low-level file/data utility
```

## Mencari SUID Binary

```bash
find / -perm -4000 -type f 2>/dev/null

# Mencari file dengan SUID bit pada sistem Linux
# Hasilnya dapat dicek satu per satu di GTFOBins
```

## Sudo Permission

```bash
sudo -l

# Menampilkan command yang dapat dijalankan menggunakan sudo
# Binary yang muncul dapat dicek di bagian "Sudo" GTFOBins
```

## Alur Pemeriksaan

```text
Enumerasi
    ↓
SUID Binary / sudo -l
    ↓
Temukan Binary
    ↓
Cari di GTFOBins
    ↓
Cek SUID / Sudo
    ↓
Validasi pada lingkungan pengujian
```

> **Catatan:** keberadaan binary di GTFOBins **tidak otomatis berarti sistem
> vulnerable**. Eksploitabilitas bergantung pada permission, konfigurasi,
> versi binary, dan hak akses user.

## LOLBAS (Windows)

Untuk sistem Windows, gunakan:

**[LOLBAS](https://lolbas-project.github.io/)**

```text
Windows Binary
      ↓
Cari di LOLBAS
      ↓
Cek fungsi/abuse case
      ↓
Periksa requirement
      ↓
Validasi pada lingkungan pengujian
```
