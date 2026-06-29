<?php

require_once __DIR__ . '/../models/Usuario.php';

class AuthController
{
    private $model;

    public function __construct()
    {
        $this->model = new Usuario();
    }

    /**
     * Exibe a tela de login.
     * Se já estiver logado, redireciona para a home.
     */
    public function login()
    {
        if (isset($_SESSION['usuario_id'])) {
            header('Location: ' . BASE_URL . 'index.php?controller=home&action=index');
            exit;
        }

        $pageTitle = 'Login - TrackMultas';

        require_once __DIR__ . '/../views/auth/login.php';
    }

    /**
     * Processa a autenticação via POST.
     * Usa password_verify para conferir a senha.
     */
    public function autenticar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $senha = trim($_POST['senha'] ?? '');

            // Valida campos vazios
            if (empty($email) || empty($senha)) {
                $_SESSION['mensagem'] = 'Preencha e-mail e senha.';
                $_SESSION['tipo_mensagem'] = 'danger';
                header('Location: ' . BASE_URL . 'index.php?controller=auth&action=login');
                exit;
            }

            // Busca o usuário pelo e-mail
            $usuario = $this->model->buscarPorEmail($email);

            // Verifica se existe e se a senha confere
            if ($usuario && password_verify($senha, $usuario['senha'])) {
                // Cria as sessões
                $_SESSION['usuario_id']    = $usuario['id'];
                $_SESSION['usuario_nome']  = $usuario['nome'];
                $_SESSION['usuario_email'] = $usuario['email'];

                header('Location: ' . BASE_URL . 'index.php?controller=home&action=index');
                exit;
            }

            // Credenciais inválidas
            $_SESSION['mensagem'] = 'E-mail ou senha inválidos.';
            $_SESSION['tipo_mensagem'] = 'danger';
            header('Location: ' . BASE_URL . 'index.php?controller=auth&action=login');
            exit;
        }
    }

    /**
     * Destrói a sessão e redireciona para o login.
     */
    public function logout()
    {
        session_destroy();
        session_start();
        $_SESSION['mensagem'] = 'Você saiu do sistema.';
        $_SESSION['tipo_mensagem'] = 'success';
        header('Location: ' . BASE_URL . 'index.php?controller=auth&action=login');
        exit;
    }
}
