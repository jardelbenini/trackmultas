<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/app/models/Database.php';

$db = new Database();
$pdo = $db->connect();

if ($pdo) {
    try {
        $sql = "ALTER TABLE multas 
                ADD COLUMN resultado_financeiro DECIMAL(10,2) NULL,
                ADD COLUMN desconto_pagamento VARCHAR(50) NULL";
        $pdo->exec($sql);
        echo "Colunas resultado_financeiro e desconto_pagamento criadas com sucesso!";
    } catch (PDOException $e) {
        if ($e->getCode() == '42S21') {
            echo "Colunas já existem!";
        } else {
            echo "Erro: " . $e->getMessage();
        }
    }
}
