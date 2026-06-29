<?php

require_once __DIR__ . '/../models/Orgao.php';

class OrgaoController
{
    private $model;

    public function __construct()
    {
        $this->model = new Orgao();
    }

    public function index()
    {
        $pageTitle = 'Órgãos Autuadores - TrackMultas';
        $activeMenu = 'auxiliares';

        $orgaos = $this->model->listar();

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/orgaos/index.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function create()
    {
        $pageTitle = 'Novo Órgão Autuador - TrackMultas';
        $activeMenu = 'auxiliares';
        $isEdit = false;

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/orgaos/form.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['nome'])) {
                $_SESSION['mensagem'] = 'Preencha o nome do órgão.';
                $_SESSION['tipo_mensagem'] = 'danger';
                header('Location: ' . BASE_URL . 'index.php?controller=orgaos&action=create');
                exit;
            }

            $codigo = isset($_POST['codigo']) ? trim($_POST['codigo']) : '';
            $_POST['codigo'] = $codigo;

            if (!empty($codigo) && $this->model->verificarCodigoExistente($codigo)) {
                $_SESSION['mensagem'] = 'Já existe um órgão com este código.';
                $_SESSION['tipo_mensagem'] = 'danger';
                header('Location: ' . BASE_URL . 'index.php?controller=orgaos&action=create');
                exit;
            }

            try {
                $this->model->cadastrar($_POST);
                $_SESSION['mensagem'] = 'Órgão cadastrado com sucesso.';
                $_SESSION['tipo_mensagem'] = 'success';
                header('Location: ' . BASE_URL . 'index.php?controller=orgaos&action=index');
            } catch (Exception $e) {
                $_SESSION['mensagem'] = 'Erro ao salvar: ' . $e->getMessage();
                $_SESSION['tipo_mensagem'] = 'danger';
                header('Location: ' . BASE_URL . 'index.php?controller=orgaos&action=create');
            }
            exit;
        }
        header('Location: ' . BASE_URL . 'index.php?controller=orgaos&action=index');
        exit;
    }

    public function edit($id = null)
    {
        if (!$id) {
            header('Location: ' . BASE_URL . 'index.php?controller=orgaos&action=index');
            exit;
        }

        $pageTitle = 'Editar Órgão - TrackMultas';
        $activeMenu = 'auxiliares';
        $isEdit = true;

        $orgao = $this->model->buscarPorId($id);
        if (!$orgao) {
            $_SESSION['mensagem'] = 'Órgão não encontrado.';
            $_SESSION['tipo_mensagem'] = 'danger';
            header('Location: ' . BASE_URL . 'index.php?controller=orgaos&action=index');
            exit;
        }

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/orgaos/form.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function update($id = null)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
            if (empty($_POST['nome'])) {
                $_SESSION['mensagem'] = 'Preencha o nome do órgão.';
                $_SESSION['tipo_mensagem'] = 'danger';
                header('Location: ' . BASE_URL . 'index.php?controller=orgaos&action=edit&id=' . $id);
                exit;
            }

            $codigo = isset($_POST['codigo']) ? trim($_POST['codigo']) : '';
            $_POST['codigo'] = $codigo;

            if (!empty($codigo) && $this->model->verificarCodigoExistente($codigo, $id)) {
                $_SESSION['mensagem'] = 'Já existe um outro órgão com este código.';
                $_SESSION['tipo_mensagem'] = 'danger';
                header('Location: ' . BASE_URL . 'index.php?controller=orgaos&action=edit&id=' . $id);
                exit;
            }

            try {
                $this->model->atualizar($id, $_POST);
                $_SESSION['mensagem'] = 'Órgão atualizado com sucesso.';
                $_SESSION['tipo_mensagem'] = 'success';
                header('Location: ' . BASE_URL . 'index.php?controller=orgaos&action=index');
            } catch (Exception $e) {
                $_SESSION['mensagem'] = 'Erro ao atualizar: ' . $e->getMessage();
                $_SESSION['tipo_mensagem'] = 'danger';
                header('Location: ' . BASE_URL . 'index.php?controller=orgaos&action=edit&id=' . $id);
            }
            exit;
        }
        header('Location: ' . BASE_URL . 'index.php?controller=orgaos&action=index');
        exit;
    }

    public function delete($id = null)
    {
        if ($id) {
            try {
                $this->model->excluir($id);
                $_SESSION['mensagem'] = 'Órgão excluído com sucesso.';
                $_SESSION['tipo_mensagem'] = 'success';
            } catch (Exception $e) {
                $_SESSION['mensagem'] = 'Erro ao excluir. O órgão pode estar em uso.';
                $_SESSION['tipo_mensagem'] = 'danger';
            }
        }
        header('Location: ' . BASE_URL . 'index.php?controller=orgaos&action=index');
        exit;
    }

    public function check_codigo()
    {
        header('Content-Type: application/json');
        $codigo = isset($_GET['codigo']) ? trim($_GET['codigo']) : '';
        $id = isset($_GET['id']) ? trim($_GET['id']) : null;
        
        if (empty($codigo)) {
            echo json_encode(['exists' => false]);
            return;
        }

        $existente = $this->model->verificarCodigoExistente($codigo, $id);
        echo json_encode(['exists' => $existente]);
    }
}
