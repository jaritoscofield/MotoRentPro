# Estrutura do Projeto MotoRentPro

## 📁 Organização Modular

### 🎨 **Views**
```
resources/views/
├── layouts/
│   └── app.blade.php              # Layout base da aplicação
├── components/
│   ├── header.blade.php           # Componente de cabeçalho
│   ├── logo.blade.php             # Componente de logo
│   ├── login-form.blade.php       # Componente de formulário de login
│   └── alert.blade.php            # Componente de alertas/mensagens
├── modules/
│   ├── auth/
│   │   └── login.blade.php        # Tela de login
│   └── dashboard/
│       └── index.blade.php        # Dashboard principal
└── welcome.blade.php              # Página inicial
```

### 🎯 **Controllers**
```
app/Http/Controllers/
├── AuthController.php             # API de autenticação
├── UserController.php             # CRUD de usuários (API)
├── LoginController.php            # Login web
└── DashboardController.php        # Dashboard
```

### 🛡️ **Middleware**
```
app/Http/Middleware/
└── AdminMiddleware.php            # Verificação de admin
```

### 🗄️ **Models**
```
app/Models/
└── User.php                       # Modelo de usuário com papéis
```

## 🎨 **Design System**

### **Classes CSS Personalizadas**
- `.btn-primary` - Botão primário azul
- `.btn-secondary` - Botão secundário cinza
- `.form-input` - Campo de formulário
- `.form-label` - Label de formulário
- `.card` - Card com sombra e borda

### **Cores**
- **Primária**: Azul (#2563eb)
- **Secundária**: Cinza (#6b7280)
- **Sucesso**: Verde (#10b981)
- **Erro**: Vermelho (#ef4444)
- **Aviso**: Amarelo (#f59e0b)
- **Info**: Azul claro (#3b82f6)

## 🔧 **Funcionalidades**

### **Autenticação**
- ✅ Login com email e senha
- ✅ Logout seguro
- ✅ Redirecionamento após login
- ✅ Mensagens de feedback
- ✅ Validação de credenciais

### **Sistema de Papéis**
- ✅ Admin (acesso total)
- ✅ User (acesso limitado)
- ✅ Middleware de proteção

### **Interface**
- ✅ Design responsivo
- ✅ Componentes reutilizáveis
- ✅ Layout modular
- ✅ Ícones FontAwesome
- ✅ Tailwind CSS

## 🚀 **Rotas**

### **Web**
- `GET /` - Página inicial
- `GET /login` - Tela de login
- `POST /login` - Processar login
- `POST /logout` - Logout
- `GET /dashboard` - Dashboard (protegido)

### **API**
- `POST /api/register` - Registro
- `POST /api/login` - Login API
- `POST /api/logout` - Logout API
- `GET /api/me` - Usuário atual
- `GET /api/users` - Listar usuários (admin)
- `POST /api/users` - Criar usuário (admin)
- `GET /api/users/{id}` - Ver usuário (admin)
- `PUT /api/users/{id}` - Atualizar usuário (admin)
- `DELETE /api/users/{id}` - Excluir usuário (admin)

## 👤 **Usuários Padrão**

### **Admin**
- Email: admin@motorentpro.com
- Senha: admin123
- Papel: admin

### **Usuário**
- Email: user@motorentpro.com
- Senha: user123
- Papel: user

## 📱 **Responsividade**

- ✅ Desktop (1024px+)
- ✅ Tablet (768px - 1023px)
- ✅ Mobile (320px - 767px)

## 🔒 **Segurança**

- ✅ CSRF Protection
- ✅ Validação de dados
- ✅ Sessões seguras
- ✅ Middleware de autenticação
- ✅ Middleware de autorização
- ✅ Sanitização de inputs

## 🎯 **Próximos Passos**

1. **Módulo de Motos**
   - CRUD de motos
   - Categorias
   - Status (disponível/alugada)

2. **Módulo de Clientes**
   - Cadastro de clientes
   - Histórico de aluguéis

3. **Módulo de Aluguéis**
   - Criar aluguel
   - Calcular valores
   - Status de pagamento

4. **Relatórios**
   - Relatório de vendas
   - Relatório de motos
   - Dashboard com gráficos 