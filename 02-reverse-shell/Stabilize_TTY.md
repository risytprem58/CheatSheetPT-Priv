# Stabilkan Shell (TTY)

Setelah dapat reverse shell, stabilkan agar interaktif (autocomplete, clear, dll).

```bash
python3 -c 'import pty;pty.spawn("/bin/bash")'
```

```bash
echo os.system('/bin/bash')
```

```bash
/bin/sh -i
```

```bash
script -qc /bin/bash /dev/null
```

```bash
perl -e 'exec "/bin/sh";'
```