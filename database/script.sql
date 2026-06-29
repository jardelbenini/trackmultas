-- ============================================
-- TrackMultas - Script de Criação do Banco
-- Etapa 2: Banco de dados completo
-- ============================================

-- Cria o banco de dados se não existir
CREATE DATABASE IF NOT EXISTS trackmultas
    DEFAULT CHARACTER SET utf8mb4
    DEFAULT COLLATE utf8mb4_unicode_ci;

-- Seleciona o banco
USE trackmultas;

-- ============================================
-- Desabilita verificação de FK para DROP seguro
-- ============================================
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS multa_parcelas;
DROP TABLE IF EXISTS multas;
DROP TABLE IF EXISTS veiculos;
DROP TABLE IF EXISTS motoristas;
DROP TABLE IF EXISTS empresas;
DROP TABLE IF EXISTS setores;
DROP TABLE IF EXISTS status_motoristas;
DROP TABLE IF EXISTS tipos_veiculos;
DROP TABLE IF EXISTS orgaos;
DROP TABLE IF EXISTS motivos_infracoes;
DROP TABLE IF EXISTS categorias_infracoes;
DROP TABLE IF EXISTS responsabilidades;
DROP TABLE IF EXISTS status_andamento_multa;
DROP TABLE IF EXISTS status_pagamento;
DROP TABLE IF EXISTS usuarios;

SET FOREIGN_KEY_CHECKS = 1;

-- ============================================
-- Tabelas Auxiliares
-- ============================================

-- Empresas
CREATE TABLE empresas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    cnpj VARCHAR(20) DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Setores
CREATE TABLE setores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Status dos Motoristas
CREATE TABLE status_motoristas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tipos de Veículos
CREATE TABLE tipos_veiculos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Órgãos Autuadores
CREATE TABLE orgaos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(20) DEFAULT NULL,
    nome VARCHAR(100) NOT NULL,
    sigla VARCHAR(20) DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Categorias de Infrações
