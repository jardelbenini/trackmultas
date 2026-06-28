<?php

require_once __DIR__ . '/../models/CategoriaInfracao.php';

class CategoriaInfracaoController
{
    private $model;

    public function __construct()
    {
        $this->model = new CategoriaInfracao();
    }

    public function index()
    {
        $pageTitle = 'Categorias de Infrações - TrackMultas';
        $activeMenu = 'categorias_infracoes';

        $categorias = $this->model->listar();

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/categorias/index.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function create()
    {
        $pageTitle = 'Nova Categoria - TrackMultas';
        $activeMenu = 'categorias_infracoes';
        $isEdit = false;

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/categorias/form.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['nome'])) {
                $_SESSION['mensagem'] = 'Preencha o nome da categoria.';
                $_SESSION['tipo_mensagem'] = 'danger';
                header('Location: ' . BASE_URL . 'index.php?controller=categorias_infracoes&action=create');
                exit;
            }

            try {
                $this->model->cadastrar($_POST);
                $_SESSION['mensagem'] = 'Categoria cadastrada com sucesso.';
                $_SESSION['tipo_mensagem'] = 'success';
                header('Location: ' . BASE_URL . 'index.php?controller=categorias_infracoes&action=index');
            } catch (Exception $e) {
                $_SESSION['mensagem'] = 'Erro ao salvar: ' . $e->getMessage();
                $_SESSION['tipo_mensagem'] = 'danger';
                header('Location: ' . BASE_URL . 'index.php?controller=categorias_infracoes&action=create');
            }
            exit;
        }
        header('Location: ' . BASE_URL . 'index.php?controller=categorias_infracoes&action=index');
        exit;
    }

    public function edit($id = null)
    {
        if (!$id) {
            header('Location: ' . BASE_URL . 'index.php?controller=categorias_infracoes&action=index');
            exit;
        }

        $pageTitle = 'Editar Categoria - TrackMultas';
        $activeMenu = 'categorias_infracoes';
        $isEdit = true;

        $categoria = $this->model->buscarPorId($id);
        if (!$categoria) {
            $_SESSION['mensagem'] = 'Categoria não encontrada.';
            $_SESSION['tipo_mensagem'] = 'danger';
            header('Location: ' . BASE_URL . 'index.php?controller=categorias_infracoes&action=index');
            exit;
        }

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/categorias/form.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function update($id = null)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
            if (empty($_POST['nome'])) {
                $_SESSION['mensagem'] = 'Preencha o nome da categoria.';
                $_SESSION['tipo_mensagem'] = 'danger';
                header('Location: ' . BASE_URL . 'index.php?controller=categorias_infracoes&action=edit&id=' . $id);
                exit;
            }

            try {
                $this->model->atualizar($id, $_POST);
                $_SESSION['mensagem'] = 'Categoria atualizada com sucesso.';
                $_SESSION['tipo_mensagem'] = 'success';
                header('Location: ' . BASE_URL . 'index.php?controller=categorias_infracoes&action=index');
            } catch (Exception $e) {
                $_SESSION['mensagem'] = 'Erro ao atualizar: ' . $e->getMessage();
                $_SESSION['tipo_mensagem'] = 'danger';
                header('Location: ' . BASE_URL . 'index.php?controller=categorias_infracoes&action=edit&id=' . $id);
            }
            exit;
        }
        header('Location: ' . BASE_URL . 'index.php?controller=categorias_infracoes&action=index');
        exit;
    }

    public function delete($id = null)
    {
        if ($id) {
            try {
                $this->model->excluir($id);
                $_SESSION['mensagem'] = 'Categoria excluída com sucesso.';
                $_SESSION['tipo_mensagem'] = 'success';
            } catch (Exception $e) {
                $_SESSION['mensagem'] = 'Erro ao excluir. A categoria pode estar vinculada a motivos de infração.';
                $_SESSION['tipo_mensagem'] = 'danger';
            }
        }
        header('Location: ' . BASE_URL . 'index.php?controller=categorias_infracoes&action=index');
        exit;
    }
}
