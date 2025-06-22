```toml
name = 'Login'
method = 'POST'
url = '{{baseURL}}/login'
sortWeight = 1000000
id = '417ddf68-f1ae-4e22-b2e2-eb9646cb6c1a'

[[headers]]
key = 'Content-Type'
value = 'application/json'

[[headers]]
key = 'Accept'
value = 'application/json'

[body]
type = 'JSON'
raw = '''
{
  "email": "marco@mail.com",
  "password": "password"
}'''
```
