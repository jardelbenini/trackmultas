<?php

require_once __DIR__ . '/../models/Motorista.php';
require_once __DIR__ . '/../models/Empresa.php';
require_once __DIR__ . '/../models/Setor.php';
require_once __DIR__ . '/../models/StatusMotorista.php';

class MotoristaController
{
    private $model;
    private $empresaModel;
    private $setorModel;
    private $statusModel;

    public function __construct()
    {
        $this->model = new Motorista();
        $this->empresaModel = new Empresa();
        $this->setorModel = new Setor();
        $this->statusModel = new StatusMotorista();
    }

    private function validarCPF($cpf)
    {
        $cpf = preg_replace('/[^0-9]/', '', (string) $cpf);

        if (strlen($cpf) != 11)
            return false;

        if (preg_match('/(\d)\1{10}/', $cpf))
            return false;

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }

    public function index()
    {
        $pageTitle = 'Motoristas - TrackMultas';
        $activeMenu = 'motoristas';

        $motoristas = $this->model->listar();

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/motoristas/index.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function create()
    {
        $pageTitle = 'Novo Motorista - TrackMultas';
        $activeMenu = 'motoristas';
        $isEdit = false;
        $motorista = null;

        $empresas = $this->empresaModel->listar();
        $setores = $this->setorModel->listar();
        $statusList = $this->statusModel->listar();

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/motoristas/form.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'empresa_id'    => $_POST['empresa_id'] ?? '',
                'matricula'     => trim($_POST['matricula'] ?? ''),
                'nome'          => trim($_POST['nome'] ?? ''),
                'cpf'           => trim($_POST['cpf'] ?? ''),
                'setor_id'      => $_POST['setor_id'] ?? '',
                'status_id'     => $_POST['status_id'] ?? '',
                'data_admissao' => trim($_POST['data_admissao'] ?? '')
            ];

            if (empty($dados['empresa_id']) || empty($dados['nome']) || empty($dados['setor_id']) || empty($dados['status_id'])) {
                $_SESSION['mensagem'] = 'Empresa, Nome, Setor e Status são obrigatórios.';
                $_SESSION['tipo_mensagem'] = 'danger';
                header('Location: ' . BASE_URL . 'index.php?controller=motoristas&action=create');
                exit;
            }

            if (!empty($dados['cpf']) && !$this->validarCPF($dados['cpf'])) {
                $_SESSION['mensagem'] = 'O CPF informado é inválido.';
                $_SESSION['tipo_mensagem'] = 'danger';
                header('Location: ' . BASE_URL . 'index.php?controller=motoristas&action=create');
                exit;
            }

            try {
                $this->model->cadastrar($dados);
                $_SESSION['mensagem'] = 'Motorista cadastrado com sucesso!';
                $_SESSION['tipo_mensagem'] = 'success';
                header('Location: ' . BASE_URL . 'index.php?controller=motoristas&action=index');
            } catch (Exception $e) {
                $_SESSION['mensagem'] = 'Erro ao cadastrar motorista: ' . $e->getMessage();
                $_SESSION['tipo_mensagem'] = 'danger';
                header('Location: ' . BASE_URL . 'index.php?controller=motoristas&action=create');
            }
            exit;
        }
        header('Location: ' . BASE_URL . 'index.php?controller=motoristas&action=index');
        exit;
    }

    public function edit($id = null)
    {
        if (!$id) {
            header('Location: ' . BASE_URL . 'index.php?controller=motoristas&action=index');
            exit;
        }

        $pageTitle = 'Editar Motorista - TrackMultas';
        $activeMenu = 'motoristas';
        $isEdit = true;

        $motorista = $this->model->buscarPorId($id);
        if (!$motorista) {
            $_SESSION['mensagem'] = 'Motorista não encontrado.';
            $_SESSION['tipo_mensagem'] = 'danger';
            header('Location: ' . BASE_URL . 'index.php?controller=motoristas&action=index');
            exit;
        }

        $empresas = $this->empresaModel->listar();
        $setores = $this->setorModel->listar();
        $statusList = $this->statusModel->listar();

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/motoristas/form.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function update($id = null)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
            $dados = [
                'empresa_id'    => $_POST['empresa_id'] ?? '',
                'matricula'     => trim($_POST['matricula'] ?? ''),
                'nome'          => trim($_POST['nome'] ?? ''),
                'cpf'           => trim($_POST['cpf'] ?? ''),
                'setor_id'      => $_POST['setor_id'] ?? '',
                'status_id'     => $_POST['status_id'] ?? '',
                'data_admissao' => trim($_POST['data_admissao'] ?? '')
            ];

            if (empty($dados['empresa_id']) || empty($dados['nome']) || empty($dados['setor_id']) || empty($dados['status_id'])) {
                $_SESSION['mensagem'] = 'Empresa, Nome, Setor e Status são obrigatórios.';
                $_SESSION['tipo_mensagem'] = 'danger';
                header('Location: ' . BASE_URL . 'index.php?controller=motoristas&action=edit&id=' . $id);
                exit;
            }

            if (!empty($dados['cpf']) && !$this->validarCPF($dados['cpf'])) {
                $_SESSION['mensagem'] = 'O CPF informado é inválido.';
                $_SESSION['tipo_mensagem'] = 'danger';
                header('Location: ' . BASE_URL . 'index.php?controller=motoristas&action=edit&id=' . $id);
                exit;
            }

            try {
                $this->model->atualizar($id, $dados);
                $_SESSION['mensagem'] = 'Motorista atualizado com sucesso!';
                $_SESSION['tipo_mensagem'] = 'success';
                header('Location: ' . BASE_URL . 'index.php?controller=motoristas&action=index');
            } catch (Exception $e) {
                $_SESSION['mensagem'] = 'Erro ao atualizar motorista: ' . $e->getMessage();
                $_SESSION['tipo_mensagem'] = 'danger';
                header('Location: ' . BASE_URL . 'index.php?controller=motoristas&action=edit&id=' . $id);
            }
            exit;
        }
        header('Location: ' . BASE_URL . 'index.php?controller=motoristas&action=index');
        exit;
    }

    public function delete($id = null)
    {
        if ($id) {
            try {
                $this->model->excluir($id);
                $_SESSION['mensagem'] = 'Motorista excluído com sucesso!';
                $_SESSION['tipo_mensagem'] = 'success';
            } catch (Exception $e) {
                $_SESSION['mensagem'] = 'Não é possível excluir: motorista pode estar vinculado a multas.';
                $_SESSION['tipo_mensagem'] = 'danger';
            }
        }
        header('Location: ' . BASE_URL . 'index.php?controller=motoristas&action=index');
        exit;
    }

    public function check_cpf()
    {
        header('Content-Type: application/json');
        $cpf = isset($_GET['cpf']) ? trim($_GET['cpf']) : '';
        $id = isset($_GET['id']) ? trim($_GET['id']) : null;
        
        if (empty($cpf)) {
            echo json_encode(['exists' => false]);
            return;
        }

        $existente = $this->model->buscarPorCpf($cpf, $id);
        echo json_encode(['exists' => $existente ? true : false]);
    }

    public function check_matricula()
    {
        header('Content-Type: application/json');
        $matricula = isset($_GET['matricula']) ? trim($_GET['matricula']) : '';
        $id = isset($_GET['id']) ? trim($_GET['id']) : null;
        
        if (empty($matricula)) {
            echo json_encode(['exists' => false]);
            return;
        }

        $existente = $this->model->buscarPorMatricula($matricula, $id);
        echo json_encode(['exists' => $existente ? true : false]);
    }
}
