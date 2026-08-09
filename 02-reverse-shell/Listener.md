# Listener

```bash
# Jalankan listener di Kali terlebih dahulu sebelum trigger payload
nc -lvnp 4444

# Listener dengan readline/history
rlwrap nc -lvnp 4444
```

### Keterangan

```text
nc       → Netcat, digunakan untuk membuat listener
-l       → Listen mode
-v       → Verbose, menampilkan informasi koneksi
-n       → Tidak melakukan DNS resolution
-p 4444  → Menggunakan port 4444

rlwrap   → Menambahkan history dan navigasi tombol panah
```

### Alur Reverse Shell

```text
Target
   │
   │ Reverse Connection
   ▼
Kali Linux
   │
   └── nc -lvnp 4444
          ↓
      Interactive Shell
```

> **Catatan:** Listener harus dijalankan **sebelum** payload reverse shell
> dipicu agar koneksi dari target dapat diterima.

## Referensi

- [PentestMonkey Cheat Sheet](http://pentestmonkey.net/cheat-sheet/shells/reverse-shell-cheat-sheet)
- [PentestMonkey PHP Shell](https://github.com/pentestmonkey/php-reverse-shell)
- [revshells.com](https://revshells.com) — Generator reverse shell interaktif
