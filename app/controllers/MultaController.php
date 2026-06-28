<?php

require_once __DIR__ . '/../models/Multa.php';
require_once __DIR__ . '/../models/Motorista.php';
require_once __DIR__ . '/../models/Veiculo.php';
require_once __DIR__ . '/../models/Orgao.php';
require_once __DIR__ . '/../models/MotivoInfracao.php';
require_once __DIR__ . '/../models/Responsabilidade.php';
require_once __DIR__ . '/../models/StatusMotorista.php';
require_once __DIR__ . '/../models/StatusAndamentoMulta.php';
require_once __DIR__ . '/../models/StatusPagamento.php';

class MultaController
{
    private $model;
    private $motoristaModel;
    private $veiculoModel;
    private $orgaoModel;
    private $motivoModel;
    private $responsabilidadeModel;
    private $statusMotoristaModel;
    private $statusAndamentoModel;
    private $statusPagamentoModel;

    public function __construct()
    {
        $this->model = new Multa();
        $this->motoristaModel = new Motorista();
        $this->veiculoModel = new Veiculo();
        $this->orgaoModel = new Orgao();
        $this->motivoModel = new MotivoInfracao();
        $this->responsabilidadeModel = new Responsabilidade();
        $this->statusMotoristaModel = new StatusMotorista();
        $this->statusAndamentoModel = new StatusAndamentoMulta();
        $this->statusPagamentoModel = new StatusPagamento();
    }

    public function index()
    {
        $pageTitle = 'Controle de Multas - TrackMultas';
        $activeMenu = 'multas';

        $multas = $this->model->listar();

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/multas/index.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    private function loadSelects()
    {
        return [
            'motoristas'        => $this->motoristaModel->listar(),
            'veiculos'          => $this->veiculoModel->listar(),
            'orgaos'            => $this->orgaoModel->listar(),
            'motivos'           => $this->motivoModel->listar(),
            'responsabilidades' => $this->responsabilidadeModel->listar(),
            'statusMotoristas'  => $this->statusMotoristaModel->listar(),
            'statusAndamentos'  => $this->statusAndamentoModel->listar(),
            'statusPagamentos'  => $this->statusPagamentoModel->listar()
        ];
    }

    public function create()
    {
        $pageTitle = 'Nova Multa - TrackMultas';
        $activeMenu = 'multas';
        $isEdit = false;
        
        if (isset($_SESSION['old_data'])) {
            $multa = $_SESSION['old_data'];
            $parcelas = $_SESSION['old_parcelas'] ?? [];
            unset($_SESSION['old_data'], $_SESSION['old_parcelas']);
        } else {
            $multa = null;
            $parcelas = [];
        }

        extract($this->loadSelects());

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/multas/form.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = $this->getPostData();

            if (!$this->validateRequired($dados)) {
                $_SESSION['mensagem'] = 'Preencha todos os campos obrigatórios.';
                $_SESSION['tipo_mensagem'] = 'danger';
                $_SESSION['old_data'] = $dados;
                $_SESSION['old_parcelas'] = $this->extractParcelas();
                header('Location: ' . BASE_URL . 'index.php?controller=multas&action=create');
                exit;
            }

            try {
                $multa_id = $this->model->cadastrar($dados);
                if ($multa_id) {
                    $parcelas = $this->extractParcelas();
                    $this->model->salvarParcelas($multa_id, $parcelas);
                }
                $_SESSION['mensagem'] = 'Multa cadastrada com sucesso.';
                $_SESSION['tipo_mensagem'] = 'success';
                header('Location: ' . BASE_URL . 'index.php?controller=multas&action=index');
            } catch (Exception $e) {
                $_SESSION['mensagem'] = 'Erro ao salvar a multa: ' . $e->getMessage();
                $_SESSION['tipo_mensagem'] = 'danger';
                $_SESSION['old_data'] = $dados;
                $_SESSION['old_parcelas'] = $this->extractParcelas();
                header('Location: ' . BASE_URL . 'index.php?controller=multas&action=create');
            }
            exit;
        }
        header('Location: ' . BASE_URL . 'index.php?controller=multas&action=index');
        exit;
    }

