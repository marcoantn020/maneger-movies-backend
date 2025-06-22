```toml
name = 'Refresh token'
method = 'POST'
url = '{{baseURL}}/refresh'
sortWeight = 3000000
id = '4a40886a-159a-43ad-a66c-9d9475140744'

[[headers]]
key = 'Content-Type'
value = 'application/json'

[[headers]]
key = 'Accept'
value = 'application/json'

[auth.bearer]
token = '{{token'

[body]
type = 'JSON'
raw = '''
{
  "email": "marco@mail.com",
  "password": "password"
}'''
```
