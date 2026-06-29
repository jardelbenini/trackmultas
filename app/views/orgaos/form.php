<div class="container-fluid px-4 py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h4 class="mb-4"><?php echo isset($isEdit) && $isEdit ? 'Editar Órgão' : 'Novo Órgão'; ?></h4>
                    
                    <?php 
                        $actionUrl = isset($isEdit) && $isEdit 
                            ? BASE_URL . 'index.php?controller=orgaos&action=update&id=' . $orgao['id'] 
                            : BASE_URL . 'index.php?controller=orgaos&action=store';
                    ?>
                    
                    <form action="<?php echo $actionUrl; ?>" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="codigo" class="form-label">Código <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="codigo" name="codigo" value="<?php echo isset($orgao['codigo']) ? htmlspecialchars($orgao['codigo']) : ''; ?>" required>
                                <div class="invalid-feedback" id="codigo-feedback">Já existe um órgão com este código.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="sigla" class="form-label">Sigla</label>
                                <input type="text" class="form-control" id="sigla" name="sigla" value="<?php echo isset($orgao['sigla']) ? htmlspecialchars($orgao['sigla']) : ''; ?>">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome do Órgão <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nome" name="nome" value="<?php echo isset($orgao['nome']) ? htmlspecialchars($orgao['nome']) : ''; ?>" required>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="<?php echo BASE_URL; ?>index.php?controller=orgaos&action=index" class="btn btn-secondary px-4">
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const codigoInput = document.getElementById('codigo');
    const saveBtn = document.querySelector('button[type="submit"]');
    const currentId = '<?php echo isset($orgao['id']) ? $orgao['id'] : ''; ?>';
    
    if(codigoInput) {
        codigoInput.addEventListener('blur', function() {
            const codigo = this.value.trim();
            if(!codigo) {
                this.classList.remove('is-invalid');
                saveBtn.disabled = false;
                return;
            }
            
            let url = '<?php echo BASE_URL; ?>index.php?controller=orgaos&action=check_codigo&codigo=' + encodeURIComponent(codigo);
            if(currentId) {
                url += '&id=' + encodeURIComponent(currentId);
            }
            
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if(data.exists) {
                        codigoInput.classList.add('is-invalid');
                        saveBtn.disabled = true;
                    } else {
                        codigoInput.classList.remove('is-invalid');
                        saveBtn.disabled = false;
                    }
                })
                .catch(err => console.error('Erro ao checar código:', err));
        });
    }
});
</script>
