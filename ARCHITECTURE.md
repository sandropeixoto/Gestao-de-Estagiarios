# 🏗️ Arquitetura e Padrões Técnicos

Este documento detalha a arquitetura do software, padrões de código (Clean Code, SOLID), convenções de nomenclatura e a estrutura diretorial do projeto.

## 1. Topologia do Sistema

A aplicação é dividida em uma estrutura clássica Cliente-Servidor separada:
- **Frontend (SPA):** Construído com React, manipulando o estado da interface localmente e comunicando-se com a API via `Axios`.
- **Backend (API REST):** Desenvolvido em Node.js com Express e TypeScript, orquestrando as regras de negócio e atuando como middleware entre o cliente e o banco de dados.
- **Banco de Dados:** PostgreSQL (hospedado no Supabase), assegurando integridade relacional.

## 2. Estrutura de Pastas

### Frontend (`/frontend/src/`)
- `/assets`: Imagens, SVGs e arquivos estáticos.
- `/components`: Componentes visuais burros e reutilizáveis (Botões, Modais, Inputs).
- `/pages`: Componentes inteligentes que representam as telas da aplicação (ex: Listagem de Alunos). Gerenciam estado e ciclo de vida.
- `/services`: Classes ou arquivos exportando funções de comunicação HTTP (Axios) para isolar as rotas da API do código de UI.

### Backend (`/backend/src/`)
A arquitetura do servidor segue o padrão MVC adaptado para APIs:
- `/config`: Configurações de ambiente e inicialização de conexões (ex: cliente Supabase/Postgres).
- `/models`: Tipagens TypeScript, interfaces de dados e, se aplicável, lógicas abstratas das entidades.
- `/controllers`: Lógica de processamento das requisições (req, res). Tratam a entrada do cliente, invocam a camada de dados e devolvem a resposta formatada.
- `/routes`: Mapeamento das rotas HTTP (GET, POST, PUT, DELETE) direcionando aos Controllers específicos.
- `app.ts` / `server.ts`: Ponto de entrada da aplicação, configurando middlewares (CORS, Express JSON).

## 3. Padrões e Práticas de Código

### Clean Code e Princípios SOLID
- **Single Responsibility (SRP):** Um Controller cuida exclusivamente de interpretar a requisição HTTP. Um Service no frontend só faz requisições. O UI renderiza.
- **DRY (Don't Repeat Yourself):** Criação de componentes genéricos no frontend e funções utilitárias no backend para reaproveitamento de código.
- **Tratamento de Erros (Error Handling):** Blocos `try/catch` padronizados, devolvendo respostas HTTP semânticas (200 OK, 400 Bad Request, 404 Not Found, 500 Internal Error) do backend.

### Convenções de Nomenclatura (Nomenclature)
- **Classes e Componentes React:** `PascalCase` (ex: `StudentList.jsx`).
- **Arquivos do Backend, Funções e Variáveis:** `camelCase` (ex: `studentController.ts`, `getContractById()`).
- **Nomes de Tabelas no Banco de Dados:** `snake_case` e no plural (ex: `students`, `time_sheets`).
- **Nomes de Colunas no BD:** `snake_case` (ex: `razao_social`, `created_at`).

## 4. Fluxo de Dados (Data Flow)
1. O usuário dispara um evento na UI (Frontend Page).
2. O componente invoca um método no `Service` (Frontend).
3. O `Service` realiza a chamada Axios (HTTP REST) para a `Route` específica do Backend.
4. A `Route` direciona ao `Controller`.
5. O `Controller` valida a regra de negócio e aciona a conexão com o Supabase/Banco de dados para executar a instrução SQL.
6. A resposta transita o caminho de volta (JSON) até atualizar o estado (useState/Context) do React, re-renderizando a tela.
