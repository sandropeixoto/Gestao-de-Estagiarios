# 🎓 EstagiárioPlus - Gestão Inteligente de Estágios

O **EstagiárioPlus** é uma plataforma corporativa de alto desempenho projetada para gerir o ciclo de vida completo de programas de estágio, garantindo conformidade legal (Lei do Estágio) e eficiência administrativa.

---

## 🚀 Visão Geral
O sistema atua como ponto central entre Estudantes, Instituições, Empresas e Supervisores. Com uma arquitetura moderna e segura, automatiza desde a abertura de vagas até o controle de frequência por geolocalização.

## 🏛️ Arquitetura do Sistema
O projeto segue uma estrutura híbrida e modular para garantir estabilidade e evolução tecnológica:

- **Core & Business Logic:** PHP 8.3+ com arquitetura modular baseada em domínio (`/modules/`).
- **Modernização Frontend:** SPA construída com React 19, Vite e Tailwind CSS 4.
- **Banco de Dados:** PostgreSQL / MySQL com integridade referencial rigorosa.
- **Segurança:** Autenticação via SSO e RBAC (Role-Based Access Control).
- **Infraestrutura:** Dockerizado para deploy em GCP (Google Cloud Run/Build).

---

## 📂 Estrutura de Pastas Principal
- `/modules/`: Módulos independentes de negócio (Contratos, Estudantes, Vagas, etc.).
- `/frontend/`: Aplicação moderna em React.
- `/src/Models/`: Camada de dados centralizada.
- `/public/`: Entrypoint do servidor e autenticação.
- `/backend_legacy/`: Componentes originais em fase de migração.

---

## 🛠️ Stack Tecnológica
- **Backend:** PHP 8+ (Core), Node.js (API de modernização).
- **Frontend:** React, Vite, Tailwind CSS, Lucide Icons.
- **Banco de Dados:** PostgreSQL (Supabase) / MySQL.
- **DevOps:** Docker, Cloud Build, Google Cloud Platform.

---

## 📖 Documentação Adicional
Para detalhes mais profundos, consulte:
- [📄 PRD (Product Requirements Document)](docs/PRD.md)
- [📖 Guia do Usuário](docs/USER_GUIDE.md)
- [🏗️ Arquitetura e Padrões Técnicos](ARCHITECTURE.md)
- [📋 Regras de Negócio](BUSINESS_RULES.md)
- [💎 Guia de Replicação de UI](UI_UX_REPLICATION_GUIDE.md)

---

## 📦 Como Executar (Ambiente de Desenvolvimento)

### Requisitos
- PHP 8.1+ ou Docker.
- Node.js 18+.

### Passos
1. **Clonar Repositório:** `git clone ...`
2. **Backend/PHP:** Configure o seu servidor local para apontar para `/public/`.
3. **Frontend (React):**
   ```bash
   cd frontend
   npm install
   npm run dev
   ```
4. **Variáveis de Ambiente:** Copie `.env.example` para `.env` e configure suas credenciais.

---
*EstagiárioPlus - 2026. Desenvolvido com @aiox-framework.*
