# Port Scanning

```bash
# Scan default (Hanya 1000 port paling umum, lebih cepat untuk tahap awal)
nmap -sV -sC <TARGET>                  # Tanpa -p-, Nmap hanya memindai 1000 port yang paling sering digunakan.

# Scan port & service secara detail (lebih lambat tapi mengecek seluruh port)
nmap -sV -sC -p- <TARGET>              # -sV: Cek versi service, -sC: Default script, -p-: Scan semua 65535 port.

# Scan port super cepat (cocok untuk CTF/Lab)
nmap -sV -p- --min-rate 5000 <TARGET>  # --min-rate 5000: Kirim minimal 5000 paket/detik agar sangat cepat.
```
