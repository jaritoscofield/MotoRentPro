# API Documentation - MotoRentPro

## Autenticação

O sistema usa Laravel Sanctum para autenticação via tokens.

### Endpoints de Autenticação

#### 1. Registro de Usuário
```
POST /api/register
```

**Body:**
```json
{
    "name": "Nome do Usuário",
    "email": "usuario@email.com",
    "password": "senha123",
    "password_confirmation": "senha123",
    "role": "user" // opcional, padrão: "user"
}
```

**Resposta:**
```json
{
    "message": "Usuário registrado com sucesso",
    "user": {
        "id": 1,
        "name": "Nome do Usuário",
        "email": "usuario@email.com",
        "role": "user",
        "created_at": "2025-07-30T14:00:00.000000Z",
        "updated_at": "2025-07-30T14:00:00.000000Z"
    },
    "token": "1|abc123..."
}
```

#### 2. Login
```
POST /api/login
```

**Body:**
```json
{
    "email": "usuario@email.com",
    "password": "senha123"
}
```

**Resposta:**
```json
{
    "message": "Login realizado com sucesso",
    "user": {
        "id": 1,
        "name": "Nome do Usuário",
        "email": "usuario@email.com",
        "role": "user"
    },
    "token": "1|abc123..."
}
```

#### 3. Logout
```
POST /api/logout
```

**Headers:**
```
Authorization: Bearer {token}
```

**Resposta:**
```json
{
    "message": "Logout realizado com sucesso"
}
```

#### 4. Obter Usuário Atual
```
GET /api/me
```

**Headers:**
```
Authorization: Bearer {token}
```

**Resposta:**
```json
{
    "user": {
        "id": 1,
        "name": "Nome do Usuário",
        "email": "usuario@email.com",
        "role": "user"
    }
}
```

## CRUD de Usuários (Apenas Admin)

### Endpoints de Usuários

#### 1. Listar Todos os Usuários
```
GET /api/users
```

**Headers:**
```
Authorization: Bearer {token}
```

**Resposta:**
```json
{
    "users": [
        {
            "id": 1,
            "name": "Administrador",
            "email": "admin@motorentpro.com",
            "role": "admin"
        },
        {
            "id": 2,
            "name": "Usuário Teste",
            "email": "user@motorentpro.com",
            "role": "user"
        }
    ]
}
```

#### 2. Criar Usuário
```
POST /api/users
```

**Headers:**
```
Authorization: Bearer {token}
```

**Body:**
```json
{
    "name": "Novo Usuário",
    "email": "novo@email.com",
    "password": "senha123",
    "role": "user"
}
```

**Resposta:**
```json
{
    "message": "Usuário criado com sucesso",
    "user": {
        "id": 3,
        "name": "Novo Usuário",
        "email": "novo@email.com",
        "role": "user"
    }
}
```

#### 3. Obter Usuário Específico
```
GET /api/users/{id}
```

**Headers:**
```
Authorization: Bearer {token}
```

**Resposta:**
```json
{
    "user": {
        "id": 1,
        "name": "Administrador",
        "email": "admin@motorentpro.com",
        "role": "admin"
    }
}
```

#### 4. Atualizar Usuário
```
PUT /api/users/{id}
```

**Headers:**
```
Authorization: Bearer {token}
```

**Body:**
```json
{
    "name": "Nome Atualizado",
    "email": "atualizado@email.com",
    "role": "admin"
}
```

**Resposta:**
```json
{
    "message": "Usuário atualizado com sucesso",
    "user": {
        "id": 1,
        "name": "Nome Atualizado",
        "email": "atualizado@email.com",
        "role": "admin"
    }
}
```

#### 5. Excluir Usuário
```
DELETE /api/users/{id}
```

**Headers:**
```
Authorization: Bearer {token}
```

**Resposta:**
```json
{
    "message": "Usuário excluído com sucesso"
}
```

## Usuários Padrão

### Admin
- **Email:** admin@motorentpro.com
- **Senha:** admin123
- **Papel:** admin

### Usuário
- **Email:** user@motorentpro.com
- **Senha:** user123
- **Papel:** user

## Códigos de Status HTTP

- `200` - Sucesso
- `201` - Criado com sucesso
- `400` - Erro de validação
- `401` - Não autorizado
- `403` - Acesso negado (apenas admin)
- `404` - Não encontrado
- `422` - Erro de validação

## Exemplo de Uso com cURL

### Login
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@motorentpro.com",
    "password": "admin123"
  }'
```

### Listar Usuários (com token)
```bash
curl -X GET http://localhost:8000/api/users \
  -H "Authorization: Bearer {seu_token_aqui}" \
  -H "Content-Type: application/json"
``` 