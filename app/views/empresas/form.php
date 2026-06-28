<div class="container-fluid px-4 py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h4 class="mb-0"><?php echo isset($isEdit) && $isEdit ? 'Editar Empresa' : 'Nova Empresa'; ?></h4>
                </div>
                <div class="card-body p-4">
                    
                    <?php 
                        $actionUrl = isset($isEdit) && $isEdit 
                            ? BASE_URL . 'index.php?controller=empresas&action=update&id=' . $empresa['id'] 
                            : BASE_URL . 'index.php?controller=empresas&action=store';
                    ?>
                    
                    <form action="<?php echo $actionUrl; ?>" method="POST">
                        <div class="row g-3">
                            <div class="col-md-7">
                                <label for="nome" class="form-label">Nome da empresa <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nome" name="nome" value="<?php echo isset($empresa['nome']) ? htmlspecialchars($empresa['nome']) : ''; ?>" required>
                            </div>
                            
                            <div class="col-md-5">
                                <label for="cnpj" class="form-label">CNPJ</label>
                                <input type="text" class="form-control" id="cnpj" name="cnpj" value="<?php echo isset($empresa['cnpj']) ? htmlspecialchars($empresa['cnpj']) : ''; ?>" placeholder="00.000.000/0000-00" oninput="maskCNPJ(this)">
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="<?php echo BASE_URL; ?>index.php?controller=empresas&action=index" class="btn btn-secondary">
                                Voltar
                            </a>
                            <button type="submit" class="btn btn-primary">
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
function maskCNPJ(input) {
    let v = input.value.replace(/\D/g, ''); // Remove everything that is not a digit
    
    if (v.length > 14) {
        v = v.substring(0, 14); // Limit to 14 digits
    }

    if (v.length > 12) {
        v = v.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{1,2}).*/, '$1.$2.$3/$4-$5');
    } else if (v.length > 8) {
        v = v.replace(/^(\d{2})(\d{3})(\d{3})(\d{1,4}).*/, '$1.$2.$3/$4');
    } else if (v.length > 5) {
        v = v.replace(/^(\d{2})(\d{3})(\d{1,3}).*/, '$1.$2.$3');
    } else if (v.length > 2) {
        v = v.replace(/^(\d{2})(\d{1,3}).*/, '$1.$2');
    }

    input.value = v;
}
</script>
