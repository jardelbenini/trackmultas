<div class="container-fluid px-4 py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h4 class="mb-0"><?php echo isset($isEdit) && $isEdit ? 'Editar Setor' : 'Novo Setor'; ?></h4>
                </div>
                <div class="card-body p-4">
                    
                    <?php 
                        $actionUrl = isset($isEdit) && $isEdit 
                            ? BASE_URL . 'index.php?controller=setores&action=update&id=' . $setor['id'] 
                            : BASE_URL . 'index.php?controller=setores&action=store';
                    ?>
                    
                    <form action="<?php echo $actionUrl; ?>" method="POST">
                        <div class="mb-4">
                            <label for="nome" class="form-label">Nome do Setor <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nome" name="nome" value="<?php echo isset($setor['nome']) ? htmlspecialchars($setor['nome']) : ''; ?>" required oninput="this.value = this.value.toUpperCase()">
                        </div>

                        <div class="d-flex justify-content-between pt-3 border-top">
                            <a href="<?php echo BASE_URL; ?>index.php?controller=setores&action=index" class="btn btn-light">Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Salvar
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
