# 🎨 Design System e Padrões de Interface

Este documento define a linguagem visual da plataforma, garantindo consistência em toda a interface construída com Tailwind CSS.

## 1. Paleta de Cores

A aplicação utiliza uma paleta de cores moderna e acessível, baseada em tons de roxo vibrante (`primary`) sobre um fundo de alto contraste, mas suave para leitura.

| Nome da Cor | Variável Tailwind | Hexadecimal | Uso Principal |
| :--- | :--- | :--- | :--- |
| **Primary** | `text-primary`, `bg-primary` | `#7C3AED` | Ações principais, botões de submissão, destaques ativos. |
| **Secondary** | `text-secondary`, `bg-secondary` | `#A78BFA` | Ações secundárias, hover states, backgrounds sutis. |
| **CTA** | `bg-cta`, `text-cta` | `#F97316` | Call to Actions críticos, alertas importantes (laranja vibrante). |
| **Background** | `bg-background` | `#FAF5FF` | Cor de fundo predominante das páginas (tom lavanda bem claro). |
| **Brand Text** | `text-brandText` | `#4C1D95` | Títulos e textos de grande destaque (roxo escuro profundo). |
| **Muted** | `text-muted` | `#6B7280` | Textos descritivos, placeholders e bordas inativas. |

## 2. Tipografia

- **Família de Fonte:** `"Plus Jakarta Sans"`, sans-serif.
- Escolhida por sua excelente legibilidade em interfaces digitais, proporções geométricas e aparência profissional e moderna.

## 3. Diretrizes de UI/UX

### A. Componentes Padronizados
- **Cards:** Utilizados para encapsular formulários e listas. Devem possuir cantos arredondados (ex: `rounded-xl`) e sombras suaves (`shadow-sm` ou `shadow-md`) para destacar o bloco sobre o background `#FAF5FF`.
- **Botões:**
  - Botões primários usam `bg-primary` com texto branco. Hover com leve alteração de opacidade ou escala.
  - Botões secundários ou de cancelamento utilizam cores neutras ou contornos (outline).
- **Inputs de Formulário:** Focados em acessibilidade, contendo padding generoso, contornos em `border-gray-300` e estados de foco (`focus:ring-2 focus:ring-primary`) bem definidos.

### B. Feedback e Interação (UX)
- **Ícones:** Utilização massiva da biblioteca `Lucide React` para guiar a ação do usuário (ex: lixeiras para exclusão, lápis para edição).
- **Confirmação de Destruição:** Qualquer exclusão de entidade (Estudante, Contrato, etc.) exige uma ação de confirmação clara, seja por modal ou diálogo nativo.
- **Micro-interações:** Hover states explícitos em tabelas e botões para garantir a percepção tátil da interface digital.
