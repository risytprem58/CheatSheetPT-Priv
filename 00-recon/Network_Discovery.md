# Network Discovery

```bash
# temukan target di NAT Network
sudo netdiscover -r 10.0.2.0/24
nmap -sn 10.0.2.0/24

# IP Kali sendiri (untuk LHOST reverse shell)
ip a | grep 10.0.
```
