```toml
name = 'list'
method = 'GET'
url = '{{baseURL}}/movies?search=Rem'
sortWeight = 1000000
id = '00d217b5-f280-4c1c-8173-368a967bbf84'

[[queryParams]]
key = 'page'
value = '4'
disabled = true

[[queryParams]]
key = 'search'
value = 'Rem'

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
