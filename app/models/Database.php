<?php

class Database
{
    private $host;
    private $dbName;
    private $user;
    private $pass;
    private $pdo;

    /**
     * Construtor - inicializa os parâmetros de conexão
     */
    public function __construct()
    {
        $this->host   = DB_HOST;
        $this->dbName = DB_NAME;
        $this->user   = DB_USER;
        $this->pass   = DB_PASS;
    }

    /**
     * Retorna a conexão PDO com o banco de dados MySQL
     *
     * @return PDO|null
     */
    public function connect()
    {
        $this->pdo = null;

        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbName};charset=utf8mb4";
            $this->pdo = new PDO($dsn, $this->user, $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            echo "Erro na conexão: " . $e->getMessage();
        }

        return $this->pdo;
    }
}
