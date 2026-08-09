# Stabilkan Shell (TTY)

Setelah mendapatkan reverse shell, shell biasanya masih **non-interaktif**.
TTY digunakan agar shell lebih nyaman digunakan, misalnya untuk autocomplete,
clear screen, dan penggunaan shortcut terminal.

## Python

```bash
python3 -c 'import pty;pty.spawn("/bin/bash")'

# Membuat pseudo-terminal (PTY) menggunakan Python
```

## Python - os.system

```bash
echo os.system('/bin/bash')

# Menjalankan Bash melalui Python
# Dapat digunakan jika Python tersedia
```

## Interactive Shell

```bash
/bin/sh -i

# Menjalankan shell secara interactive
```

## Script

```bash
script -qc /bin/bash /dev/null

# Membuat pseudo-terminal menggunakan command script
# Berguna ketika Python tidak tersedia
```

## Perl

```bash
perl -e 'exec "/bin/sh";'

# Menjalankan /bin/sh menggunakan Perl
# Dapat digunakan jika Perl tersedia
```

## Ringkasan

```text
Reverse Shell
      ↓
Shell Non-Interactive
      ↓
Spawn TTY / PTY
      ↓
Interactive Shell
      ↓
Autocomplete / Clear / Shortcut
```

### Cek Program yang Tersedia

```bash
which python3
which script
which perl
which bash

# Mengecek command yang tersedia pada target
```

> **Catatan:** Tidak semua metode tersedia pada setiap sistem. Pilih metode
> berdasarkan program yang tersedia pada target.
