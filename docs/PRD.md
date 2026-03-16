# 📄 Product Requirements Document (PRD) - EstagiárioPlus

## 1. Visão Geral do Produto
O **EstagiárioPlus** é uma plataforma de gestão do ciclo de vida de estágios, projetada para automatizar o controle de contratos, estudantes, instituições e supervisores. O sistema resolve a fragmentação de dados e garante conformidade com a Lei do Estágio.

## 2. Objetivos Estratégicos
*   **Centralização:** Eliminar planilhas e centralizar todos os dados de estágio.
*   **Compliance:** Garantir que limites de carga horária e proporção estagiário/supervisor sejam respeitados.
*   **Transparência:** Oferecer visibilidade em tempo real de contratos ativos e folhas de ponto.

## 3. Personas (Usuários)
*   **Administrador:** Gestor do RH/Secretaria que configura unidades, supervisores e usuários.
*   **Operador:** Responsável por cadastrar estudantes e formalizar contratos.
*   **Supervisor:** Profissional que acompanha o desempenho e valida a frequência do estagiário.
*   **Estagiário:** (Futuro) Usuário que registra ponto e visualiza seu saldo de recesso.

## 4. Requisitos Funcionais (RF)

### RF01 - Gestão de Cadastros Base
*   **RF01.1 Estudantes:** Cadastro completo com CPF único, dados acadêmicos e bancários.
*   **RF01.2 Instituições:** Cadastro de empresas/órgãos concedentes com CNPJ único e status de convênio.
*   **RF01.3 Supervisores:** Cadastro vinculado a uma Unidade/Subunidade (Lotação).

### RF02 - Gestão de Vagas
*   Permitir abertura de vagas definindo remuneração e lotação.
*   Validar existência de supervisor na subunidade antes da abertura.

### RF03 - Gestão de Contratos (O Elo Central)
*   Vincular Estudante, Instituição, Supervisor e Vaga.
*   Validar datas de vigência e apólice de seguro.
*   Monitorar capacidade da vaga (Ocupada/Aberta).

### RF04 - Controle de Frequência (Folha de Ponto)
*   Registro de entrada/saída com captura de geolocalização.
*   Flag de "Dia de Prova" para redução automática de jornada (conforme Lei).

### RF05 - Avaliação de Desempenho
*   Feedback periódico 360º com notas e comentários qualitativos.

## 5. Requisitos Não Funcionais (RNF)
*   **RNF01 Segurança:** Autenticação via SSO e controle de acesso baseado em papéis (RBAC).
*   **RNF02 Integridade:** Banco de dados relacional (PostgreSQL/MySQL) com chaves estrangeiras rigorosas.
*   **RNF03 Performance:** Tempo de resposta inferior a 2s para listagens e buscas.
*   **RNF04 Interface:** Design responsivo utilizando Tailwind CSS e padrões de UX modernos.

## 6. Arquitetura Técnica (Híbrida)
*   **Legado/Core:** PHP 8+ Modular (Arquitetura de Módulos Independentes).
*   **Modernização:** Frontend em React (Vite) consumindo APIs.
*   **Infraestrutura:** Dockerizado para facilitar o deploy e escalabilidade.

---
*Versão 2.0 - Atualizado em Março/2026 por @Orion*
