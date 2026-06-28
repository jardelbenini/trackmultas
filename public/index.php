<?php
session_start();

/**
 * TrackMultas - Roteador Principal (Etapa 3)
 */

// Carrega configurações
require_once __DIR__ . '/../config/config.php';

// Carrega os models auxiliares (Database é a base)
require_once __DIR__ . '/../app/models/Database.php';

// Obtém o controller e a action da URL
$controllerParam = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$actionParam = isset($_GET['action']) ? $_GET['action'] : 'index';

// Mapeamento de controllers permitidos
$allowedControllers = [
    'home'              => 'HomeController',
    'empresas'          => 'EmpresaController',
    'motoristas'        => 'MotoristaController',
    'veiculos'          => 'VeiculoController',
    'multas'            => 'MultaController',
    'orgaos'            => 'OrgaoController',
    'motivos_infracoes' => 'MotivoInfracaoController',
    'categorias_infracoes' => 'CategoriaInfracaoController',
    'responsabilidades' => 'ResponsabilidadeController',
    'status_andamento'  => 'StatusAndamentoController',
    'status_pagamento'  => 'StatusPagamentoController'
];

// Ações permitidas
$allowedActions = ['index', 'create', 'store', 'show', 'edit', 'update', 'delete', 'check_codigo', 'get_details'];

if (array_key_exists($controllerParam, $allowedControllers)) {
    $controllerName = $allowedControllers[$controllerParam];
    $controllerFile = __DIR__ . '/../app/controllers/' . $controllerName . '.php';

    if (file_exists($controllerFile)) {
        require_once $controllerFile;
        $controller = new $controllerName();

        if (in_array($actionParam, $allowedActions) && method_exists($controller, $actionParam)) {
            // Se precisar passar o ID
            $id = isset($_GET['id']) ? $_GET['id'] : null;
            
            if (in_array($actionParam, ['show', 'edit', 'update', 'delete'])) {
                $controller->$actionParam($id);
            } else {
                $controller->$actionParam();
            }
        } else {
            http_response_code(404);
            echo '<h1>Erro 404</h1><p>Ação não encontrada ou não permitida.</p>';
        }
    } else {
        http_response_code(404);
        echo '<h1>Erro 404</h1><p>Controlador não encontrado.</p>';
    }
} else {
    http_response_code(404);
    echo '<h1>Erro 404</h1><p>Página não encontrada.</p>';
}
