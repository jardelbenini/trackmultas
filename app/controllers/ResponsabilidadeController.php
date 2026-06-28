<?php
require_once __DIR__ . '/../models/Responsabilidade.php';

class ResponsabilidadeController
{
    private $model;

    public function __construct()
    {
        $this->model = new Responsabilidade();
    }

    public function index()
    {
        $pageTitle = 'Responsabilidades - TrackMultas';
        $activeMenu = 'responsabilidades';
        $responsabilidades = $this->model->listar();

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/responsabilidades/index.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function create()
    {
        $pageTitle = 'Nova Responsabilidade - TrackMultas';
        $activeMenu = 'responsabilidades';

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/responsabilidades/form.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = trim($_POST['nome'] ?? '');
            
            if (!empty($nome)) {
                $this->model->cadastrar($nome);
                $_SESSION['mensagem'] = 'Responsabilidade cadastrada com sucesso!';
                $_SESSION['tipo_mensagem'] = 'success';
            } else {
                $_SESSION['mensagem'] = 'O nome é obrigatório!';
                $_SESSION['tipo_mensagem'] = 'danger';
            }
        }
        header('Location: ' . BASE_URL . 'index.php?controller=responsabilidades&action=index');
        exit;
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ' . BASE_URL . 'index.php?controller=responsabilidades&action=index');
            exit;
        }

        $responsabilidade = $this->model->buscarPorId($id);
        if (!$responsabilidade) {
            header('Location: ' . BASE_URL . 'index.php?controller=responsabilidades&action=index');
            exit;
        }

        $pageTitle = 'Editar Responsabilidade - TrackMultas';
        $activeMenu = 'responsabilidades';

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/responsabilidades/form.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $nome = trim($_POST['nome'] ?? '');

            if ($id && !empty($nome)) {
                $this->model->atualizar($id, $nome);
                $_SESSION['mensagem'] = 'Responsabilidade atualizada com sucesso!';
                $_SESSION['tipo_mensagem'] = 'success';
            } else {
                $_SESSION['mensagem'] = 'Dados inválidos!';
                $_SESSION['tipo_mensagem'] = 'danger';
            }
        }
        header('Location: ' . BASE_URL . 'index.php?controller=responsabilidades&action=index');
        exit;
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            try {
                $this->model->excluir($id);
                $_SESSION['mensagem'] = 'Responsabilidade excluída com sucesso!';
                $_SESSION['tipo_mensagem'] = 'success';
            } catch (Exception $e) {
                $_SESSION['mensagem'] = 'Não é possível excluir esta responsabilidade pois ela está em uso nas multas.';
                $_SESSION['tipo_mensagem'] = 'danger';
            }
        }
        header('Location: ' . BASE_URL . 'index.php?controller=responsabilidades&action=index');
        exit;
    }
}