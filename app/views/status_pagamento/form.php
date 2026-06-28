<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><?php echo isset($status) ? 'Editar Status de Pagamento' : 'Novo Status de Pagamento'; ?></h2>
        <a href="<?php echo BASE_URL; ?>index.php?controller=status_pagamento&action=index" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form action="<?php echo BASE_URL; ?>index.php?controller=status_pagamento&action=<?php echo isset($status) ? 'update' : 'store'; ?>" method="POST">
                        
                        <?php if (isset($status)): ?>
                            <input type="hidden" name="id" value="<?php echo $status['id']; ?>">
                        <?php endif; ?>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nome" class="form-label fw-semibold">Nome <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nome" name="nome" 
                                       value="<?php echo isset($status) ? htmlspecialchars($status['nome']) : ''; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="cor" class="form-label fw-semibold">Cor</label>
                                <select class="form-select" id="cor" name="cor">
                                    <option value="bg-success" <?php echo (isset($status) && $status['cor'] == 'bg-success') ? 'selected' : ''; ?>>Verde</option>
                                    <option value="bg-danger" <?php echo (isset($status) && $status['cor'] == 'bg-danger') ? 'selected' : ''; ?>>Vermelho</option>
                                    <option value="bg-warning text-dark" <?php echo (isset($status) && $status['cor'] == 'bg-warning text-dark') ? 'selected' : ''; ?>>Amarelo</option>
                                    <option value="bg-info" <?php echo (isset($status) && $status['cor'] == 'bg-info') ? 'selected' : ''; ?>>Azul</option>
                                    <option value="bg-secondary" <?php echo (isset($status) && $status['cor'] == 'bg-secondary') ? 'selected' : ''; ?>>Cinza</option>
                                    <option value="bg-dark" <?php echo (isset($status) && $status['cor'] == 'bg-dark') ? 'selected' : ''; ?>>Preto</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top text-end">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-check-lg me-1"></i> Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>