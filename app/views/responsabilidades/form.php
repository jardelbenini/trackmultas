<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><?php echo isset($responsabilidade) ? 'Editar Responsabilidade' : 'Nova Responsabilidade'; ?></h2>
        <a href="<?php echo BASE_URL; ?>index.php?controller=responsabilidades&action=index" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form action="<?php echo BASE_URL; ?>index.php?controller=responsabilidades&action=<?php echo isset($responsabilidade) ? 'update' : 'store'; ?>" method="POST">
                        
                        <?php if (isset($responsabilidade)): ?>
                            <input type="hidden" name="id" value="<?php echo $responsabilidade['id']; ?>">
                        <?php endif; ?>

                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="nome" class="form-label fw-semibold">Nome <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nome" name="nome" 
                                       value="<?php echo isset($responsabilidade) ? htmlspecialchars($responsabilidade['nome']) : ''; ?>" required oninput="this.value = this.value.toUpperCase()">
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