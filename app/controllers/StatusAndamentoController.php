<?php
require_once __DIR__ . '/../models/StatusAndamentoMulta.php';

class StatusAndamentoController
{
    private $model;

    public function __construct()
    {
        $this->model = new StatusAndamentoMulta();
    }

    public function index()
    {
        $pageTitle = 'Status de Andamentos - TrackMultas';
        $activeMenu = 'status_andamento';
        $status_andamento = $this->model->listar();

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/status_andamento/index.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function create()
    {
        $pageTitle = 'Nova Status de Andamento - TrackMultas';
        $activeMenu = 'status_andamento';

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/status_andamento/form.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = trim($_POST['nome'] ?? '');
            
            if (!empty($nome)) {
                $this->model->cadastrar($nome);
                $_SESSION['mensagem'] = 'Status de Andamento cadastrada com sucesso!';
                $_SESSION['tipo_mensagem'] = 'success';
            } else {
                $_SESSION['mensagem'] = 'O nome é obrigatório!';
                $_SESSION['tipo_mensagem'] = 'danger';
            }
        }
        header('Location: ' . BASE_URL . 'index.php?controller=status_andamento&action=index');
        exit;
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ' . BASE_URL . 'index.php?controller=status_andamento&action=index');
            exit;
        }

        $responsabilidade = $this->model->buscarPorId($id);
        if (!$responsabilidade) {
            header('Location: ' . BASE_URL . 'index.php?controller=status_andamento&action=index');
            exit;
        }

        $pageTitle = 'Editar Status de Andamento - TrackMultas';
        $activeMenu = 'status_andamento';

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/status_andamento/form.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $nome = trim($_POST['nome'] ?? '');

            if ($id && !empty($nome)) {
                $this->model->atualizar($id, $nome);
                $_SESSION['mensagem'] = 'Status de Andamento atualizada com sucesso!';
                $_SESSION['tipo_mensagem'] = 'success';
            } else {
                $_SESSION['mensagem'] = 'Dados inválidos!';
                $_SESSION['tipo_mensagem'] = 'danger';
            }
        }
        header('Location: ' . BASE_URL . 'index.php?controller=status_andamento&action=index');
        exit;
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            try {
                $this->model->excluir($id);
                $_SESSION['mensagem'] = 'Status de Andamento excluída com sucesso!';
                $_SESSION['tipo_mensagem'] = 'success';
            } catch (Exception $e) {
                $_SESSION['mensagem'] = 'Não é possível excluir esta responsabilidade pois ela está em uso nas multas.';
                $_SESSION['tipo_mensagem'] = 'danger';
            }
        }
        header('Location: ' . BASE_URL . 'index.php?controller=status_andamento&action=index');
        exit;
    }
}