# Gestão de Estagiários 🎓

🚀 **Visão Geral**
O **Gestão de Estagiários** é uma plataforma corporativa de alta performance, projetada para orquestrar o ciclo de vida completo de programas de estágio. O sistema atua como o ponto de convergência entre estudantes, instituições de ensino, empresas concedentes e supervisores, automatizando fluxos burocráticos que tradicionalmente consomem centenas de horas administrativas. Ao centralizar dados acadêmicos, jurídicos e financeiros em uma interface intuitiva, a solução transforma a gestão de talentos em um processo estratégico e orientado a dados.

Modernizada a partir de uma arquitetura legada, a plataforma agora utiliza o que há de mais avançado em tecnologias web. Com uma infraestrutura baseada em Supabase, o sistema oferece escalabilidade elástica, segurança de nível bancário para dados sensíveis (como CPFs e dados bancários) e uma experiência de usuário (UX) fluida, capaz de suportar desde pequenas operações até grandes secretarias estatais com hierarquias complexas de lotação.

💡 **O Problema e a Solução**
*   **O Problema:** A gestão de estágios é frequentemente fragmentada em planilhas, arquivos físicos e e-mails. Isso gera riscos jurídicos (descumprimento da Lei do Estágio), falhas no controle de frequência (fraudes no ponto), cálculos errôneos de recesso remunerado e uma sobrecarga invisível sobre os supervisores de área.
*   **A Solução:** Uma plataforma "All-in-One" que implementa travas lógicas rigorosas. O sistema impede automaticamente a criação de contratos que excedam o limite legal de estagiários por supervisor ou a duração máxima permitida. Além disso, introduz transparência total através de dashboards em tempo real e monitoramento por geolocalização para as folhas de ponto.

🛠️ **Arquitetura e Stack Tecnológico**
*   **Frontend:** React.js 19 com Vite, utilizando Tailwind CSS 4 para uma interface responsiva e moderna. A escolha do React garante uma SPA (Single Page Application) rápida, enquanto o Tailwind permite um design system consistente e de fácil manutenção.
*   **Backend:** Node.js com Express e TypeScript. O uso de TypeScript traz segurança de tipos, reduzindo bugs em tempo de execução e facilitando a manutenção de regras de negócio complexas.
*   **Banco de Dados & Auth:** Supabase (Postgres). A escolha pelo Postgres garante a integridade relacional necessária para o elo "Estudante-Instituição-Supervisor-Vaga", enquanto o Supabase acelera o desenvolvimento com APIs automáticas e autenticação robusta.
*   **Design System:** Baseado na fonte *Plus Jakarta Sans* e paleta lavanda/roxo, focado em legibilidade e redução de fadiga visual para usuários intensivos.

✨ **Funcionalidades Principais**
*   **Dashboard Inteligente:** Visualização imediata de KPIs como total de estudantes, contratos ativos, taxa de efetivação e alertas de contratos a vencer.
*   **Controle Rigoroso de Contratos:** Gestão do "Elo Central" validando automaticamente a disponibilidade de vagas em subunidades e a capacidade dos supervisores.
*   **Folha de Ponto Digital com GPS:** Registro de jornada com captura de geolocalização, incluindo lógica de "Dia de Prova" (redução automática de carga horária conforme a lei).
*   **Módulo de Avaliações:** Feedback 360º entre supervisor e estagiário, gerando notas de competências técnicas e comportamentais.
*   **Gestão Financeira:** Cálculo automatizado de saldos de recesso remunerado e histórico de pagamentos de bolsa e auxílio-transporte.
*   **Hierarquia de Lotações:** Mapeamento detalhado de Unidades e Subunidades para garantir que cada estagiário esteja vinculado ao local correto de atuação.

📈 **Diferenciais e Valor de Mercado**
*   **Compliance Automático:** O sistema é um "advogado digital", garantindo que a empresa nunca infrinja as leis trabalhistas específicas de estágio.
*   **Integridade de Dados:** O rastreamento por geolocalização na folha de ponto eleva a confiabilidade do controle de frequência a níveis impossíveis em métodos manuais.
*   **UX Premium:** Diferente de sistemas corporativos "cinzas" e pesados, a plataforma utiliza micro-interações e um design moderno que aumenta a adoção pelos usuários e reduz o tempo de treinamento.

🛠 **Como o Sistema Funciona (User Flow)**
1.  **Onboarding de Infraestrutura:** Cadastram-se as Instituições e as Lotações (Unidades/Subunidades).
2.  **Configuração de Vagas:** Gestores abrem vagas definindo a remuneração, requisitos e vinculando a uma lotação específica.
3.  **Formalização do Contrato:** Ao vincular um Estudante a uma Vaga, o sistema valida supervisor, datas e documentos. Se tudo estiver em conformidade, o contrato é ativado.
4.  **Operação Diária:** O estagiário registra pontos (com GPS); o supervisor acompanha o desempenho através do módulo de avaliações.
5.  **Encerramento/Recesso:** O sistema calcula o saldo financeiro final e o tempo de recesso, garantindo um desligamento ou renovação sem erros de cálculo.

🚀 **Roadmap (Próximos Passos)**
*   📱 **App Mobile Nativo:** Expansão da experiência do estagiário para registro de ponto via biometria facial.
*   📑 **Assinatura Digital:** Integração com serviços de assinatura (DocuSign/Gov.br) para eliminar o papel nos contratos.
*   🤖 **Predição de Efetivação:** IA para analisar as avaliações e sugerir quais talentos têm maior probabilidade de sucesso em uma futura contratação efetiva.
