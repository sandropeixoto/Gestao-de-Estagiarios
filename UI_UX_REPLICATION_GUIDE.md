# 💎 Guia de Replicação de Interface (UI/UX Standard)

Este documento descreve o padrão visual e técnico do sistema **EstagiárioPlus**, servindo como especificação para replicação de interface em outros módulos ou sistemas.

---

## 🏗️ Estrutura de Layout (Main Shell)

O sistema utiliza um layout de **Dashboard Administrativo Pro** com foco em produtividade e clareza.

### 1. 🧭 Menu Lateral (Sidebar)
*   **Posição:** Fixa à esquerda (`fixed inset-y-0 left-0`).
*   **Largura:** 
    *   Expandida: `256px` (`w-64`)
    *   Recolhida: `80px` (`w-20`)
*   **Cores (Dark Theme):**
    *   Background: `#1e293b` (Slate-800)
    *   Seção Logo: `#0f172a` (Slate-900)
    *   Texto Inativo: `#9ca3af` (Gray-400)
    *   Texto Ativo/Hover: `#ffffff` (White)
    *   Cor de Destaque (Active): `#3b82f6` (Blue-500)
*   **Estado Ativo (Active Link):**
    *   Fundo: `rgba(30, 41, 59, 0.5)` (ou Slate-800 leve)
    *   Indicador: Borda esquerda de `4px` sólida na cor de destaque.
*   **Tipografia:** Labels com `font-medium` e ícones de tamanho fixo (24px) centralizados.

### 2. ⚡ Cabeçalho (Topbar)
*   **Posição:** Fixa no topo (`sticky top-0`), sobrepondo o conteúdo (`z-40`).
*   **Altura:** `64px` (`h-16`).
*   **Estilo:**
    *   Fundo: Branco Sólido (`#ffffff`).
    *   Borda: Inferior de `1px` sólida `#e5e7eb` (Gray-200).
*   **Elementos:**
    *   **Lado Esquerdo:** Título da página ou saudação personalizada (`font-medium`).
    *   **Lado Direito:** 
        *   Notificações: Ícone de sino com contador circular vermelho.
        *   Perfil: Bloco Flex com Nome (Bold), Papel (Small Gray) e Avatar circular (`40px`).
*   **Menu Dropdown:** Card flutuante com sombra suave, bordas de `12px` e separadores cinza claro.

---

## 🎨 Token de Design (Tailwind Config)

```javascript
module.exports = {
  theme: {
    extend: {
      colors: {
        primary: '#1e40af',   // Azul Royal para botões e links
        secondary: '#1e293b', // Slate para menus e backgrounds escuros
        accent: '#3b82f6'     // Azul vibrante para estados ativos
      },
      borderRadius: {
        'xl': '0.75rem',
        '2xl': '1rem'
      }
    }
  }
}
```

---

## 🤖 Prompt para Geração via IA (System Blueprint)

> "Aja como um Engenheiro Frontend Especialista em React/Tailwind. Implemente uma interface seguindo o padrão **EstagiárioPlus UI**:
>
> 1.  **Sidebar colapsável (256px/80px)** com fundo Slate-800 e seção de branding Slate-900. Itens de menu devem ter ícones FontAwesome e labels ocultáveis. O item ativo ganha borda lateral azul de 4px.
> 2.  **Topbar fixa de 64px** em fundo branco com borda inferior fina. Deve conter uma saudação à esquerda e um componente de perfil à direita com avatar e nome.
> 3.  **Conteúdo Principal** com fundo cinza claro (`#f9fafb`) e padding interno de `32px`.
> 4.  **Cards e Elementos:** Use bordas arredondadas de `12px` (`rounded-xl`) e sombras sutis.
> 5.  **Interatividade:** Adicione transição de 300ms na largura da sidebar e nos efeitos de hover dos menus."

---

## 🛠️ Exemplo de Estrutura HTML (Tailwind)

```html
<!-- Exemplo simplificado de item de menu ativo -->
<a href="#" class="flex items-center px-6 py-3 bg-slate-800 text-white border-l-4 border-blue-500">
    <i class="fas fa-th-large w-6 text-center"></i>
    <span class="ml-3 font-medium">Dashboard</span>
</a>

<!-- Exemplo de Topbar -->
<header class="h-16 bg-white border-b flex items-center justify-between px-8">
    <h2 class="text-gray-500 font-medium">Dashboard Overview</h2>
    <div class="flex items-center space-x-4">
        <img src="avatar.png" class="w-10 h-10 rounded-full shadow-sm">
    </div>
</header>
```

---
*Documento gerado por @Orion (aiox-master) para fins de replicação sistêmica.*
