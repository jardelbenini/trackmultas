<div class="container-fluid px-4 py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h4 class="mb-4"><?php echo isset($isEdit) && $isEdit ? 'Editar Categoria' : 'Nova Categoria'; ?></h4>
                    
                    <?php 
                        $actionUrl = isset($isEdit) && $isEdit 
                            ? BASE_URL . 'index.php?controller=categorias_infracoes&action=update&id=' . $categoria['id'] 
                            : BASE_URL . 'index.php?controller=categorias_infracoes&action=store';
                    ?>
                    
                    <form action="<?php echo $actionUrl; ?>" method="POST">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome da Categoria <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nome" name="nome" value="<?php echo isset($categoria['nome']) ? htmlspecialchars($categoria['nome']) : ''; ?>" placeholder="Ex: Velocidade, Poluição, Segurança..." required>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="<?php echo BASE_URL; ?>index.php?controller=categorias_infracoes&action=index" class="btn btn-secondary px-4">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
