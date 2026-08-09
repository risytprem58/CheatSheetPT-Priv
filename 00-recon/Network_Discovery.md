# Network Discovery

# temukan target di NAT Network
sudo netdiscover -r 10.0.2.0/24  # -r (Range): Menentukan rentang spesifik (subnet). Contoh: 10.0.2.0/24
nmap -sn 10.0.2.0/24             # -sn: Deteksi host aktif saja tanpa memindai port (lebih cepat).

# IP Kali sendiri (untuk LHOST reverse shell)
ip a | grep 10.0.                # grep: Memfilter agar hanya menampilkan teks yang mengandung "10.0."
