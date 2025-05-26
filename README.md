# Laravel Marketplace

## Objetivo

Este projeto tem como objetivo fornecer uma estrutura de **marketplace** utilizando o framework **Laravel**, com ambiente de desenvolvimento configurado via **Docker**. Também inclui o acesso ao **phpMyAdmin** para gerenciamento do banco de dados.

### Funcionalidades Principais

- **Gerenciamento de Produtos**  
  Vendedores podem cadastrar, editar e remover produtos com nome, descrição, preço e imagens.

- **Sistema de Carrinho de Compras**  
  Usuários podem adicionar itens ao carrinho, visualizar e finalizar a compra.

- **Processamento de Pedidos**  
  Após checkout, o sistema registra o pedido, atualiza o estoque e notifica o vendedor.

- **Autenticação e Autorização**  
  Suporte a múltiplos papéis (administrador, vendedor, comprador) com login e permissões distintas.

- **Sistema de cupom e desconto**  
  Cupons e descontos para pedidos e produtos com data de validade e validação.

---

## Fluxo Geral

- **Ambiente de Desenvolvimento**
  - Utiliza Docker para a aplicação Laravel e phpMyAdmin.

- **Configuração Inicial**
  - Copia `.env.example` para `.env`.
  - Instala as dependências com Composer.
  - Gera a chave da aplicação.
  - Executa as migrações do banco de dados.

- **Acesso às Interfaces**
  - Backend: `http://localhost:8005/api`
  - phpMyAdmin: `http://localhost:8075`

---

## Fluxo Detalhado

### 1. Subir o Container

```bash
docker compose up --build -d
```

---

### 2. Configuração Inicial

#### Criar o arquivo `.env`

Copiar o `.env.example` para `.env` dentro da pasta `/src`.

#### Acessar o terminal do container

```bash
docker compose exec --user 1000:1000 php sh
```

#### Instalar as dependências

```bash
composer update
```

#### Gerar a chave da aplicação

```bash
php artisan key:generate
```

#### Executar as migrações

```bash
php artisan migrate
```

---

### 3. Acesso às Interfaces

- **Backend:**  
  `http://localhost:8005/api`

- **phpMyAdmin:**  
  `http://localhost:8075`  
  **Usuário:** `root`  
  **Senha:** `root`

---

## Observações Importantes

- Todos os comandos Docker devem ser executados a partir da pasta onde está o `docker-compose.yml`.
- Comandos Laravel devem ser executados dentro do container (`docker compose exec`).

---

## Dicas para Usuários Windows

- Evite rodar diretamente no Windows nativo (incompatibilidades PHP).
- Use **Laragon** ou **WSL (Windows Subsystem for Linux)** para maior estabilidade e compatibilidade.
