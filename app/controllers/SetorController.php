<?php

require_once __DIR__ . '/../models/Setor.php';

class SetorController
{
    private $model;

    public function __construct()
    {
        $this->model = new Setor();
    }

    public function index()
    {
        $pageTitle = 'Setores - TrackMultas';
        $activeMenu = 'setores';
        $setores = $this->model->listar();

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/setores/index.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function create()
    {
        $pageTitle = 'Novo Setor - TrackMultas';
        $activeMenu = 'setores';
        $isEdit = false;

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/setores/form.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = trim($_POST['nome'] ?? '');

            if (empty($nome)) {
                $_SESSION['mensagem'] = 'O nome do setor é obrigatório.';
                $_SESSION['tipo_mensagem'] = 'danger';
                header('Location: ' . BASE_URL . 'index.php?controller=setores&action=create');
                exit;
            }

            try {
                $this->model->cadastrar($nome);
                $_SESSION['mensagem'] = 'Setor cadastrado com sucesso.';
                $_SESSION['tipo_mensagem'] = 'success';
                header('Location: ' . BASE_URL . 'index.php?controller=setores&action=index');
            } catch (Exception $e) {
                $_SESSION['mensagem'] = 'Erro ao cadastrar o setor: ' . $e->getMessage();
                $_SESSION['tipo_mensagem'] = 'danger';
                header('Location: ' . BASE_URL . 'index.php?controller=setores&action=create');
            }
            exit;
        }
    }

    public function edit($id = null)
    {
        if (!$id) {
            header('Location: ' . BASE_URL . 'index.php?controller=setores&action=index');
            exit;
        }

        $pageTitle = 'Editar Setor - TrackMultas';
        $activeMenu = 'setores';
        $isEdit = true;
        
        $setor = $this->model->buscarPorId($id);

        if (!$setor) {
            $_SESSION['mensagem'] = 'Setor não encontrado.';
            $_SESSION['tipo_mensagem'] = 'danger';
            header('Location: ' . BASE_URL . 'index.php?controller=setores&action=index');
            exit;
        }

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/setores/form.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function update($id = null)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
            $nome = trim($_POST['nome'] ?? '');

            if (empty($nome)) {
                $_SESSION['mensagem'] = 'O nome do setor é obrigatório.';
                $_SESSION['tipo_mensagem'] = 'danger';
                header('Location: ' . BASE_URL . 'index.php?controller=setores&action=edit&id=' . $id);
                exit;
            }

            try {
                $this->model->atualizar($id, $nome);
                $_SESSION['mensagem'] = 'Setor atualizado com sucesso.';
                $_SESSION['tipo_mensagem'] = 'success';
                header('Location: ' . BASE_URL . 'index.php?controller=setores&action=index');
            } catch (Exception $e) {
                $_SESSION['mensagem'] = 'Erro ao atualizar o setor: ' . $e->getMessage();
                $_SESSION['tipo_mensagem'] = 'danger';
                header('Location: ' . BASE_URL . 'index.php?controller=setores&action=edit&id=' . $id);
            }
            exit;
        }
    }

    public function delete($id = null)
    {
        if ($id) {
            try {
                $this->model->excluir($id);
                $_SESSION['mensagem'] = 'Setor excluído com sucesso.';
                $_SESSION['tipo_mensagem'] = 'success';
            } catch (Exception $e) {
                $_SESSION['mensagem'] = 'Erro ao excluir: ' . $e->getMessage();
                $_SESSION['tipo_mensagem'] = 'danger';
            }
        }
        header('Location: ' . BASE_URL . 'index.php?controller=setores&action=index');
        exit;
    }
}
