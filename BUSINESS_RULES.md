# 📋 Regras de Negócio (Business Rules)

Este documento mapeia o comportamento esperado do sistema de Gestão de Estagiários, as restrições lógicas e o fluxo de dados entre as entidades principais baseadas no esquema do banco de dados relacional.

## 1. Entidades Principais e Relacionamentos

### 🏢 Instituições (Empresas Concedentes)
- **Regras:**
  - O CNPJ deve ser **único** no sistema.
  - Uma instituição possui um Status de Convênio (`Ativo` ou `Inativo`).
  - Instituições inativas não podem ser vinculadas a novos contratos de estágio.

### 🧑‍🎓 Estudantes (Estagiários)
- **Regras:**
  - O CPF deve ser **único** no sistema.
  - O cadastro exige controle de dados acadêmicos (Curso, Semestre, Previsão de Formatura) e financeiros (Dados Bancários para pagamento de bolsa).
  - É possível anexar um caminho/link para o comprovante de matrícula.

### 👨‍💼 Supervisores
- **Regras:**
  - Devem ser vinculados a uma área e a um cargo específico.
  - São fundamentais para a avaliação de desempenho e assinatura de controle de frequência.

### 📄 Contratos (O Elo Central)
- **Regras:**
  - Um contrato é a união obrigatória de: **1 Estudante + 1 Instituição + 1 Supervisor**.
  - **Datas:** Exige Data de Início e Data de Fim.
  - **Valores:** Mantém registro de Valor da Bolsa e Valor do Auxílio Transporte.
  - **Status:** Possui status que varia entre `Ativo` e `Encerrado`.
  - **Seguro:** Deve conter o registro da apólice de seguro do estagiário.

## 2. Módulos Operacionais

### 🕒 Folha de Ponto (TimeSheets)
- Registra a jornada diária vinculada a um contrato específico.
- **Geolocalização:** Captura a localização exata de onde o ponto foi batido (Entrada/Saída).
- **Dias de Prova:** Contém uma flag booleana (`is_dia_prova`), o que por lei reduz a jornada diária do estagiário pela metade.

### 📈 Avaliações (Evaluations)
- Avaliações periódicas do estagiário.
- Armazena feedback qualitativo de competências técnicas e comportamentais.
- Registra feedbacks textuais do supervisor e do estagiário, gerando uma Nota final.

### 💰 Financeiro (Financials)
- Módulo para acompanhamento financeiro de cada contrato.
- Calcula e armazena o saldo de recesso remunerado (férias do estagiário) e os pagamentos mensais já realizados.
