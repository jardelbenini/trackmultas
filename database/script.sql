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

DROP TABLE IF EXISTS multas;
DROP TABLE IF EXISTS veiculos;
DROP TABLE IF EXISTS motoristas;
DROP TABLE IF EXISTS empresas;
DROP TABLE IF EXISTS setores;
DROP TABLE IF EXISTS status_motoristas;
DROP TABLE IF EXISTS tipos_veiculos;
DROP TABLE IF EXISTS orgaos;
DROP TABLE IF EXISTS motivos_infracoes;
DROP TABLE IF EXISTS responsabilidades;
DROP TABLE IF EXISTS status_andamento_multa;
DROP TABLE IF EXISTS status_pagamento;

SET FOREIGN_KEY_CHECKS = 1;

-- ============================================
-- Tabelas Auxiliares
-- ============================================

-- Empresas
CREATE TABLE empresas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    razao_social VARCHAR(255) NOT NULL,
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
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
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
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Tabelas Principais
-- ============================================

-- Motoristas
CREATE TABLE motoristas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    cpf VARCHAR(14) DEFAULT NULL,
    cnh VARCHAR(20) DEFAULT NULL,
    telefone VARCHAR(20) DEFAULT NULL,
    empresa_id INT NOT NULL,
    setor_id INT NOT NULL,
    status_id INT NOT NULL,
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
    ano INT DEFAULT NULL,
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
    valor_pago_motorista DECIMAL(10,2) DEFAULT 0.00,
    valor_pago_empresa DECIMAL(10,2) DEFAULT 0.00,
    status_pagamento_id INT NOT NULL,
    data_vencimento DATE DEFAULT NULL,
    data_pagamento DATE DEFAULT NULL,
    data_acerto_motorista DATE DEFAULT NULL,
    multa_origem_id INT DEFAULT NULL,
    tratativa TEXT DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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

-- ============================================
-- Dados Padrões (Tabelas Auxiliares)
-- ============================================

-- Empresa Teste
INSERT INTO empresas (razao_social, cnpj) VALUES
('Empresa Teste', '00.000.000/0001-00');

-- Setores
INSERT INTO setores (nome) VALUES
('Motorista'),
('Outros');

-- Status Motoristas
INSERT INTO status_motoristas (nome) VALUES
('Ativo'),
('Afastado'),
('Desligado'),
('Não Admitido');

-- Tipos de Veículos
INSERT INTO tipos_veiculos (nome) VALUES
('Cavalo'),
('Carreta'),
('Carro'),
('Caminhoneta'),
('Moto');

-- Órgãos Autuadores
INSERT INTO orgaos (nome) VALUES
('Detran'),
('PRF'),
('DNIT'),
('Prefeitura'),
('ANTT');

-- Motivos de Infrações
INSERT INTO motivos_infracoes (codigo, descricao, pontos) VALUES
('7455', 'Excesso de Velocidade até 20%', 4),
('7463', 'Excesso de Velocidade de 20% a 50%', 5),
('6831', 'Mexendo no Celular', 7),
('9999', 'Excesso de Peso', 0);

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
INSERT INTO status_pagamento (nome) VALUES
('Pago'),
('A Pagar'),
('A Vencer'),
('Cancelada'),
('Suspensa'),
('Advertência'),
('Aguardando Boleto');

-- ============================================
-- Dados de Teste
-- ============================================

-- Motorista Teste (empresa_id=1, setor_id=1 Motorista, status_id=1 Ativo)
INSERT INTO motoristas (nome, cpf, cnh, telefone, empresa_id, setor_id, status_id) VALUES
('Motorista Teste', '000.000.000-00', '00000000000', '(00) 00000-0000', 1, 1, 1);

-- Veículo Teste (tipo_veiculo_id=1 Cavalo)
INSERT INTO veiculos (placa, renavam, modelo, marca, ano, tipo_veiculo_id) VALUES
('TST0A00', '00000000000', 'Modelo Teste', 'Marca Teste', 2024, 1);

-- Multa Teste
INSERT INTO multas (
    motorista_id, veiculo_id, auto_infracao, data_infracao, hora_infracao,
    local_multa, cidade, estado, orgao_id, motivo_infracao_id,
    responsabilidade_id, status_motorista_id, status_andamento_id,
    prazo_indicar_condutor, valor_real, motorista_pagou,
    valor_pago_motorista, valor_pago_empresa, status_pagamento_id,
    data_vencimento, data_pagamento, data_acerto_motorista,
    multa_origem_id, tratativa
) VALUES (
    1, 1, 'AI-000001', '2024-01-15', '14:30:00',
    'Rodovia BR-101, Km 50', 'Curitiba', 'PR', 2, 1,
    1, 1, 1,
    '2024-02-15', 195.23, 0,
    0.00, 0.00, 2,
    '2024-03-15', NULL, NULL,
    NULL, 'Multa de teste para validação do sistema.'
);
