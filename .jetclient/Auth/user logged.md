```toml
name = 'user logged'
method = 'GET'
url = '{{baseURL}}/me'
sortWeight = 2000000
id = 'b8a26189-bf21-4d3e-8148-aba05975ad4d'

[[headers]]
key = 'Content-Type'
value = 'application/json'

[[headers]]
key = 'Accept'
value = 'application/json'

[auth.bearer]
token = '{{token}}'

[body]
type = 'JSON'
```
