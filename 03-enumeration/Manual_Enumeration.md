# Manual Enumeration (Quick Wins)

```bash
id; sudo -l                                  # privilege + sudo rights
uname -a; cat /etc/os-release                # kernel + OS (untuk kernel exploit)
find / -perm -4000 -type f 2>/dev/null       # SUID
find / -perm -2000 -type f 2>/dev/null       # SGID
getcap -r / 2>/dev/null                      # capabilities
cat /etc/crontab; ls -la /etc/cron.d/        # cron jobs
find / -writable -type f 2>/dev/null | grep -v proc   # writable files
ls -la /home/*; cat ~/.bash_history          # info bocor
ss -tlnp                                     # service internal
```
