<?php

require_once __DIR__ . '/../models/TipoVeiculo.php';

class TipoVeiculoController
{
    private $model;

    public function __construct()
    {
        $this->model = new TipoVeiculo();
    }

    public function index()
    {
        $pageTitle = 'Tipos de Veículos - TrackMultas';
        $activeMenu = 'tipos_veiculos';
        $tipos = $this->model->listar();

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/tipos_veiculos/index.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function create()
    {
        $pageTitle = 'Novo Tipo de Veículo - TrackMultas';
        $activeMenu = 'tipos_veiculos';
        $isEdit = false;

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/tipos_veiculos/form.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = trim($_POST['nome'] ?? '');

            if (empty($nome)) {
                $_SESSION['mensagem'] = 'O nome do tipo de veículo é obrigatório.';
                $_SESSION['tipo_mensagem'] = 'danger';
                header('Location: ' . BASE_URL . 'index.php?controller=tipos_veiculos&action=create');
                exit;
            }

            try {
                $this->model->cadastrar($nome);
                $_SESSION['mensagem'] = 'Tipo de veículo cadastrado com sucesso.';
                $_SESSION['tipo_mensagem'] = 'success';
                header('Location: ' . BASE_URL . 'index.php?controller=tipos_veiculos&action=index');
            } catch (Exception $e) {
                $_SESSION['mensagem'] = 'Erro ao cadastrar: ' . $e->getMessage();
                $_SESSION['tipo_mensagem'] = 'danger';
                header('Location: ' . BASE_URL . 'index.php?controller=tipos_veiculos&action=create');
            }
            exit;
        }
    }

    public function edit($id = null)
    {
        if (!$id) {
            header('Location: ' . BASE_URL . 'index.php?controller=tipos_veiculos&action=index');
            exit;
        }

        $pageTitle = 'Editar Tipo de Veículo - TrackMultas';
        $activeMenu = 'tipos_veiculos';
        $isEdit = true;
        $tipo = $this->model->buscarPorId($id);

        if (!$tipo) {
            $_SESSION['mensagem'] = 'Tipo de veículo não encontrado.';
            $_SESSION['tipo_mensagem'] = 'danger';
            header('Location: ' . BASE_URL . 'index.php?controller=tipos_veiculos&action=index');
            exit;
        }

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/tipos_veiculos/form.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function update($id = null)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
            $nome = trim($_POST['nome'] ?? '');

            if (empty($nome)) {
                $_SESSION['mensagem'] = 'O nome do tipo de veículo é obrigatório.';
                $_SESSION['tipo_mensagem'] = 'danger';
                header('Location: ' . BASE_URL . 'index.php?controller=tipos_veiculos&action=edit&id=' . $id);
                exit;
            }

            try {
                $this->model->atualizar($id, $nome);
                $_SESSION['mensagem'] = 'Tipo de veículo atualizado com sucesso.';
                $_SESSION['tipo_mensagem'] = 'success';
                header('Location: ' . BASE_URL . 'index.php?controller=tipos_veiculos&action=index');
            } catch (Exception $e) {
                $_SESSION['mensagem'] = 'Erro ao atualizar: ' . $e->getMessage();
                $_SESSION['tipo_mensagem'] = 'danger';
                header('Location: ' . BASE_URL . 'index.php?controller=tipos_veiculos&action=edit&id=' . $id);
            }
            exit;
        }
    }

    public function delete($id = null)
    {
        if ($id) {
            try {
                $this->model->excluir($id);
                $_SESSION['mensagem'] = 'Tipo de veículo excluído com sucesso.';
                $_SESSION['tipo_mensagem'] = 'success';
            } catch (Exception $e) {
                $_SESSION['mensagem'] = 'Erro ao excluir: ' . $e->getMessage();
                $_SESSION['tipo_mensagem'] = 'danger';
            }
        }
        header('Location: ' . BASE_URL . 'index.php?controller=tipos_veiculos&action=index');
        exit;
    }
}
