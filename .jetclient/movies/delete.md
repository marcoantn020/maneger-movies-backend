```toml
name = 'delete'
method = 'DELETE'
url = '{{baseURL}}/movies/9f311f08-d40d-4a79-b9b2-0440493d779e'
sortWeight = 5000000
id = '0c998974-ad1b-4c53-b558-8fdad9b25b58'

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
```
