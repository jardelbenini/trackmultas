<?php

require_once __DIR__ . '/../models/Veiculo.php';
require_once __DIR__ . '/../models/TipoVeiculo.php';

class VeiculoController
{
    private $model;
    private $tipoModel;

    public function __construct()
    {
        $this->model = new Veiculo();
        $this->tipoModel = new TipoVeiculo();
    }

    public function index()
    {
        $pageTitle = 'Veículos - TrackMultas';
        $activeMenu = 'veiculos';

        $veiculos = $this->model->listar();

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/veiculos/index.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function create()
    {
        $pageTitle = 'Novo Veículo - TrackMultas';
        $activeMenu = 'veiculos';
        $isEdit = false;
        $veiculo = null;

        $tipos = $this->tipoModel->listar();

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/veiculos/form.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'placa'           => trim($_POST['placa'] ?? ''),
                'renavam'         => trim($_POST['renavam'] ?? ''),
                'tipo_veiculo_id' => $_POST['tipo_veiculo_id'] ?? '',
                'marca'           => trim($_POST['marca'] ?? ''),
                'modelo'          => trim($_POST['modelo'] ?? ''),
                'ano_fabricacao'  => trim($_POST['ano_fabricacao'] ?? '')
            ];

            if (empty($dados['placa']) || empty($dados['renavam']) || empty($dados['tipo_veiculo_id'])) {
                $_SESSION['mensagem'] = 'Placa, Renavam e Tipo de Veículo são obrigatórios.';
                $_SESSION['tipo_mensagem'] = 'danger';
                header('Location: ' . BASE_URL . 'index.php?controller=veiculos&action=create');
                exit;
            }

            // Remove todos os caracteres não numéricos do renavam e verifica o tamanho
            $renavamLimpo = preg_replace('/\D/', '', $dados['renavam']);
            if (strlen($renavamLimpo) !== 11) {
                $_SESSION['mensagem'] = 'O Renavam deve conter exatamente 11 números.';
                $_SESSION['tipo_mensagem'] = 'danger';
                header('Location: ' . BASE_URL . 'index.php?controller=veiculos&action=create');
                exit;
            }

            try {
                $this->model->cadastrar($dados);
                $_SESSION['mensagem'] = 'Veículo cadastrado com sucesso!';
                $_SESSION['tipo_mensagem'] = 'success';
                header('Location: ' . BASE_URL . 'index.php?controller=veiculos&action=index');
            } catch (Exception $e) {
                $_SESSION['mensagem'] = 'Erro ao cadastrar veículo: ' . $e->getMessage();
                $_SESSION['tipo_mensagem'] = 'danger';
                header('Location: ' . BASE_URL . 'index.php?controller=veiculos&action=create');
            }
            exit;
        }
        header('Location: ' . BASE_URL . 'index.php?controller=veiculos&action=index');
        exit;
    }

    public function edit($id = null)
    {
        if (!$id) {
            header('Location: ' . BASE_URL . 'index.php?controller=veiculos&action=index');
            exit;
        }

        $pageTitle = 'Editar Veículo - TrackMultas';
        $activeMenu = 'veiculos';
        $isEdit = true;

        $veiculo = $this->model->buscarPorId($id);
        if (!$veiculo) {
            $_SESSION['mensagem'] = 'Veículo não encontrado.';
            $_SESSION['tipo_mensagem'] = 'danger';
            header('Location: ' . BASE_URL . 'index.php?controller=veiculos&action=index');
            exit;
        }

        $tipos = $this->tipoModel->listar();

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/veiculos/form.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function update($id = null)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
            $dados = [
                'placa'           => trim($_POST['placa'] ?? ''),
                'renavam'         => trim($_POST['renavam'] ?? ''),
                'tipo_veiculo_id' => $_POST['tipo_veiculo_id'] ?? '',
                'marca'           => trim($_POST['marca'] ?? ''),
                'modelo'          => trim($_POST['modelo'] ?? ''),
                'ano_fabricacao'  => trim($_POST['ano_fabricacao'] ?? '')
            ];

            if (empty($dados['placa']) || empty($dados['renavam']) || empty($dados['tipo_veiculo_id'])) {
                $_SESSION['mensagem'] = 'Placa, Renavam e Tipo de Veículo são obrigatórios.';
                $_SESSION['tipo_mensagem'] = 'danger';
                header('Location: ' . BASE_URL . 'index.php?controller=veiculos&action=edit&id=' . $id);
                exit;
            }

            // Remove todos os caracteres não numéricos do renavam e verifica o tamanho
            $renavamLimpo = preg_replace('/\D/', '', $dados['renavam']);
            if (strlen($renavamLimpo) !== 11) {
                $_SESSION['mensagem'] = 'O Renavam deve conter exatamente 11 números.';
                $_SESSION['tipo_mensagem'] = 'danger';
                header('Location: ' . BASE_URL . 'index.php?controller=veiculos&action=edit&id=' . $id);
                exit;
            }

            try {
                $this->model->atualizar($id, $dados);
                $_SESSION['mensagem'] = 'Veículo atualizado com sucesso!';
                $_SESSION['tipo_mensagem'] = 'success';
                header('Location: ' . BASE_URL . 'index.php?controller=veiculos&action=index');
            } catch (Exception $e) {
                $_SESSION['mensagem'] = 'Erro ao atualizar veículo: ' . $e->getMessage();
                $_SESSION['tipo_mensagem'] = 'danger';
                header('Location: ' . BASE_URL . 'index.php?controller=veiculos&action=edit&id=' . $id);
            }
            exit;
        }
        header('Location: ' . BASE_URL . 'index.php?controller=veiculos&action=index');
        exit;
    }

    public function delete($id = null)
    {
        if ($id) {
            try {
                $this->model->excluir($id);
                $_SESSION['mensagem'] = 'Veículo excluído com sucesso!';
                $_SESSION['tipo_mensagem'] = 'success';
            } catch (Exception $e) {
                $_SESSION['mensagem'] = 'Não é possível excluir: veículo pode estar vinculado a multas.';
                $_SESSION['tipo_mensagem'] = 'danger';
            }
        }
        header('Location: ' . BASE_URL . 'index.php?controller=veiculos&action=index');
        exit;
    }

    public function check_placa()
    {
        header('Content-Type: application/json');
        $placa = isset($_GET['placa']) ? trim($_GET['placa']) : '';
        $id = isset($_GET['id']) ? trim($_GET['id']) : null;
        
        if (empty($placa)) {
            echo json_encode(['exists' => false]);
            return;
        }

        $existente = $this->model->buscarPorPlaca($placa, $id);
        echo json_encode(['exists' => $existente ? true : false]);
    }

    public function check_renavam()
    {
        header('Content-Type: application/json');
        $renavam = isset($_GET['renavam']) ? trim($_GET['renavam']) : '';
        $id = isset($_GET['id']) ? trim($_GET['id']) : null;
        
        if (empty($renavam)) {
            echo json_encode(['exists' => false]);
            return;
        }

        $existente = $this->model->buscarPorRenavam($renavam, $id);
        echo json_encode(['exists' => $existente ? true : false]);
    }
}
