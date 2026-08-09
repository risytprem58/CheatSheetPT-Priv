# Web Directory Brute Force

```bash
dirsearch -u http://<TARGET>:PORT/
feroxbuster -u http://<TARGET>:PORT/ -w /usr/share/wordlists/dirb/common.txt
dirb http://<TARGET>:PORT/ /usr/share/wordlists/dirb/common.txt

# Dirsearch 
dirsearch -u http://<TARGET>:PORT/                                           # Scan default bawaan dirsearch.
dirsearch -u http://<TARGET>:PORT/ -w /usr/share/wordlists/dirb/common.txt   # -w: Menambahkan custom wordlist pilihanmu.

# Feroxbuster (Scan rekursif & sangat cepat)
feroxbuster -u http://<TARGET>:PORT/ -w /usr/share/wordlists/dirb/common.txt # -w: Path ke file custom wordlist.

# Dirb (Tools klasik bawaan Kali Linux)
dirb http://<TARGET>:PORT/ /usr/share/wordlists/dirb/common.txt              # Perhatikan: Dirb TIDAK memakai flag -w. Wordlist langsung ditaruh setelah URL.

# Ffuf (Sangat cepat dan fleksibel)
ffuf -u http://<TARGET>:PORT/FUZZ -w /usr/share/wordlists/dirb/common.txt    # -w: Wordlist. Kata 'FUZZ' pada URL akan otomatis diganti dengan isi wordlist.
