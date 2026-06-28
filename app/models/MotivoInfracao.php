<?php

class MotivoInfracao
{
    private $pdo;

    public function __construct()
    {
        $db = new Database();
        $this->pdo = $db->connect();
    }

    public function listar()
    {
        $stmt = $this->pdo->query("SELECT * FROM motivos_infracoes ORDER BY codigo ASC");
        return $stmt->fetchAll();
    }

    public function buscarPorId($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM motivos_infracoes WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function buscarPorCodigo($codigo)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM motivos_infracoes WHERE codigo = :codigo");
        $stmt->execute([':codigo' => $codigo]);
        return $stmt->fetch();
    }

    public function cadastrar($dados)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO motivos_infracoes (codigo, descricao, pontos, gravidade, valor_base, fator_multiplicacao, valor_multa, gera_suspensao_cnh, categoria_id, observacao) 
            VALUES (:codigo, :descricao, :pontos, :gravidade, :valor_base, :fator_multiplicacao, :valor_multa, :gera_suspensao_cnh, :categoria_id, :observacao)
        ");
        return $stmt->execute([
            ':codigo'               => $dados['codigo'],
            ':descricao'            => $dados['descricao'],
            ':pontos'               => $dados['pontos'] !== '' ? $dados['pontos'] : 0,
            ':gravidade'            => !empty($dados['gravidade']) ? $dados['gravidade'] : null,
            ':valor_base'           => !empty($dados['valor_base']) ? str_replace(',', '.', str_replace('.', '', $dados['valor_base'])) : null,
            ':fator_multiplicacao'  => !empty($dados['fator_multiplicacao']) ? $dados['fator_multiplicacao'] : null,
            ':valor_multa'          => !empty($dados['valor_multa']) ? str_replace(',', '.', str_replace('.', '', $dados['valor_multa'])) : null,
            ':gera_suspensao_cnh'   => isset($dados['gera_suspensao_cnh']) ? 1 : 0,
            ':categoria_id'         => !empty($dados['categoria_id']) ? $dados['categoria_id'] : null,
            ':observacao'           => !empty($dados['observacao']) ? $dados['observacao'] : null
        ]);
    }

    public function atualizar($id, $dados)
    {
        $stmt = $this->pdo->prepare("
            UPDATE motivos_infracoes 
            SET codigo = :codigo, 
                descricao = :descricao, 
                pontos = :pontos,
                gravidade = :gravidade,
                valor_base = :valor_base,
                fator_multiplicacao = :fator_multiplicacao,
                valor_multa = :valor_multa,
                gera_suspensao_cnh = :gera_suspensao_cnh,
                categoria_id = :categoria_id,
                observacao = :observacao
            WHERE id = :id
        ");
        return $stmt->execute([
            ':id'                   => $id,
            ':codigo'               => $dados['codigo'],
            ':descricao'            => $dados['descricao'],
            ':pontos'               => $dados['pontos'] !== '' ? $dados['pontos'] : 0,
            ':gravidade'            => !empty($dados['gravidade']) ? $dados['gravidade'] : null,
            ':valor_base'           => !empty($dados['valor_base']) ? str_replace(',', '.', str_replace('.', '', $dados['valor_base'])) : null,
            ':fator_multiplicacao'  => !empty($dados['fator_multiplicacao']) ? $dados['fator_multiplicacao'] : null,
            ':valor_multa'          => !empty($dados['valor_multa']) ? str_replace(',', '.', str_replace('.', '', $dados['valor_multa'])) : null,
            ':gera_suspensao_cnh'   => isset($dados['gera_suspensao_cnh']) ? 1 : 0,
            ':categoria_id'         => !empty($dados['categoria_id']) ? $dados['categoria_id'] : null,
            ':observacao'           => !empty($dados['observacao']) ? $dados['observacao'] : null
        ]);
    }

    public function excluir($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM motivos_infracoes WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
