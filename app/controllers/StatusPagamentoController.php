<?php
require_once __DIR__ . '/../models/StatusPagamento.php';

class StatusPagamentoController
{
    private $model;

    public function __construct()
    {
        $this->model = new StatusPagamento();
    }

    public function index()
    {
        $pageTitle = 'Status de Pagamento - TrackMultas';
        $activeMenu = 'status_pagamento';
        $status_pagamento = $this->model->listar();

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/status_pagamento/index.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function create()
    {
        $pageTitle = 'Novo Status de Pagamento - TrackMultas';
        $activeMenu = 'status_pagamento';

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/status_pagamento/form.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = trim($_POST['nome'] ?? '');
            $cor = $_POST['cor'] ?? 'bg-info';
            
            if (!empty($nome)) {
                $this->model->cadastrar($nome, $cor);
                $_SESSION['mensagem'] = 'Status de Pagamento cadastrado com sucesso!';
                $_SESSION['tipo_mensagem'] = 'success';
            } else {
                $_SESSION['mensagem'] = 'O nome é obrigatório!';
                $_SESSION['tipo_mensagem'] = 'danger';
            }
        }
        header('Location: ' . BASE_URL . 'index.php?controller=status_pagamento&action=index');
        exit;
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ' . BASE_URL . 'index.php?controller=status_pagamento&action=index');
            exit;
        }

        $status = $this->model->buscarPorId($id);
        if (!$status) {
            header('Location: ' . BASE_URL . 'index.php?controller=status_pagamento&action=index');
            exit;
        }

        $pageTitle = 'Editar Status de Pagamento - TrackMultas';
        $activeMenu = 'status_pagamento';

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/status_pagamento/form.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $nome = trim($_POST['nome'] ?? '');
            $cor = $_POST['cor'] ?? 'bg-info';

            if ($id && !empty($nome)) {
                $this->model->atualizar($id, $nome, $cor);
                $_SESSION['mensagem'] = 'Status de Pagamento atualizado com sucesso!';
                $_SESSION['tipo_mensagem'] = 'success';
            } else {
                $_SESSION['mensagem'] = 'Dados inválidos!';
                $_SESSION['tipo_mensagem'] = 'danger';
            }
        }
        header('Location: ' . BASE_URL . 'index.php?controller=status_pagamento&action=index');
        exit;
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            try {
                $this->model->excluir($id);
                $_SESSION['mensagem'] = 'Status de Pagamento excluído com sucesso!';
                $_SESSION['tipo_mensagem'] = 'success';
            } catch (Exception $e) {
                $_SESSION['mensagem'] = 'Não é possível excluir este status pois ele está em uso nas multas.';
                $_SESSION['tipo_mensagem'] = 'danger';
            }
        }
        header('Location: ' . BASE_URL . 'index.php?controller=status_pagamento&action=index');
        exit;
    }
}