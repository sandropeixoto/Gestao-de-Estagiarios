# Gestão de Estagiários

Sistema moderno e escalável para a gestão completa do ciclo de vida de estágios, administrando estudantes, instituições concedentes, supervisores e os contratos firmados entre eles.

## 🚀 Visão Geral
A plataforma automatiza e centraliza a gestão de estágios. Originalmente construído sobre uma arquitetura legada, o projeto foi modernizado para utilizar o **Supabase** (PostgreSQL) como banco de dados principal, garantindo maior performance, segurança e escalabilidade.

## 🛠️ Stack Tecnológica

- **Frontend:** React.js, Vite, Tailwind CSS, Lucide React (ícones), Axios.
- **Backend:** Node.js, Express.js, TypeScript.
- **Database & Auth:** Supabase (PostgreSQL).

## 📦 Instalação e Configuração

O projeto é estruturado em dois monorepos lógicos (Frontend e Backend). Siga as etapas abaixo para execução local.

### 1. Configuração do Backend
```bash
cd backend
npm install
```
Certifique-se de configurar o arquivo `.env` na raiz da pasta `backend` com as seguintes variáveis:
```env
SUPABASE_URL=sua_url_aqui
SUPABASE_ANON_KEY=sua_chave_aqui
PORT=porta_do_servidor
```
Para iniciar o servidor:
```bash
npm run dev
```

### 2. Configuração do Frontend
Em um novo terminal:
```bash
cd frontend
npm install
```
Para iniciar a interface:
```bash
npm run dev
```
A aplicação estará disponível por padrão em `http://localhost:5173`.
