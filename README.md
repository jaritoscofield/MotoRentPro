# MotoRent Pro

**Sistema Web para Gestão de Locação de Motos**

O MotoRent Pro é uma plataforma desenvolvida para facilitar e otimizar todo o processo de locação de motos. Criado com foco na simplicidade, eficiência e experiência do usuário, o sistema cobre desde o controle da frota até os pagamentos e histórico de clientes.

---

## 🚀 Funcionalidades Principais

### 1. Painel de Controle (Administração)

Área exclusiva para administradores e funcionários da empresa, com visão completa das operações.

#### 📊 Visão Geral:
- Visualização das motos disponíveis, alugadas e em manutenção.
- Resumo de reservas (diárias, semanais e mensais).
- Relatórios financeiros com receita, despesas e lucros.

#### 🛵 Gestão de Frota:
- Cadastro de motos com dados como modelo, placa, km, status e histórico de manutenção.
- Status de uso: disponível, alugado, manutenção etc.
- Controle de manutenção preventiva e corretiva com agenda de serviços.

#### 👥 Gestão de Clientes:
- Cadastro e gerenciamento de clientes (nome, contato, CNH, histórico de aluguéis).
- Histórico completo de pagamentos e locações.

#### 📅 Gestão de Reservas:
- Registro e agendamento de locações.
- Consulta de disponibilidade em tempo real.
- Bloqueio de motos para manutenção ou férias.

#### 💰 Controle de Pagamentos:
- Cálculo automático com base no período e tipo de aluguel.
- Registro de pagamentos integrais ou parcelados.
- Relatórios financeiros com filtros por período, cliente ou status.

---

### 2. Sistema de Clientes (Frontend)

Área voltada para clientes realizarem suas reservas e acompanharem aluguéis.

#### 🔐 Cadastro e Login:
- Cadastro de novos clientes com validação de documentos (CPF/CNPJ, CNH).
- Acesso com autenticação segura.

#### 🏍️ Consulta de Motos:
- Filtros por modelo, tipo de combustível, preço e disponibilidade.
- Exibição de fotos e detalhes técnicos das motos.

#### 📆 Reservas e Agendamentos:
- Seleção de moto e período de aluguel com cálculo automático.
- Alteração ou cancelamento de reservas com prazo definido.

#### 💳 Pagamento Online:
- Integração com Mercado Pago, PayPal, cartões e Pix.
- Geração de recibos digitais e comprovantes.

#### 📖 Histórico de Aluguéis:
- Visualização de locações anteriores.
- Solicitação de novas reservas com base em histórico.

---

### 3. Funcionalidades Adicionais

#### 🚨 Gestão de Multas e Danos:
- Registro de infrações e danos com possibilidade de cobrança ao cliente.
- Emissão de recibos.

#### 📍 Integração com GPS (opcional):
- Rastreamento em tempo real da frota.
- Alertas em caso de desvios de rota ou comportamento suspeito.

#### 📊 Relatórios e Análises:
- Análise de rentabilidade por moto ou cliente.
- Relatórios de desempenho da frota e fidelidade dos clientes.

---

### 4. Manutenção e Estoque

#### 🧩 Gestão de Estoque:
- Controle de peças de reposição (pneus, óleo, filtros).
- Alertas automáticos para reposição.

#### 🛠️ Agenda de Manutenção:
- Agendamento com notificações de manutenção preventiva.
- Histórico completo de serviços realizados.

---

## 🛠️ Tecnologias Utilizadas

- **Laravel** (Backend PHP)
- **MySQL** (Banco de Dados)
- **Blade / Livewire ou Vue.js** (Frontend)
- **Tailwind CSS** (Estilização)
- **Gateways de Pagamento**: Mercado Pago, PayPal, Pix, etc.
- **APIs Externas**: (opcional) Google Maps, GPS Tracking

---

## 📦 Instalação

```bash
git clone https://github.com/jaritoscofield/MotoRentPro.git
cd MotoRentPro
composer install
cp .env.example .env
php artisan key:generate
# Configure o banco de dados no .env
php artisan migrate
php artisan serve