    public function show($id = null)
    {
        if (!$id) {
            header('Location: ' . BASE_URL . 'index.php?controller=multas&action=index');
            exit;
        }

        $pageTitle = 'Detalhes da Multa - TrackMultas';
        $activeMenu = 'multas';

        $multa = $this->model->buscarPorId($id);
        if (!$multa) {
            $_SESSION['mensagem'] = 'Multa não encontrada.';
            $_SESSION['tipo_mensagem'] = 'danger';
            header('Location: ' . BASE_URL . 'index.php?controller=multas&action=index');
            exit;
        }

        $parcelas = $this->model->buscarParcelas($id);

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/multas/show.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function edit($id = null)
    {
        if (!$id) {
            header('Location: ' . BASE_URL . 'index.php?controller=multas&action=index');
            exit;
        }

        $pageTitle = 'Editar Multa - TrackMultas';
        $activeMenu = 'multas';
        $isEdit = true;

        $multa = $this->model->buscarPorId($id);
        if (!$multa) {
            $_SESSION['mensagem'] = 'Multa não encontrada.';
            $_SESSION['tipo_mensagem'] = 'danger';
            header('Location: ' . BASE_URL . 'index.php?controller=multas&action=index');
            exit;
        }

        $parcelas = $this->model->buscarParcelas($id);
        
        if (isset($_SESSION['old_data'])) {
            $multa = array_merge($multa, $_SESSION['old_data']);
            $parcelas = $_SESSION['old_parcelas'] ?? [];
            unset($_SESSION['old_data'], $_SESSION['old_parcelas']);
        }

        extract($this->loadSelects());

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/multas/form.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function update($id = null)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
            $dados = $this->getPostData();

            if (!$this->validateRequired($dados)) {
                $_SESSION['mensagem'] = 'Preencha todos os campos obrigatórios.';
                $_SESSION['tipo_mensagem'] = 'danger';
                $_SESSION['old_data'] = $dados;
                $_SESSION['old_parcelas'] = $this->extractParcelas();
                header('Location: ' . BASE_URL . 'index.php?controller=multas&action=edit&id=' . $id);
                exit;
            }

            try {
                $this->model->atualizar($id, $dados);
                $parcelas = $this->extractParcelas();
                $this->model->salvarParcelas($id, $parcelas);
                
                $_SESSION['mensagem'] = 'Multa atualizada com sucesso.';
                $_SESSION['tipo_mensagem'] = 'success';
                header('Location: ' . BASE_URL . 'index.php?controller=multas&action=index');
            } catch (Exception $e) {
                $_SESSION['mensagem'] = 'Erro ao atualizar a multa: ' . $e->getMessage();
                $_SESSION['tipo_mensagem'] = 'danger';
                $_SESSION['old_data'] = $dados;
                $_SESSION['old_parcelas'] = $this->extractParcelas();
                header('Location: ' . BASE_URL . 'index.php?controller=multas&action=edit&id=' . $id);
            }
            exit;
        }
        header('Location: ' . BASE_URL . 'index.php?controller=multas&action=index');
        exit;
    }

    private function extractParcelas()
    {
        $parcelas = [];
        if (isset($_POST['parcela_numero']) && is_array($_POST['parcela_numero'])) {
            foreach ($_POST['parcela_numero'] as $index => $numero) {
                $parcelas[] = [
                    'numero_parcela'  => $numero,
                    'valor'           => $this->unmaskMoney($_POST['parcela_valor'][$index] ?? ''),
                    'data_vencimento' => trim($_POST['parcela_vencimento'][$index] ?? ''),
                    'data_pagamento'  => trim($_POST['parcela_pagamento'][$index] ?? '')
                ];
            }
        }
        return $parcelas;
    }

