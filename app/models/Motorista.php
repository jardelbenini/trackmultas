<?php

class Motorista
{
    private $pdo;

    public function __construct()
    {
        $db = new Database();
        $this->pdo = $db->connect();
    }

    public function listar()
    {
        $sql = "SELECT m.*, e.nome AS empresa_nome, s.nome AS setor_nome, sm.nome AS status_nome 
                FROM motoristas m
                JOIN empresas e ON m.empresa_id = e.id
                JOIN setores s ON m.setor_id = s.id
                JOIN status_motoristas sm ON m.status_id = sm.id
                ORDER BY m.nome ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function buscarPorId($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM motoristas WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function cadastrar($dados)
    {
        $sql = "INSERT INTO motoristas (empresa_id, matricula, nome, cpf, setor_id, status_id, data_admissao)
                VALUES (:empresa_id, :matricula, :nome, :cpf, :setor_id, :status_id, :data_admissao)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':empresa_id'   => $dados['empresa_id'],
            ':matricula'    => $dados['matricula'] ?: null,
            ':nome'         => $dados['nome'],
            ':cpf'          => $dados['cpf'] ?: null,
            ':setor_id'     => $dados['setor_id'],
            ':status_id'    => $dados['status_id'],
            ':data_admissao'=> $dados['data_admissao'] ?: null
        ]);
    }

    public function atualizar($id, $dados)
    {
        $sql = "UPDATE motoristas SET 
                empresa_id = :empresa_id, 
                matricula = :matricula, 
                nome = :nome, 
                cpf = :cpf, 
                setor_id = :setor_id, 
                status_id = :status_id, 
                data_admissao = :data_admissao
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id'           => $id,
            ':empresa_id'   => $dados['empresa_id'],
            ':matricula'    => $dados['matricula'] ?: null,
            ':nome'         => $dados['nome'],
            ':cpf'          => $dados['cpf'] ?: null,
            ':setor_id'     => $dados['setor_id'],
            ':status_id'    => $dados['status_id'],
            ':data_admissao'=> $dados['data_admissao'] ?: null
        ]);
    }

    public function excluir($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM motoristas WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
