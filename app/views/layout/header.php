<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="TrackMultas - Sistema de gestão de multas para transportadoras">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'TrackMultas'; ?></title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- TomSelect CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.css" rel="stylesheet">

    <!-- CSS customizado -->
    <link href="<?php echo BASE_URL; ?>assets/css/style.css?v=<?php echo time(); ?>_1" rel="stylesheet">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-navbar sticky-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand d-flex align-items-center gap-2" href="<?php echo BASE_URL; ?>">
                <i class="bi bi-truck fs-4"></i>
                <span class="fw-bold">Track<span class="text-accent">Multas</span></span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <?php if (isset($_SESSION['usuario_id'])): ?>
                <ul class="navbar-nav ms-auto">
                    <?php 
                        $active = isset($_GET['controller']) ? $_GET['controller'] : 'home'; 
                    ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $active === 'home' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>">
                            <i class="bi bi-house-door me-1"></i>Início
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?php echo in_array($active, ['empresas', 'motoristas', 'setores', 'veiculos', 'tipos_veiculos']) ? 'active' : ''; ?>"
                           href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-folder me-1"></i>Cadastros
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li>
                                <a class="dropdown-item <?php echo $active === 'empresas' ? 'active' : ''; ?>"
                                   href="<?php echo BASE_URL; ?>index.php?controller=empresas&action=index">
                                    <i class="bi bi-building me-2"></i>Empresas
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item <?php echo $active === 'motoristas' ? 'active' : ''; ?>"
                                   href="<?php echo BASE_URL; ?>index.php?controller=motoristas&action=index">
                                    <i class="bi bi-person me-2"></i>Motoristas
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item <?php echo $active === 'setores' ? 'active' : ''; ?>"
                                   href="<?php echo BASE_URL; ?>index.php?controller=setores&action=index">
                                    <i class="bi bi-diagram-3 me-2"></i>Setores
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item <?php echo $active === 'veiculos' ? 'active' : ''; ?>"
                                   href="<?php echo BASE_URL; ?>index.php?controller=veiculos&action=index">
                                    <i class="bi bi-truck me-2"></i>Veículos
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item <?php echo $active === 'tipos_veiculos' ? 'active' : ''; ?>"
                                   href="<?php echo BASE_URL; ?>index.php?controller=tipos_veiculos&action=index">
                                    <i class="bi bi-car-front me-2"></i>Tipos de Veículos
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?php echo in_array($active, ['multas', 'orgaos', 'motivos_infracoes', 'categorias_infracoes', 'responsabilidades', 'status_andamento', 'status_pagamento']) ? 'active' : ''; ?>"
                           href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-exclamation-triangle me-1"></i>Controle de Multas
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li>
                                <a class="dropdown-item <?php echo ($active === 'multas' && (!isset($_GET['action']) || $_GET['action'] === 'index')) ? 'active' : ''; ?>"
                                   href="<?php echo BASE_URL; ?>index.php?controller=multas&action=index">
                                    <i class="bi bi-list-ul me-2"></i>Listar Multas
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item <?php echo ($active === 'multas' && isset($_GET['action']) && $_GET['action'] === 'create') ? 'active' : ''; ?>"
                                   href="<?php echo BASE_URL; ?>index.php?controller=multas&action=create">
                                    <i class="bi bi-plus-lg me-2"></i>Nova Multa
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item <?php echo $active === 'orgaos' ? 'active' : ''; ?>"
                                   href="<?php echo BASE_URL; ?>index.php?controller=orgaos&action=index">
                                    <i class="bi bi-building-gear me-2"></i>Órgãos Autuadores
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item <?php echo $active === 'categorias_infracoes' ? 'active' : ''; ?>"
                                   href="<?php echo BASE_URL; ?>index.php?controller=categorias_infracoes&action=index">
                                    <i class="bi bi-tags me-2"></i>Categorias de Infrações
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item <?php echo $active === 'motivos_infracoes' ? 'active' : ''; ?>"
                                   href="<?php echo BASE_URL; ?>index.php?controller=motivos_infracoes&action=index">
                                    <i class="bi bi-exclamation-octagon me-2"></i>Motivos de Infração
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item <?php echo $active === 'responsabilidades' ? 'active' : ''; ?>"
                                   href="<?php echo BASE_URL; ?>index.php?controller=responsabilidades&action=index">
                                    <i class="bi bi-person-badge me-2"></i>Responsabilidades
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item <?php echo $active === 'status_andamento' ? 'active' : ''; ?>"
                                   href="<?php echo BASE_URL; ?>index.php?controller=status_andamento&action=index">
                                    <i class="bi bi-arrow-repeat me-2"></i>Status de Andamento
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item <?php echo $active === 'status_pagamento' ? 'active' : ''; ?>"
                                   href="<?php echo BASE_URL; ?>index.php?controller=status_pagamento&action=index">
                                    <i class="bi bi-currency-dollar me-2"></i>Status de Pagamento
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#">
                            <i class="bi bi-graph-up me-1"></i>Dashboard
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-3">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-1"></i><?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                            <li>
                                <a class="dropdown-item text-danger" href="<?php echo BASE_URL; ?>index.php?controller=auth&action=logout">
                                    <i class="bi bi-box-arrow-right me-2"></i>Sair
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Exibição de Mensagens (Alerts) -->
    <?php if (isset($_SESSION['mensagem'])): ?>
        <div class="container-fluid px-4 mt-3">
            <div class="alert alert-<?php echo isset($_SESSION['tipo_mensagem']) ? $_SESSION['tipo_mensagem'] : 'info'; ?> alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['mensagem']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        <?php 
            unset($_SESSION['mensagem']);
            unset($_SESSION['tipo_mensagem']);
        ?>
    <?php endif; ?>
