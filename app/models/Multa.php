<?php

class Multa
{
    private $pdo;

    public function __construct()
    {
        $db = new Database();
        $this->pdo = $db->connect();
    }

    public function listar()
    {
        $sql = "SELECT 
                    m.*, 
                    mot.nome AS motorista_nome,
                    v.placa AS veiculo_placa,
                    o.nome AS orgao_nome,
                    o.sigla AS orgao_sigla,
                    mi.descricao AS motivo_descricao,
                    r.nome AS responsabilidade_nome,
                    sa.nome AS status_andamento_nome,
                    sp.nome AS status_pagamento_nome,
                    sp.cor AS status_pagamento_cor,
                    sm.nome AS status_motorista_nome
                FROM multas m
                JOIN motoristas mot ON m.motorista_id = mot.id
                JOIN veiculos v ON m.veiculo_id = v.id
                JOIN orgaos o ON m.orgao_id = o.id
                JOIN motivos_infracoes mi ON m.motivo_infracao_id = mi.id
                JOIN responsabilidades r ON m.responsabilidade_id = r.id
                JOIN status_andamento_multa sa ON m.status_andamento_id = sa.id
                JOIN status_pagamento sp ON m.status_pagamento_id = sp.id
                JOIN status_motoristas sm ON m.status_motorista_id = sm.id
                ORDER BY m.id DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function buscarPorId($id)
    {
        $sql = "SELECT 
                    m.*, 
                    mot.nome AS motorista_nome,
                    v.placa AS veiculo_placa,
                    v.marca AS veiculo_marca,
                    v.modelo AS veiculo_modelo,
                    o.nome AS orgao_nome,
                    o.sigla AS orgao_sigla,
                    mi.descricao AS motivo_descricao,
                    mi.codigo AS motivo_codigo,
                    r.nome AS responsabilidade_nome,
                    sa.nome AS status_andamento_nome,
                    sp.nome AS status_pagamento_nome,
                    sp.cor AS status_pagamento_cor,
                    sm.nome AS status_motorista_nome
                FROM multas m
                JOIN motoristas mot ON m.motorista_id = mot.id
                JOIN veiculos v ON m.veiculo_id = v.id
                JOIN orgaos o ON m.orgao_id = o.id
                JOIN motivos_infracoes mi ON m.motivo_infracao_id = mi.id
                JOIN responsabilidades r ON m.responsabilidade_id = r.id
                JOIN status_andamento_multa sa ON m.status_andamento_id = sa.id
                JOIN status_pagamento sp ON m.status_pagamento_id = sp.id
                JOIN status_motoristas sm ON m.status_motorista_id = sm.id
                WHERE m.id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function cadastrar($dados)
    {
        $sql = "INSERT INTO multas (
                    motorista_id, veiculo_id, auto_infracao, data_infracao, hora_infracao,
                    local_multa, cidade, estado, orgao_id, motivo_infracao_id, responsabilidade_id,
                    status_motorista_id, status_andamento_id, prazo_indicar_condutor, valor_real,
                    motorista_pagou, valor_acordado, valor_pago_motorista, valor_pago_empresa, status_pagamento_id,
                    data_vencimento, data_pagamento, data_acerto_motorista, desconto_pagamento, resultado_financeiro, tratativa
                ) VALUES (
                    :motorista_id, :veiculo_id, :auto_infracao, :data_infracao, :hora_infracao,
                    :local_multa, :cidade, :estado, :orgao_id, :motivo_infracao_id, :responsabilidade_id,
                    :status_motorista_id, :status_andamento_id, :prazo_indicar_condutor, :valor_real,
                    :motorista_pagou, :valor_acordado, :valor_pago_motorista, :valor_pago_empresa, :status_pagamento_id,
                    :data_vencimento, :data_pagamento, :data_acerto_motorista, :desconto_pagamento, :resultado_financeiro, :tratativa
                )";
                
        $stmt = $this->pdo->prepare($sql);
        $success = $stmt->execute([
            ':motorista_id'           => $dados['motorista_id'],
            ':veiculo_id'             => $dados['veiculo_id'],
            ':auto_infracao'          => $dados['auto_infracao'],
            ':data_infracao'          => $dados['data_infracao'],
            ':hora_infracao'          => $dados['hora_infracao'] ?: null,
            ':local_multa'            => $dados['local_multa'] ?: null,
            ':cidade'                 => $dados['cidade'] ?: null,
            ':estado'                 => $dados['estado'] ?: null,
            ':orgao_id'               => $dados['orgao_id'],
            ':motivo_infracao_id'     => $dados['motivo_infracao_id'],
            ':responsabilidade_id'    => $dados['responsabilidade_id'],
            ':status_motorista_id'    => $dados['status_motorista_id'],
            ':status_andamento_id'    => $dados['status_andamento_id'],
            ':prazo_indicar_condutor' => $dados['prazo_indicar_condutor'] ?: null,
            ':valor_real'             => $dados['valor_real'] !== '' ? $dados['valor_real'] : 0.00,
            ':motorista_pagou'        => $dados['motorista_pagou'] ?: 0,
            ':valor_acordado'         => $dados['valor_acordado'] !== '' ? $dados['valor_acordado'] : null,
            ':valor_pago_motorista'   => $dados['valor_pago_motorista'] !== '' ? $dados['valor_pago_motorista'] : 0.00,
            ':valor_pago_empresa'     => $dados['valor_pago_empresa'] !== '' ? $dados['valor_pago_empresa'] : 0.00,
            ':status_pagamento_id'    => $dados['status_pagamento_id'],
            ':data_vencimento'        => $dados['data_vencimento'] ?: null,
            ':data_pagamento'         => $dados['data_pagamento'] ?: null,
            ':data_acerto_motorista'  => $dados['data_acerto_motorista'] ?: null,
            ':desconto_pagamento'     => $dados['desconto_pagamento'] ?: null,
            ':resultado_financeiro'   => $dados['resultado_financeiro'] !== '' ? $dados['resultado_financeiro'] : null,
            ':tratativa'              => $dados['tratativa'] ?: null
        ]);
        
        if ($success) {
            return $this->pdo->lastInsertId();
        }
        return false;
    }

    public function atualizar($id, $dados)
    {
        $sql = "UPDATE multas SET 
                    motorista_id = :motorista_id,
                    veiculo_id = :veiculo_id,
                    auto_infracao = :auto_infracao,
                    data_infracao = :data_infracao,
                    hora_infracao = :hora_infracao,
                    local_multa = :local_multa,
                    cidade = :cidade,
                    estado = :estado,
                    orgao_id = :orgao_id,
                    motivo_infracao_id = :motivo_infracao_id,
                    responsabilidade_id = :responsabilidade_id,
                    status_motorista_id = :status_motorista_id,
                    status_andamento_id = :status_andamento_id,
                    prazo_indicar_condutor = :prazo_indicar_condutor,
                    valor_real = :valor_real,
                    motorista_pagou = :motorista_pagou,
                    valor_acordado = :valor_acordado,
                    valor_pago_motorista = :valor_pago_motorista,
                    valor_pago_empresa = :valor_pago_empresa,
                    status_pagamento_id = :status_pagamento_id,
                    data_vencimento = :data_vencimento,
                    data_pagamento = :data_pagamento,
                    data_acerto_motorista = :data_acerto_motorista,
                    desconto_pagamento = :desconto_pagamento,
                    resultado_financeiro = :resultado_financeiro,
                    tratativa = :tratativa
                WHERE id = :id";
                
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id'                     => $id,
            ':motorista_id'           => $dados['motorista_id'],
            ':veiculo_id'             => $dados['veiculo_id'],
            ':auto_infracao'          => $dados['auto_infracao'],
            ':data_infracao'          => $dados['data_infracao'],
            ':hora_infracao'          => $dados['hora_infracao'] ?: null,
            ':local_multa'            => $dados['local_multa'] ?: null,
            ':cidade'                 => $dados['cidade'] ?: null,
            ':estado'                 => $dados['estado'] ?: null,
            ':orgao_id'               => $dados['orgao_id'],
            ':motivo_infracao_id'     => $dados['motivo_infracao_id'],
            ':responsabilidade_id'    => $dados['responsabilidade_id'],
            ':status_motorista_id'    => $dados['status_motorista_id'],
            ':status_andamento_id'    => $dados['status_andamento_id'],
            ':prazo_indicar_condutor' => $dados['prazo_indicar_condutor'] ?: null,
            ':valor_real'             => $dados['valor_real'] !== '' ? $dados['valor_real'] : 0.00,
            ':motorista_pagou'        => $dados['motorista_pagou'] ?: 0,
            ':valor_acordado'         => $dados['valor_acordado'] !== '' ? $dados['valor_acordado'] : null,
            ':valor_pago_motorista'   => $dados['valor_pago_motorista'] !== '' ? $dados['valor_pago_motorista'] : 0.00,
            ':valor_pago_empresa'     => $dados['valor_pago_empresa'] !== '' ? $dados['valor_pago_empresa'] : 0.00,
            ':status_pagamento_id'    => $dados['status_pagamento_id'],
            ':data_vencimento'        => $dados['data_vencimento'] ?: null,
            ':data_pagamento'         => $dados['data_pagamento'] ?: null,
            ':data_acerto_motorista'  => $dados['data_acerto_motorista'] ?: null,
            ':desconto_pagamento'     => $dados['desconto_pagamento'] ?: null,
            ':resultado_financeiro'   => $dados['resultado_financeiro'] !== '' ? $dados['resultado_financeiro'] : null,
            ':tratativa'              => $dados['tratativa'] ?: null
        ]);
    }

    public function excluir($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM multas WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function salvarParcelas($multa_id, $parcelas)
    {
        // Limpa as parcelas antigas
        $stmt = $this->pdo->prepare("DELETE FROM multa_parcelas WHERE multa_id = :multa_id");
        $stmt->execute([':multa_id' => $multa_id]);

        if (empty($parcelas)) {
            return true;
        }

        // Insere as novas
        $sql = "INSERT INTO multa_parcelas (multa_id, numero_parcela, valor, data_vencimento, data_pagamento) 
                VALUES (:multa_id, :numero_parcela, :valor, :data_vencimento, :data_pagamento)";
        $stmt = $this->pdo->prepare($sql);

        foreach ($parcelas as $p) {
            $stmt->execute([
                ':multa_id'        => $multa_id,
                ':numero_parcela'  => $p['numero_parcela'],
                ':valor'           => $p['valor'] !== '' ? $p['valor'] : 0.00,
                ':data_vencimento' => !empty($p['data_vencimento']) ? $p['data_vencimento'] : null,
                ':data_pagamento'  => !empty($p['data_pagamento']) ? $p['data_pagamento'] : null
            ]);
        }
        return true;
    }

    public function buscarParcelas($multa_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM multa_parcelas WHERE multa_id = :multa_id ORDER BY numero_parcela ASC");
        $stmt->execute([':multa_id' => $multa_id]);
        return $stmt->fetchAll();
    }
}
