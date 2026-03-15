-- Gestão de Estagiários - MySQL Schema (Versão Otimizada)

-- 1. Tabelas de Domínio (Referência)
CREATE TABLE IF NOT EXISTS lotacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subunidade VARCHAR(255),
    unidade VARCHAR(100),
    lotacao VARCHAR(100),
    municipio VARCHAR(100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS niveis_escolaridade (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS cargas_horarias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(50) NOT NULL UNIQUE,
    horas_diarias INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS motivos_desligamento (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Entidades Principais
CREATE TABLE IF NOT EXISTS institutions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    razao_social VARCHAR(255) NOT NULL,
    cnpj VARCHAR(20) NOT NULL UNIQUE,
    nome_diretor VARCHAR(255) NULL,
    email_diretor VARCHAR(255) NULL,
    nome_coordenador VARCHAR(255) NULL,
    email_coordenador VARCHAR(255) NULL,
    status_convenio ENUM('Ativo', 'Inativo') DEFAULT 'Ativo',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    cpf VARCHAR(14) NOT NULL UNIQUE,
    curso VARCHAR(255),
    semestre INT,
    previsao_formatura DATE,
    nivel_escolaridade_id INT,
    institution_id INT,
    comprovante_matricula_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (nivel_escolaridade_id) REFERENCES niveis_escolaridade(id),
    FOREIGN KEY (institution_id) REFERENCES institutions(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS supervisors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    cargo VARCHAR(255),
    email VARCHAR(255),
    telefone_ramal VARCHAR(50),
    lotacao_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (lotacao_id) REFERENCES lotacoes(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS positions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lotacao_id INT NOT NULL,
    nivel_escolaridade_id INT NOT NULL,
    carga_horaria_id INT NOT NULL,
    quantidade INT DEFAULT 1,
    remuneracao_base DECIMAL(10, 2),
    requisitos TEXT,
    status ENUM('Aberta', 'Ocupada', 'Suspensa') DEFAULT 'Aberta',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (lotacao_id) REFERENCES lotacoes(id) ON DELETE CASCADE,
    FOREIGN KEY (nivel_escolaridade_id) REFERENCES niveis_escolaridade(id),
    FOREIGN KEY (carga_horaria_id) REFERENCES cargas_horarias(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS contracts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    institution_id INT NOT NULL,
    supervisor_id INT NOT NULL,
    position_id INT NOT NULL,
    carga_horaria_id INT NOT NULL,
    data_inicio DATE NOT NULL,
    data_fim DATE NOT NULL,
    data_desligamento DATE NULL,
    motivo_desligamento_id INT NULL,
    valor_bolsa DECIMAL(10, 2),
    valor_transporte DECIMAL(10, 2),
    status ENUM('Ativo', 'Encerrado') DEFAULT 'Ativo',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (institution_id) REFERENCES institutions(id) ON DELETE CASCADE,
    FOREIGN KEY (supervisor_id) REFERENCES supervisors(id) ON DELETE CASCADE,
    FOREIGN KEY (position_id) REFERENCES positions(id) ON DELETE CASCADE,
    FOREIGN KEY (carga_horaria_id) REFERENCES cargas_horarias(id),
    FOREIGN KEY (motivo_desligamento_id) REFERENCES motivos_desligamento(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Tabelas de Acompanhamento
CREATE TABLE IF NOT EXISTS timesheets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contract_id INT NOT NULL,
    date DATE NOT NULL,
    hora_entrada TIME,
    hora_saida TIME,
    geolocalizacao VARCHAR(255),
    is_dia_prova BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (contract_id) REFERENCES contracts(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS evaluations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contract_id INT NOT NULL,
    competencias_tecnicas TEXT,
    competencias_comportamentais TEXT,
    nota DECIMAL(5, 2),
    feedback_supervisor TEXT,
    feedback_estagiario TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (contract_id) REFERENCES contracts(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS financials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contract_id INT NOT NULL,
    saldo_recesso DECIMAL(5, 2) DEFAULT 0.00,
    pagamentos_realizados DECIMAL(10, 2) DEFAULT 0.00,
    last_recesso_calc DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (contract_id) REFERENCES contracts(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Controle de Acesso (SSO GestorGov)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sso_user_id INT NOT NULL UNIQUE,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    nivel_acesso INT DEFAULT 3, -- 1: Admin, 2: Gestor, 3: Consultor
    ultimo_acesso TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Configurações Globais
CREATE TABLE IF NOT EXISTS system_settings (
    setting_key VARCHAR(50) PRIMARY KEY,
    setting_value VARCHAR(255),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO system_settings (setting_key, setting_value) VALUES ('allow_visitors', '1');

-- 6. Inserção de Dados Iniciais
INSERT INTO niveis_escolaridade (descricao) VALUES ('Médio'), ('Superior');
INSERT INTO cargas_horarias (descricao, horas_diarias) VALUES ('4 Horas', 4), ('6 Horas', 6);
INSERT INTO motivos_desligamento (descricao) VALUES 
('Fim do contrato'), 
('Rescisão antecipada pelo estagiário'), 
('Rescisão antecipada pela instituição'),
('Contratação efetiva'),
('Desempenho insuficiente');

-- Seed Data para Lotacoes
INSERT INTO lotacoes (id, subunidade, unidade, lotacao, municipio) VALUES
(1, 'COORDENACAO DE ASSUNTOS FAZ ESTRATEGICOS / CAFE', 'CAFE', 'OC', 'BELEM'),
(2, 'CELULA DE COMUNICACAO - CCOM / CAFE', 'CAFE', 'OC', 'BELEM'),
(3, 'CELULA DO LABORATÓRIO DE GESTÃO DO CONHECIMENTO CAFE', 'CAFE', 'OC', 'BELEM'),
(4, 'COORD EXEC DE CONTROLE DE MERCADORIAS EM TRANSITO', 'CECOMT', 'REG', 'BELEM'),
(5, 'UNID DE EXEC DE CONTR MERC EM TRANS ALCA VIARIA / CECOMT', 'CECOMT', 'REG', 'SAO FRANCISCO DO'),
(6, 'UNID DE EXEC DE CONTR MERC EM TRANS SAO FRANCISCO / CECOMT', 'CECOMT', 'REG', 'SAO FRANCISCO DO'),
(7, 'UNID DE EXEC DE CONTR MERC EM TRANS SAO FRANCISCO / CECOMT', 'CECOMT', 'REG', 'PRATINHA'),
(8, 'UNID DE EXEC DE CONTR MERC EM TRANS DO LITORAL / CECOMT', 'CECOMT', 'REG', 'BELEM'),
(9, 'UNID DE EXEC DE CONTR MERC EM TRANS DOS CORREIOS / CECOMT', 'CECOMT', 'REG', 'BELEM'),
(10, 'UNID DE EXEC DE CONTR MERC EM TRANS DA GRANDE BELEM / CECOMT', 'CECOMT', 'REG', 'BELEM'),
(11, 'UNID DE EXEC DE CONTR MERC EM TRANS ALCA VIARIA / CECOMT', 'CECOMT', 'REG', 'ACARA'),
(12, 'UNID DE EXEC DE CONTR MERC EM TRANS DA PRATINHA / CECOMT', 'CECOMT', 'REG', 'BELEM'),
(13, 'COORD EXEC DE CONTR DE MERC TRANS SERRA DO CACHIMBO', 'CECOMT DA SERRA DO CACHIMBO', 'REG', 'NOVO PROGRESSO'),
(14, 'UNID DE EXEC CONTR MERC TRANS DE SAO GERALDO DO ARAGUAIA / CECOMT DE CARAJAS', 'CECOMT DE CARAJAS', 'REG', 'SAO GERALDO DO ARAGUAIA'),
(15, 'COORD EXEC DE CONTR DE MERC EM TRANS DE CARAJAS', 'CECOMT DE CARAJAS', 'REG', 'MARABA'),
(16, 'UNID DE EXEC CONTR MERC TRANS DE JARBAS PASSARINHO / CECOMT DE CARAJAS', 'CECOMT DE CARAJAS', 'REG', 'BREJO GRANDE DO ARAGUAIA'),
(17, 'UNID DE EXEC CONTR MERC TRANS DE MARABA KM 09 / CECOMT DE CARAJAS', 'CECOMT DE CARAJAS', 'REG', 'MARABA'),
(18, 'UNID DE EXEC DE CONTR MERC EM TRANS VILA DO CONDE / CECOMT DE P. AEROP.', 'CECOMT DE PORTOS E AEROPORTOS', 'REG', 'BARCARENA'),
(19, 'UNID DE EXEC DE CONTR MERC EM TRANS DE SANTAREM / CECOMT DE P. AEROP.', 'CECOMT DE PORTOS E AEROPORTOS', 'REG', 'CONCEICAO DO ARAGUAIA'),
(20, 'UNID DE EXEC DE CONTR MERC EM TRANS CAIS DO PORTO / CECOMT DE P. AEROP.', 'CECOMT DE PORTOS E AEROPORTOS', 'REG', 'BELEM'),
(21, 'COORD EXEC DE CONTR DE MERC TRANS DE PORTOS E AEROPORTOS', 'CECOMT DE PORTOS E AEROPORTOS', 'REG', 'BELEM'),
(22, 'UNID DE EXEC de CONTR MERC EM TRANS PORTO DER / CECOMT DE P. AEROP.', 'CECOMT DE PORTOS E AEROPORTOS', 'REG', 'BELEM');