    private function unmaskMoney($val)
    {
        if (empty($val)) return 0.00;
        // Remove R$, spaces and dots
        $val = str_replace(['R$', ' ', '.'], '', $val);
        // Replace comma with dot
        $val = str_replace(',', '.', $val);
        return floatval($val);
    }

    public function delete($id = null)
    {
        if ($id) {
            try {
                $this->model->excluir($id);
                $_SESSION['mensagem'] = 'Multa excluída com sucesso.';
                $_SESSION['tipo_mensagem'] = 'success';
            } catch (Exception $e) {
                $_SESSION['mensagem'] = 'Erro ao excluir a multa: ' . $e->getMessage();
                $_SESSION['tipo_mensagem'] = 'danger';
            }
        }
        header('Location: ' . BASE_URL . 'index.php?controller=multas&action=index');
        exit;
    }

    private function getPostData()
    {
        $valorPagoMotorista = $this->unmaskMoney($_POST['valor_pago_motorista'] ?? '');
        $valorPagoEmpresa = $this->unmaskMoney($_POST['valor_pago_empresa'] ?? '');
        $resultadoFinanceiro = $valorPagoMotorista - $valorPagoEmpresa;

        return [
            'motorista_id'           => $_POST['motorista_id'] ?? '',
            'veiculo_id'             => $_POST['veiculo_id'] ?? '',
            'auto_infracao'          => trim($_POST['auto_infracao'] ?? ''),
            'data_infracao'          => trim($_POST['data_infracao'] ?? ''),
            'hora_infracao'          => trim($_POST['hora_infracao'] ?? ''),
            'local_multa'            => trim($_POST['local_multa'] ?? ''),
            'cidade'                 => trim($_POST['cidade'] ?? ''),
            'estado'                 => trim($_POST['estado'] ?? ''),
            'orgao_id'               => $_POST['orgao_id'] ?? '',
            'motivo_infracao_id'     => $_POST['motivo_infracao_id'] ?? '',
            'responsabilidade_id'    => $_POST['responsabilidade_id'] ?? '',
            'status_motorista_id'    => $_POST['status_motorista_id'] ?? '',
            'status_andamento_id'    => $_POST['status_andamento_id'] ?? '',
            'prazo_indicar_condutor' => trim($_POST['prazo_indicar_condutor'] ?? ''),
            'valor_real'             => $this->unmaskMoney($_POST['valor_real'] ?? ''),
            'motorista_pagou'        => $_POST['motorista_pagou'] ?? '',
            'valor_acordado'         => $this->unmaskMoney($_POST['valor_acordado'] ?? ''),
            'valor_pago_motorista'   => $valorPagoMotorista,
            'valor_pago_empresa'     => $valorPagoEmpresa,
            'status_pagamento_id'    => $_POST['status_pagamento_id'] ?? '',
            'data_vencimento'        => trim($_POST['data_vencimento'] ?? ''),
            'data_pagamento'         => trim($_POST['data_pagamento'] ?? ''),
            'data_acerto_motorista'  => trim($_POST['data_acerto_motorista'] ?? ''),
            'desconto_pagamento'     => $_POST['desconto_pagamento'] ?? '',
            'resultado_financeiro'   => $resultadoFinanceiro,
            'tratativa'              => trim($_POST['tratativa'] ?? '')
        ];
    }

    private function validateRequired($dados)
    {
        $requiredFields = [
            'motorista_id', 'veiculo_id', 'auto_infracao', 'data_infracao', 
            'hora_infracao', 'local_multa', 'cidade', 'estado', 'orgao_id', 
            'motivo_infracao_id', 'responsabilidade_id', 'status_motorista_id', 
            'status_andamento_id', 'status_pagamento_id'
        ];

        foreach ($requiredFields as $field) {
            if (empty($dados[$field])) {
                return false;
            }
        }
        return true;
    }
}
