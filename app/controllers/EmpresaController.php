<?php

require_once __DIR__ . '/../models/Empresa.php';

class EmpresaController
{
    private $model;

    public function __construct()
    {
        $this->model = new Empresa();
    }

    private function validarCNPJ($cnpj)
    {
        $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);

        // Valida tamanho
        if (strlen($cnpj) != 14)
            return false;

        // Verifica se todos os digitos são iguais
        if (preg_match('/(\d)\1{13}/', $cnpj))
            return false;

        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto))
            return false;

        // Valida segundo dígito verificador
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
    }

    public function index()
    {
        $pageTitle = 'Empresas - TrackMultas';
        $activeMenu = 'empresas';

        $empresas = $this->model->listar();

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/empresas/index.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function create()
    {
        $pageTitle = 'Nova Empresa - TrackMultas';
        $activeMenu = 'empresas';
        $isEdit = false;
        $empresa = null;

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/empresas/form.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
            $cnpj = isset($_POST['cnpj']) ? trim($_POST['cnpj']) : '';

            if (empty($nome)) {
                $_SESSION['mensagem'] = 'O nome da empresa é obrigatório.';
                $_SESSION['tipo_mensagem'] = 'danger';
                header('Location: ' . BASE_URL . 'index.php?controller=empresas&action=create');
                exit;
            }

            if (!empty($cnpj)) {
                if (!$this->validarCNPJ($cnpj)) {
                    $_SESSION['mensagem'] = 'O CNPJ informado é inválido.';
                    $_SESSION['tipo_mensagem'] = 'danger';
                    header('Location: ' . BASE_URL . 'index.php?controller=empresas&action=create');
                    exit;
                }

                $existente = $this->model->buscarPorCnpj($cnpj);
                if ($existente) {
                    $_SESSION['mensagem'] = 'Já existe uma empresa cadastrada com este CNPJ.';
                    $_SESSION['tipo_mensagem'] = 'danger';
                    header('Location: ' . BASE_URL . 'index.php?controller=empresas&action=create');
                    exit;
                }
            }

            try {
                $this->model->cadastrar($nome, $cnpj);
                $_SESSION['mensagem'] = 'Empresa cadastrada com sucesso!';
                $_SESSION['tipo_mensagem'] = 'success';
                header('Location: ' . BASE_URL . 'index.php?controller=empresas&action=index');
            } catch (Exception $e) {
                $_SESSION['mensagem'] = 'Erro ao cadastrar empresa: ' . $e->getMessage();
                $_SESSION['tipo_mensagem'] = 'danger';
                header('Location: ' . BASE_URL . 'index.php?controller=empresas&action=create');
            }
            exit;
        }
        header('Location: ' . BASE_URL . 'index.php?controller=empresas&action=index');
        exit;
    }

    public function edit($id = null)
    {
        if (!$id) {
            header('Location: ' . BASE_URL . 'index.php?controller=empresas&action=index');
            exit;
        }

        $pageTitle = 'Editar Empresa - TrackMultas';
        $activeMenu = 'empresas';
        $isEdit = true;

        $empresa = $this->model->buscarPorId($id);
        if (!$empresa) {
            $_SESSION['mensagem'] = 'Empresa não encontrada.';
            $_SESSION['tipo_mensagem'] = 'danger';
            header('Location: ' . BASE_URL . 'index.php?controller=empresas&action=index');
            exit;
        }

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/empresas/form.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function update($id = null)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
            $nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
            $cnpj = isset($_POST['cnpj']) ? trim($_POST['cnpj']) : '';

            if (empty($nome)) {
                $_SESSION['mensagem'] = 'O nome da empresa é obrigatório.';
                $_SESSION['tipo_mensagem'] = 'danger';
                header('Location: ' . BASE_URL . 'index.php?controller=empresas&action=edit&id=' . $id);
                exit;
            }

            if (!empty($cnpj)) {
                if (!$this->validarCNPJ($cnpj)) {
                    $_SESSION['mensagem'] = 'O CNPJ informado é inválido.';
                    $_SESSION['tipo_mensagem'] = 'danger';
                    header('Location: ' . BASE_URL . 'index.php?controller=empresas&action=edit&id=' . $id);
                    exit;
                }

                $existente = $this->model->buscarPorCnpj($cnpj, $id);
                if ($existente) {
                    $_SESSION['mensagem'] = 'Já existe outra empresa cadastrada com este CNPJ.';
                    $_SESSION['tipo_mensagem'] = 'danger';
                    header('Location: ' . BASE_URL . 'index.php?controller=empresas&action=edit&id=' . $id);
                    exit;
                }
            }

            try {
                $this->model->atualizar($id, $nome, $cnpj);
                $_SESSION['mensagem'] = 'Empresa atualizada com sucesso!';
                $_SESSION['tipo_mensagem'] = 'success';
                header('Location: ' . BASE_URL . 'index.php?controller=empresas&action=index');
            } catch (Exception $e) {
                $_SESSION['mensagem'] = 'Erro ao atualizar empresa: ' . $e->getMessage();
                $_SESSION['tipo_mensagem'] = 'danger';
                header('Location: ' . BASE_URL . 'index.php?controller=empresas&action=edit&id=' . $id);
            }
            exit;
        }
        header('Location: ' . BASE_URL . 'index.php?controller=empresas&action=index');
        exit;
    }

    public function delete($id = null)
    {
        if ($id) {
            try {
                $this->model->excluir($id);
                $_SESSION['mensagem'] = 'Empresa excluída com sucesso!';
                $_SESSION['tipo_mensagem'] = 'success';
            } catch (Exception $e) {
                $_SESSION['mensagem'] = 'Não é possível excluir: empresa pode estar vinculada a motoristas.';
                $_SESSION['tipo_mensagem'] = 'danger';
            }
        }
        header('Location: ' . BASE_URL . 'index.php?controller=empresas&action=index');
        exit;
    }
}
