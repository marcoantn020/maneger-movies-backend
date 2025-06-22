```toml
name = 'update'
method = 'PUT'
url = '{{baseURL}}/movies/9f311f08-d40d-4a79-b9b2-0440493d779e'
sortWeight = 4000000
id = '08f24c0b-2d90-4028-bcc0-99cb3597c6c2'

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
  "synopsis": "Sinopsy Atualizada"
}'''
```
