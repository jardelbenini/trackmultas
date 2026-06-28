<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/app/models/Database.php';

$db = new Database();
$pdo = $db->connect();

if ($pdo) {
    try {
        $sql = "ALTER TABLE multas ADD COLUMN valor_acordado DECIMAL(10,2) NULL AFTER motorista_pagou";
        $pdo->exec($sql);
        echo "Coluna valor_acordado criada com sucesso!";
    } catch (PDOException $e) {
        // Ignora se já existir
        if ($e->getCode() == '42S21') {
            echo "Coluna já existe!";
        } else {
            echo "Erro: " . $e->getMessage();
        }
    }
}
