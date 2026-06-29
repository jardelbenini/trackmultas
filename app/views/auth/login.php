<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="TrackMultas - Login">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'Login - TrackMultas'; ?></title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- CSS customizado -->
    <link href="<?php echo BASE_URL; ?>assets/css/style.css?v=<?php echo time(); ?>" rel="stylesheet">

    <style>
        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0f1117 0%, #1a1d27 50%, #13151d 100%);
        }

        .login-card {
            background: rgba(26, 29, 39, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 20px;
            padding: 2.5rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(12px);
        }

        .login-logo {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -1px;
            color: #e8eaf0;
            text-align: center;
            margin-bottom: 0.25rem;
        }

        .login-logo .text-accent {
            color: #4f8cff;
        }

        .login-subtitle {
            text-align: center;
            color: #8b8fa3;
            font-size: 0.95rem;
            margin-bottom: 2rem;
        }

        .login-icon {
            text-align: center;
            margin-bottom: 1.25rem;
        }

        .login-icon i {
            font-size: 3rem;
            color: #4f8cff;
            filter: drop-shadow(0 0 12px rgba(79, 140, 255, 0.3));
        }

        .login-card .form-label {
            color: #8b8fa3;
            font-weight: 500;
            font-size: 0.875rem;
        }

        .login-card .form-control {
            background-color: #1e2130;
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #e8eaf0;
            border-radius: 10px;
            padding: 0.7rem 1rem;
            font-size: 0.95rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .login-card .form-control:focus {
            background-color: #1e2130;
            border-color: #4f8cff;
            box-shadow: 0 0 0 3px rgba(79, 140, 255, 0.15);
            color: #e8eaf0;
        }

        .login-card .form-control::placeholder {
            color: #555870;
        }

        .login-card .btn-primary {
            background: linear-gradient(135deg, #4f8cff, #3a6fd8);
            border: none;
            border-radius: 10px;
            padding: 0.75rem;
            font-weight: 600;
            font-size: 1rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .login-card .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(79, 140, 255, 0.35);
        }

        .login-card .input-group-text {
            background-color: #1e2130;
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #8b8fa3;
            border-radius: 10px 0 0 10px;
        }

        .login-card .input-group .form-control {
            border-radius: 0 10px 10px 0;
        }

        .login-footer {
            text-align: center;
            margin-top: 1.5rem;
            color: #555870;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-icon">
                <i class="bi bi-shield-lock"></i>
            </div>
            <div class="login-logo">
                Track<span class="text-accent">Multas</span>
            </div>
            <p class="login-subtitle">Acesso ao sistema</p>

            <?php if (isset($_SESSION['mensagem'])): ?>
                <div class="alert alert-<?php echo isset($_SESSION['tipo_mensagem']) ? $_SESSION['tipo_mensagem'] : 'info'; ?> alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['mensagem']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php
                    unset($_SESSION['mensagem']);
                    unset($_SESSION['tipo_mensagem']);
                ?>
            <?php endif; ?>

            <form action="<?php echo BASE_URL; ?>index.php?controller=auth&action=autenticar" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control" id="email" name="email" placeholder="seu@email.com" required autofocus>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="senha" class="form-label">Senha</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control" id="senha" name="senha" placeholder="Sua senha" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Entrar
                </button>
            </form>

            <div class="login-footer">
                &copy; <?php echo date('Y'); ?> TrackMultas &mdash; Sistema de Gestão de Multas
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
