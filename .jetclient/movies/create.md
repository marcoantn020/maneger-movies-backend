```toml
name = 'create'
method = 'POST'
url = '{{baseURL}}/movies'
sortWeight = 2000000
id = '93a224a6-a418-4072-b8ab-f3e225314412'

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
  "title": "Lendas do Crime",
  "year": 2003,
  "genre": 'crime',
  "synopsis": "Uma sinopsy"
}'''
```
