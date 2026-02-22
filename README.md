# Gestão de Estagiários

Sistema moderno de gestão de estágios desenvolvido para administrar estudantes, instituições (empresas concedentes), supervisores e contratos de estágio.

## Situação Atual do Projeto (Fevereiro/2026)

O projeto passou recentemente por uma migração para utilizar o **Supabase** (PostgreSQL) como banco de dados principal e backend as a service, substituindo a infraestrutura legada.

### Funcionalidades Implementadas

O sistema atualmente conta com operações **CRUD (Create, Read, Update, Delete)** completas para todas as entidades principais:

*   **🧑‍🎓 Estudantes:**
    *   Listagem completa.
    *   Cadastro com validação de dados (Nome, CPF, Curso, Semestre, Previsão de Formatura, Dados Bancários).
    *   Edição de registros existentes.
    *   Exclusão com confirmação.
*   **🏢 Instituições (Empresas):**
    *   Listagem completa.
    *   Cadastro de concedentes (Razão Social, CNPJ, Endereço, Contato, Representante Legal).
    *   Edição de registros existentes.
    *   Exclusão com confirmação.
*   **👨‍💼 Supervisores:**
    *   Listagem completa.
    *   Cadastro de supervisores de estágio vinculados às áreas e cargos.
    *   Edição e exclusão de registros.
*   **📄 Contratos:**
    *   Listagem completa de contratos de estágio.
    *   Criação de contratos vinculando Estudante, Instituição e Supervisor.
    *   Definição de valores de bolsa e transporte, datas de início e fim, vigência e apólice de seguro.
    *   Edição de status (Ex: Ativo / Encerrado) e demais dados do contrato.
    *   Exclusão de contratos.

### Stack Tecnológica

*   **Frontend:** React, Vite, Tailwind CSS, Lucide React, Axios.
*   **Backend:** Node.js, Express, TypeScript.
*   **Database & Auth:** Supabase (PostgreSQL).

## Como Executar

O projeto é dividido em duas pastas principais: `frontend` e `backend`.

### Backend
\`\`\`bash
cd backend
npm install
npm run dev
\`\`\`
*(É necessário ter as variáveis de ambiente configuradas no arquivo `.env` contendo as chaves do Supabase e a porta do servidor).*

### Frontend
\`\`\`bash
cd frontend
npm install
npm run dev
\`\`\`
*(A aplicação frontend estará disponível em `http://localhost:5173`)*
