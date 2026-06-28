<?php

class Setor
{
    private $pdo;

    public function __construct()
    {
        $db = new Database();
        $this->pdo = $db->connect();
    }

    public function listar()
    {
        $stmt = $this->pdo->query("SELECT * FROM setores ORDER BY nome ASC");
        return $stmt->fetchAll();
    }
}
