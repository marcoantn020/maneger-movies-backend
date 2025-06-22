```toml
name = 'signup'
method = 'POST'
url = '{{baseURL}}/signup'
sortWeight = 5000000
id = '7e4f62ad-2df8-43ba-9860-192226d2442f'

[[headers]]
key = 'Content-Type'
value = 'application/json'
disabled = true

[[headers]]
key = 'Accept'
value = 'application/json'

[auth.bearer]
token = '{{token}}'

[[body.formData]]
key = 'first_name'
value = 'Usuario'

[[body.formData]]
key = 'email'
value = 'teste@mail.com'

[[body.formData]]
key = 'password'
value = 'password'

[[body.formData]]
key = 'password_confirmation'
value = 'password'

[[body.formData]]
key = 'phone'
value = '12345-6789'

[[body.formData]]
type = 'FILE'
key = 'photo'
value = '/home/marco-antonio/Imagens/no-image.jpeg'

[[body.formData]]
key = 'last_name'
value = 'Teste'
```
