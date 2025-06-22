```toml
name = 'find'
method = 'GET'
url = '{{baseURL}}/movies/9f311f08-d40d-4a79-b9b2-0440493d779e'
sortWeight = 3000000
id = 'f490c7ef-8104-49ad-ab1c-e168a5186952'

[[queryParams]]
key = 'page'
value = '4'
disabled = true

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
raw = '''
{
  "last_name": "Atualizado",
  "phone": "99832-3232"
}'''
```
