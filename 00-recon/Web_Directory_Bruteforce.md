# Web Directory Brute Force

```bash
dirsearch -u http://<TARGET>:PORT/
feroxbuster -u http://<TARGET>:PORT/ -w /usr/share/wordlists/dirb/common.txt
dirb http://<TARGET>:PORT/ /usr/share/wordlists/dirb/common.txt
```
