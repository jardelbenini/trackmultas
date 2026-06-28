<?php

require_once __DIR__ . '/../models/MotivoInfracao.php';
require_once __DIR__ . '/../models/CategoriaInfracao.php';

class MotivoInfracaoController
{
    private $model;
    private $categoriaModel;

    public function __construct()
    {
        $this->model = new MotivoInfracao();
        $this->categoriaModel = new CategoriaInfracao();
    }

    public function index()
    {
        $pageTitle = 'Motivos de Infração - TrackMultas';
        $activeMenu = 'motivos_infracoes';

        $motivos = $this->model->listar();

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/motivos/index.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function create()
    {
        $pageTitle = 'Novo Motivo de Infração - TrackMultas';
        $activeMenu = 'motivos_infracoes';
        $isEdit = false;

        $categorias = $this->categoriaModel->listar();

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/motivos/form.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['codigo']) || empty($_POST['descricao'])) {
                $_SESSION['mensagem'] = 'Preencha o código e a descrição do motivo.';
                $_SESSION['tipo_mensagem'] = 'danger';
                header('Location: ' . BASE_URL . 'index.php?controller=motivos_infracoes&action=create');
                exit;
            }

            // Verifica se o código já existe
            $existente = $this->model->buscarPorCodigo($_POST['codigo']);
            if ($existente) {
                $_SESSION['mensagem'] = 'Este código já está em uso por outro motivo de infração.';
                $_SESSION['tipo_mensagem'] = 'danger';
                header('Location: ' . BASE_URL . 'index.php?controller=motivos_infracoes&action=create');
                exit;
            }

            try {
                $this->model->cadastrar($_POST);
                $_SESSION['mensagem'] = 'Motivo de infração cadastrado com sucesso.';
                $_SESSION['tipo_mensagem'] = 'success';
                header('Location: ' . BASE_URL . 'index.php?controller=motivos_infracoes&action=index');
            } catch (Exception $e) {
                $_SESSION['mensagem'] = 'Erro ao salvar: ' . $e->getMessage();
                $_SESSION['tipo_mensagem'] = 'danger';
                header('Location: ' . BASE_URL . 'index.php?controller=motivos_infracoes&action=create');
            }
            exit;
        }
        header('Location: ' . BASE_URL . 'index.php?controller=motivos_infracoes&action=index');
        exit;
    }

    public function edit($id = null)
    {
        if (!$id) {
            header('Location: ' . BASE_URL . 'index.php?controller=motivos_infracoes&action=index');
            exit;
        }

        $pageTitle = 'Editar Motivo de Infração - TrackMultas';
        $activeMenu = 'motivos_infracoes';
        $isEdit = true;

        $motivo = $this->model->buscarPorId($id);
        if (!$motivo) {
            $_SESSION['mensagem'] = 'Motivo não encontrado.';
            $_SESSION['tipo_mensagem'] = 'danger';
            header('Location: ' . BASE_URL . 'index.php?controller=motivos_infracoes&action=index');
            exit;
        }

        $categorias = $this->categoriaModel->listar();

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/motivos/form.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function update($id = null)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
            if (empty($_POST['codigo']) || empty($_POST['descricao'])) {
                $_SESSION['mensagem'] = 'Preencha o código e a descrição do motivo.';
                $_SESSION['tipo_mensagem'] = 'danger';
                header('Location: ' . BASE_URL . 'index.php?controller=motivos_infracoes&action=edit&id=' . $id);
                exit;
            }

            // Verifica se o código já existe e pertence a OUTRO motivo
            $existente = $this->model->buscarPorCodigo($_POST['codigo']);
            if ($existente && $existente['id'] != $id) {
                $_SESSION['mensagem'] = 'Este código já está em uso por outro motivo de infração.';
                $_SESSION['tipo_mensagem'] = 'danger';
                header('Location: ' . BASE_URL . 'index.php?controller=motivos_infracoes&action=edit&id=' . $id);
                exit;
            }

            try {
                $this->model->atualizar($id, $_POST);
                $_SESSION['mensagem'] = 'Motivo de infração atualizado com sucesso.';
                $_SESSION['tipo_mensagem'] = 'success';
                header('Location: ' . BASE_URL . 'index.php?controller=motivos_infracoes&action=index');
            } catch (Exception $e) {
                $_SESSION['mensagem'] = 'Erro ao atualizar: ' . $e->getMessage();
                $_SESSION['tipo_mensagem'] = 'danger';
                header('Location: ' . BASE_URL . 'index.php?controller=motivos_infracoes&action=edit&id=' . $id);
            }
            exit;
        }
        header('Location: ' . BASE_URL . 'index.php?controller=motivos_infracoes&action=index');
        exit;
    }

    public function delete($id = null)
    {
        if ($id) {
            try {
                $this->model->excluir($id);
                $_SESSION['mensagem'] = 'Motivo de infração excluído com sucesso.';
                $_SESSION['tipo_mensagem'] = 'success';
            } catch (Exception $e) {
                $_SESSION['mensagem'] = 'Erro ao excluir. O motivo pode estar em uso.';
                $_SESSION['tipo_mensagem'] = 'danger';
            }
        }
        header('Location: ' . BASE_URL . 'index.php?controller=motivos_infracoes&action=index');
        exit;
    }

    public function check_codigo()
    {
        header('Content-Type: application/json');
        
        $codigo = isset($_GET['codigo']) ? trim($_GET['codigo']) : '';
        $idIgnore = isset($_GET['ignore_id']) ? intval($_GET['ignore_id']) : 0;
        
        if (empty($codigo)) {
            echo json_encode(['exists' => false]);
            exit;
        }

        $existente = $this->model->buscarPorCodigo($codigo);
        
        if ($existente && $existente['id'] != $idIgnore) {
            echo json_encode(['exists' => true]);
        } else {
            echo json_encode(['exists' => false]);
        }
        exit;
    }

    public function get_details()
    {
        header('Content-Type: application/json');
        
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        
        if ($id) {
            $motivo = $this->model->buscarPorId($id);
            if ($motivo) {
                echo json_encode([
                    'success' => true,
                    'codigo' => $motivo['codigo'],
                    'descricao' => $motivo['descricao'],
                    'pontos' => $motivo['pontos'],
                    'valor_multa' => $motivo['valor_multa']
                ]);
                exit;
            }
        }
        
        echo json_encode(['success' => false]);
        exit;
    }
}
