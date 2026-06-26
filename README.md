# 🚛 TrackMultas

**Sistema de Gestão de Multas para Transportadoras**

Sistema web desenvolvido em PHP com padrão MVC para gerenciamento completo de multas de trânsito em frotas de veículos.

---

## 📋 Objetivo

O TrackMultas tem como objetivo oferecer uma solução prática e eficiente para transportadoras controlarem:

- Cadastro de motoristas, veículos e proprietários
- Registro e acompanhamento de multas de trânsito
- Dashboard com indicadores e relatórios gerenciais
- Controle de prazos, recursos e pagamentos de infrações

---

## 🛠️ Tecnologias

| Tecnologia | Uso |
|---|---|
| **PHP 7+** | Back-end com padrão MVC |
| **MySQL** | Banco de dados relacional |
| **PDO** | Conexão segura com prepared statements |
| **Bootstrap 5** | Framework CSS responsivo (via CDN) |
| **JavaScript** | Interatividade no front-end |
| **HTML5 / CSS3** | Estrutura e estilização |

---

## 📁 Estrutura MVC

```
trackmultas/
├── app/
│   ├── controllers/     # Controllers do sistema
│   │   └── HomeController.php
│   ├── models/          # Models e conexão com banco
│   │   └── Database.php
│   └── views/           # Views organizadas por módulo
│       ├── layout/
│       │   ├── header.php
│       │   └── footer.php
│       └── home/
│           └── index.php
├── config/
│   └── config.php       # Configurações do sistema
├── database/
│   └── script.sql       # Script de criação do banco
├── public/
│   ├── index.php        # Roteador principal (entry point)
│   ├── .htaccess        # Reescrita de URL
│   └── assets/
│       ├── css/
│       │   └── style.css
│       └── js/
│           └── script.js
├── README.md
└── .gitignore
```

---

## 📦 Módulos Previstos

### 1. Cadastros
- CRUD de Motoristas
- CRUD de Veículos
- CRUD de Proprietários

### 2. Controle de Multas
- Registro de infrações
- Vinculação com motorista e veículo
- Controle de status (pendente, paga, recorrida)
- Controle de prazos

### 3. Dashboard
- Total de multas por período
- Ranking de motoristas com mais infrações
- Gráficos e indicadores visuais
- Relatórios exportáveis

---

## 🗄️ Banco de Dados

O projeto utiliza **MySQL** (ou MariaDB) como banco de dados relacional. O script de criação completo está localizado em `database/script.sql` e cria o banco de dados chamado **trackmultas** com charset `utf8mb4`.

### Principais Tabelas

| Tabela | Descrição |
|---|---|
| `empresas` | Cadastro de empresas/transportadoras |
| `setores` | Setores internos (Motorista, Outros) |
| `status_motoristas` | Status do motorista (Ativo, Afastado, Desligado, Não Admitido) |
| `motoristas` | Cadastro de motoristas vinculados a empresa, setor e status |
| `tipos_veiculos` | Tipos de veículos (Cavalo, Carreta, Carro, Caminhoneta, Moto) |
| `veiculos` | Cadastro de veículos com placa e renavam únicos |
| `orgaos` | Órgãos autuadores (Detran, PRF, DNIT, Prefeitura, ANTT) |
| `motivos_infracoes` | Motivos das infrações com código e pontuação |
| `responsabilidades` | Responsabilidade pela multa (Motorista, Empresa, Compartilhada, Embarcador) |
| `status_andamento_multa` | Etapas de andamento da multa |
| `status_pagamento` | Status de pagamento (Pago, A Pagar, Cancelada, etc.) |
| `multas` | Tabela principal de multas com todos os vínculos |

### Principais Relacionamentos

- **Motoristas** → pertencem a uma `empresa`, um `setor` e possuem um `status`
- **Veículos** → possuem um `tipo de veículo`
- **Multas** → vinculadas a um `motorista`, `veículo`, `órgão autuador`, `motivo de infração`, `responsabilidade`, `status do motorista`, `status de andamento` e `status de pagamento`
- **Multa de Origem** (`multa_origem_id`) → permite vincular uma segunda multa à multa original. Esse campo é utilizado quando uma infração gera desdobramentos (por exemplo, uma multa NIC que resulta em nova penalidade), mantendo a rastreabilidade entre elas.

---

## 🚀 Como Executar

### Pré-requisitos

- **PHP 7.4+** instalado
- **MySQL 5.7+** ou **MariaDB**
- **Apache** com `mod_rewrite` habilitado (XAMPP, WAMP, Laragon, etc.)

### Passo a passo

1. **Clone ou copie** a pasta `trackmultas` para o diretório do servidor web:
   ```
   C:\xampp\htdocs\trackmultas\
   ```

2. **Crie o banco de dados** executando o script SQL:
   ```
   mysql -u root < database/script.sql
   ```

3. **Configure** o arquivo `config/config.php` com seus dados de conexão (se necessário).

4. **Acesse** no navegador:
   ```
   http://localhost/trackmultas/public/
   ```

---

## 📄 Licença

Este projeto é de uso interno e educacional.

---

> Desenvolvido com ❤️ para facilitar a gestão de multas em transportadoras.
