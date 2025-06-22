```toml
name = 'logout'
method = 'POST'
url = '{{baseURL}}/logout'
sortWeight = 4000000
id = '54be0361-bbc9-43b7-b261-b00b1ccec7f8'

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
  "email": "marco@mail.com",
  "password": "password"
}'''
```
