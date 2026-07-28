# Cheat Sheet — Lab Reference

Referensi teknik & payload:
recon → foothold → reverse shell → enumerasi → privilege escalation → proof.

## Struktur Direktori

```
.
├── 00-recon/
│   ├── Network_Discovery.md
│   ├── Port_Scanning.md
│   └── Web_Directory_Bruteforce.md
├── 01-initial-foothold/
│   ├── SQL_Injection.md
│   ├── File_Upload.md
│   ├── SSTI.md
│   ├── LFI.md
│   └── Command_Injection.md
├── 02-reverse-shell/
│   ├── Listener.md
│   ├── Payloads.md
│   ├── Msfvenom.md
│   └── Stabilize_TTY.md
├── 03-enumeration/
│   ├── LinPEAS.md
│   ├── Manual_Enumeration.md
│   └── GTFOBins.md
├── 04-privilege-escalation/
│   ├── Kernel_LPE.md
│   ├── SUID.md
│   ├── Sudo.md
│   ├── Weak_Permission.md
│   └── Writable_Cron.md
└── 05-proof/
    └── Submission.md
```

## Daftar Isi

| Folder | Topik |
|--------|-------|
| `00-recon/` | Network discovery, port scan, web directory bruteforce |
| `01-initial-foothold/` | SQLi, file upload, SSTI, LFI, command injection |
| `02-reverse-shell/` | Listener, payloads, msfvenom, stabilize TTY |
| `03-enumeration/` | LinPEAS, manual enum, GTFOBins |
| `04-privilege-escalation/` | Kernel LPE, SUID, sudo, cron, weak permission |
| `05-proof/` | Bukti submission (id + hostname) |

## Alur Umum

```text
Recon (nmap) → Web enum → Foothold (SQLi/upload/SSTI/LFI/cmdi)
→ Reverse shell + stabilize → Enum (linpeas + manual) → GTFOBins
→ Privesc (SUID/sudo/cron/weak-perm/KERNEL dirtyfrag-copyfail) →  proof
```
