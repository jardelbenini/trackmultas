<?php

class Veiculo
{
    private $pdo;

    public function __construct()
    {
        $db = new Database();
        $this->pdo = $db->connect();
    }

    public function listar()
    {
        $sql = "SELECT v.*, tv.nome AS tipo_nome 
                FROM veiculos v
                JOIN tipos_veiculos tv ON v.tipo_veiculo_id = tv.id
                ORDER BY v.placa ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function buscarPorId($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM veiculos WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function cadastrar($dados)
    {
        $sql = "INSERT INTO veiculos (placa, renavam, tipo_veiculo_id, marca, modelo, ano_fabricacao)
                VALUES (:placa, :renavam, :tipo_veiculo_id, :marca, :modelo, :ano_fabricacao)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':placa'           => strtoupper($dados['placa']),
            ':renavam'         => $dados['renavam'],
            ':tipo_veiculo_id' => $dados['tipo_veiculo_id'],
            ':marca'           => $dados['marca'] ?: null,
            ':modelo'          => $dados['modelo'] ?: null,
            ':ano_fabricacao'  => $dados['ano_fabricacao'] ?: null
        ]);
    }

    public function atualizar($id, $dados)
    {
        $sql = "UPDATE veiculos SET 
                placa = :placa, 
                renavam = :renavam, 
                tipo_veiculo_id = :tipo_veiculo_id, 
                marca = :marca, 
                modelo = :modelo, 
                ano_fabricacao = :ano_fabricacao
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id'              => $id,
            ':placa'           => strtoupper($dados['placa']),
            ':renavam'         => $dados['renavam'],
            ':tipo_veiculo_id' => $dados['tipo_veiculo_id'],
            ':marca'           => $dados['marca'] ?: null,
            ':modelo'          => $dados['modelo'] ?: null,
            ':ano_fabricacao'  => $dados['ano_fabricacao'] ?: null
        ]);
    }

    public function excluir($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM veiculos WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
