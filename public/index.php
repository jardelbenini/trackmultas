<?php

/**
 * TrackMultas - Roteador Principal
 *
 * Ponto de entrada do sistema. Carrega as configurações,
 * interpreta a URL e direciona para o controller adequado.
 */

// Carrega configurações
require_once __DIR__ . '/../config/config.php';

// Carrega os models
require_once __DIR__ . '/../app/models/Database.php';

// Obtém a URL requisitada
$url = isset($_GET['url']) ? $_GET['url'] : '';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// Define o controller padrão
$controllerName = !empty($url[0]) ? ucfirst($url[0]) . 'Controller' : 'HomeController';
$methodName     = isset($url[1]) ? $url[1] : 'index';
$params         = array_slice($url, 2);

// Caminho do controller
$controllerFile = __DIR__ . '/../app/controllers/' . $controllerName . '.php';

// Verifica se o controller existe
if (file_exists($controllerFile)) {
    require_once $controllerFile;

    $controller = new $controllerName();

    // Verifica se o método existe no controller
    if (method_exists($controller, $methodName)) {
        call_user_func_array([$controller, $methodName], $params);
    } else {
        http_response_code(404);
        echo '<h1>Erro 404</h1><p>Método não encontrado.</p>';
    }
} else {
    http_response_code(404);
    echo '<h1>Erro 404</h1><p>Página não encontrada.</p>';
}
