<?php

class HomeController
{
    /**
     * Carrega a página inicial do sistema
     */
    public function index()
    {
        $pageTitle = 'TrackMultas - Sistema de Gestão de Multas';

        // Carrega o layout com a view da home
        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/home/index.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }
}
