<?php

class Usuario
{
    private $pdo;

    public function __construct()
    {
        $db = new Database();
        $this->pdo = $db->connect();
    }

    /**
     * Busca um usuário pelo e-mail.
     */
    public function buscarPorEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }

    /**
     * Cria o usuário administrador padrão se ainda não existir.
     * Senha armazenada com password_hash (nunca em texto puro).
     */
    public function criarUsuarioInicial()
    {
        // Verifica se já existe
        $usuario = $this->buscarPorEmail('admin@trackmultas.com');

        if (!$usuario) {
            $senhaHash = password_hash('123456', PASSWORD_DEFAULT);

            $stmt = $this->pdo->prepare(
                "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)"
            );
            $stmt->execute([
                ':nome'  => 'Administrador',
                ':email' => 'admin@trackmultas.com',
                ':senha' => $senhaHash
            ]);
        }
    }
}