CREATE TABLE categorias_infracoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Motivos de Infrações
CREATE TABLE motivos_infracoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(20) NOT NULL,
    descricao VARCHAR(255) NOT NULL,
    pontos INT NOT NULL DEFAULT 0,
    gravidade VARCHAR(50) DEFAULT NULL,
    valor_base DECIMAL(10,2) DEFAULT 0.00,
    fator_multiplicacao INT DEFAULT 1,
    valor_multa DECIMAL(10,2) DEFAULT 0.00,
    gera_suspensao_cnh TINYINT(1) DEFAULT 0,
    categoria_id INT DEFAULT NULL,
    observacao TEXT DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_motivos_categoria FOREIGN KEY (categoria_id) REFERENCES categorias_infracoes(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Responsabilidades
CREATE TABLE responsabilidades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Status de Andamento da Multa
CREATE TABLE status_andamento_multa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Status de Pagamento
CREATE TABLE status_pagamento (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cor VARCHAR(20) DEFAULT 'secondary',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Usuários do Sistema
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Tabelas Principais
-- ============================================

-- Motoristas
CREATE TABLE motoristas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    empresa_id INT NOT NULL,
    matricula VARCHAR(50) DEFAULT NULL,
    nome VARCHAR(255) NOT NULL,
    cpf VARCHAR(14) DEFAULT NULL,
    setor_id INT NOT NULL,
    status_id INT NOT NULL,
    data_admissao DATE DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_motoristas_empresa FOREIGN KEY (empresa_id) REFERENCES empresas(id),
    CONSTRAINT fk_motoristas_setor FOREIGN KEY (setor_id) REFERENCES setores(id),
    CONSTRAINT fk_motoristas_status FOREIGN KEY (status_id) REFERENCES status_motoristas(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Veículos
CREATE TABLE veiculos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    placa VARCHAR(10) NOT NULL,
    renavam VARCHAR(20) DEFAULT NULL,
    modelo VARCHAR(100) DEFAULT NULL,
    marca VARCHAR(100) DEFAULT NULL,
    ano_fabricacao INT DEFAULT NULL,
    tipo_veiculo_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uk_veiculos_placa (placa),
    UNIQUE KEY uk_veiculos_renavam (renavam),
    CONSTRAINT fk_veiculos_tipo FOREIGN KEY (tipo_veiculo_id) REFERENCES tipos_veiculos(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Multas
CREATE TABLE multas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    empresa_id INT NOT NULL,
    motorista_id INT NOT NULL,
    veiculo_id INT NOT NULL,
    auto_infracao VARCHAR(50) DEFAULT NULL,
    data_infracao DATE DEFAULT NULL,
    hora_infracao TIME DEFAULT NULL,
    local_multa VARCHAR(255) DEFAULT NULL,
    cidade VARCHAR(100) DEFAULT NULL,
    estado CHAR(2) DEFAULT NULL,
    orgao_id INT NOT NULL,
    motivo_infracao_id INT NOT NULL,
    responsabilidade_id INT NOT NULL,
    status_motorista_id INT NOT NULL,
    status_andamento_id INT NOT NULL,
    prazo_indicar_condutor DATE DEFAULT NULL,
    valor_real DECIMAL(10,2) DEFAULT 0.00,
    motorista_pagou TINYINT(1) DEFAULT 0,
    valor_acordado DECIMAL(10,2) DEFAULT NULL,
    valor_pago_motorista DECIMAL(10,2) DEFAULT 0.00,
    valor_pago_empresa DECIMAL(10,2) DEFAULT 0.00,
    resultado_financeiro DECIMAL(10,2) DEFAULT NULL,
    desconto_pagamento VARCHAR(50) DEFAULT NULL,
    status_pagamento_id INT NOT NULL,
    data_vencimento DATE DEFAULT NULL,
    data_pagamento DATE DEFAULT NULL,
    data_acerto_motorista DATE DEFAULT NULL,
    multa_origem_id INT DEFAULT NULL,
    tratativa TEXT DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_multas_empresa FOREIGN KEY (empresa_id) REFERENCES empresas(id),
    CONSTRAINT fk_multas_motorista FOREIGN KEY (motorista_id) REFERENCES motoristas(id),
    CONSTRAINT fk_multas_veiculo FOREIGN KEY (veiculo_id) REFERENCES veiculos(id),
    CONSTRAINT fk_multas_orgao FOREIGN KEY (orgao_id) REFERENCES orgaos(id),
    CONSTRAINT fk_multas_motivo FOREIGN KEY (motivo_infracao_id) REFERENCES motivos_infracoes(id),
    CONSTRAINT fk_multas_responsabilidade FOREIGN KEY (responsabilidade_id) REFERENCES responsabilidades(id),
    CONSTRAINT fk_multas_status_motorista FOREIGN KEY (status_motorista_id) REFERENCES status_motoristas(id),
    CONSTRAINT fk_multas_status_andamento FOREIGN KEY (status_andamento_id) REFERENCES status_andamento_multa(id),
    CONSTRAINT fk_multas_status_pagamento FOREIGN KEY (status_pagamento_id) REFERENCES status_pagamento(id),
    CONSTRAINT fk_multas_origem FOREIGN KEY (multa_origem_id) REFERENCES multas(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Multa Parcelas
CREATE TABLE multa_parcelas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    multa_id INT NOT NULL,
    numero_parcela INT NOT NULL,
    valor DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    data_vencimento DATE DEFAULT NULL,
    data_pagamento DATE DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_parcelas_multa FOREIGN KEY (multa_id) REFERENCES multas(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Dados Padrões (Tabelas Auxiliares)
-- ============================================

-- Empresa Teste
INSERT INTO empresas (nome, cnpj) VALUES
('EMPRESA TESTE', '00.000.000/0001-00');

-- Setores
INSERT INTO setores (nome) VALUES
('Motorista'),
('Outros');

-- Status Motoristas
INSERT INTO status_motoristas (nome) VALUES
('ATIVO'),
('AFASTADO'),
('DESLIGADO'),
('NÃO ADMITIDO');

-- Tipos de Veículos
INSERT INTO tipos_veiculos (nome) VALUES
('CAVALO'),
('CARRETA'),
('CARRO'),
('CAMINHONETA'),
('MOTO');

-- Órgãos Autuadores
INSERT INTO orgaos (codigo, nome, sigla) VALUES
('000100', 'DEPARTAMENTO DE POLÍCIA RODOVIÁRIA FEDERAL', 'PRF'),
('000200', 'DEPARTAMENTO NACIONAL DE INFRAESTRUTURA DE TRANSPORTES', 'DNIT');

-- Categorias de Infrações
INSERT INTO categorias_infracoes (nome) VALUES
('Velocidade'),
('Documentação'),
('Equipamentos'),
('Manobra Irregular');

-- Motivos de Infrações
INSERT INTO motivos_infracoes (codigo, descricao, pontos, gravidade, valor_base, categoria_id) VALUES
('7455', 'EXCESSO DE VELOCIDADE ATÉ 20%', 4, 'MÉDIA', 130.16, 1),
('7463', 'EXCESSO DE VELOCIDADE DE 20% A 50%', 5, 'GRAVE', 195.23, 1),
('6831', 'MEXENDO NO CELULAR', 7, 'GRAVÍSSIMA', 293.47, 4),
('9999', 'EXCESSO DE PESO', 0, 'SEM PONTUAÇÃO', 0.00, 3);

-- Responsabilidades
INSERT INTO responsabilidades (nome) VALUES
('Motorista'),
('Empresa'),
('Compartilhada'),
('Embarcador');

-- Status Andamento Multa
INSERT INTO status_andamento_multa (nome) VALUES
('Aguardando análise'),
('Enviar para o responsável'),
('Não precisa assumir'),
('Recurso / Defesa'),
('Aguardando retorno'),
('Quer assumir'),
('Assumiu'),
('Veio em seu nome'),
('Não quis assumir'),
('Venceu o prazo');

-- Status Pagamento
INSERT INTO status_pagamento (nome, cor) VALUES
('PAGO', 'bg-success'),
('A PAGAR', 'bg-warning text-dark'),
('A VENCER', 'bg-primary'),
('CANCELADA', 'bg-danger'),
('SUSPENSA', 'bg-secondary'),
('ADVERTÊNCIA', 'bg-info'),
('AGUARDANDO BOLETO', 'bg-dark');

-- ============================================
-- Dados de Teste
-- ============================================

-- Motorista Teste (empresa_id=1, setor_id=1 Motorista, status_id=1 Ativo)
INSERT INTO motoristas (empresa_id, matricula, nome, cpf, setor_id, status_id, data_admissao) VALUES
(1, '1001', 'MOTORISTA TESTE', '000.000.000-00', 1, 1, '2024-01-01');

-- Veículo Teste (tipo_veiculo_id=1 Cavalo)
INSERT INTO veiculos (placa, renavam, modelo, marca, ano_fabricacao, tipo_veiculo_id) VALUES
('TST0A00', '00000000000', 'MODELO TESTE', 'MARCA TESTE', 2024, 1);

-- Multa Teste
INSERT INTO multas (
    empresa_id, motorista_id, veiculo_id, auto_infracao, data_infracao, hora_infracao,
    local_multa, cidade, estado, orgao_id, motivo_infracao_id,
    responsabilidade_id, status_motorista_id, status_andamento_id,
    prazo_indicar_condutor, valor_real, motorista_pagou,
    valor_acordado, valor_pago_motorista, valor_pago_empresa,
    resultado_financeiro, desconto_pagamento, status_pagamento_id,
    data_vencimento, data_pagamento, data_acerto_motorista,
    multa_origem_id, tratativa
) VALUES (
    1, 1, 1, 'AI-000001', '2024-01-15', '14:30:00',
    'Rodovia BR-101, Km 50', 'Curitiba', 'PR', 2, 1,
    1, 1, 1,
    '2024-02-15', 195.23, 0,
    195.23, 0.00, 0.00,
    0.00, NULL, 2,
    '2024-03-15', NULL, NULL,
    NULL, 'Multa de teste para validação do sistema.'
);
