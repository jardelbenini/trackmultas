<div class="container-fluid px-4 py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h4 class="mb-0"><?php echo isset($isEdit) && $isEdit ? 'Editar Motorista' : 'Novo Motorista'; ?></h4>
                </div>
                <div class="card-body p-4">
                    
                    <?php 
                        $actionUrl = isset($isEdit) && $isEdit 
                            ? BASE_URL . 'index.php?controller=motoristas&action=update&id=' . $motorista['id'] 
                            : BASE_URL . 'index.php?controller=motoristas&action=store';
                    ?>
                    
                    <form action="<?php echo $actionUrl; ?>" method="POST">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="empresa_id" class="form-label">Empresa <span class="text-danger">*</span></label>
                                <select class="form-select" id="empresa_id" name="empresa_id" required>
                                    <option value="">Selecione...</option>
                                    <?php foreach ($empresas as $emp): ?>
                                        <option value="<?php echo $emp['id']; ?>" <?php echo (isset($motorista['empresa_id']) && $motorista['empresa_id'] == $emp['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($emp['nome']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="matricula" class="form-label">Matrícula</label>
                                <input type="text" class="form-control" id="matricula" name="matricula" value="<?php echo isset($motorista['matricula']) ? htmlspecialchars($motorista['matricula']) : ''; ?>">
                            </div>
                            
                            <div class="col-md-6">
                                <label for="nome" class="form-label">Nome <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nome" name="nome" value="<?php echo isset($motorista['nome']) ? htmlspecialchars($motorista['nome']) : ''; ?>" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="cpf" class="form-label">CPF</label>
                                <input type="text" class="form-control" id="cpf" name="cpf" value="<?php echo isset($motorista['cpf']) ? htmlspecialchars($motorista['cpf']) : ''; ?>" placeholder="000.000.000-00" oninput="maskCPF(this)">
                            </div>
                            
                            <div class="col-md-4">
                                <label for="setor_id" class="form-label">Setor <span class="text-danger">*</span></label>
                                <select class="form-select" id="setor_id" name="setor_id" required>
                                    <option value="">Selecione...</option>
                                    <?php foreach ($setores as $setor): ?>
                                        <option value="<?php echo $setor['id']; ?>" <?php echo (isset($motorista['setor_id']) && $motorista['setor_id'] == $setor['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($setor['nome']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="col-md-4">
                                <label for="status_id" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select" id="status_id" name="status_id" required>
                                    <option value="">Selecione...</option>
                                    <?php foreach ($statusList as $status): ?>
                                        <option value="<?php echo $status['id']; ?>" <?php echo (isset($motorista['status_id']) && $motorista['status_id'] == $status['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($status['nome']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="col-md-4">
                                <label for="data_admissao" class="form-label">Data de admissão</label>
                                <input type="date" class="form-control" id="data_admissao" name="data_admissao" value="<?php echo isset($motorista['data_admissao']) ? $motorista['data_admissao'] : ''; ?>">
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="<?php echo BASE_URL; ?>index.php?controller=motoristas&action=index" class="btn btn-secondary">
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
function maskCPF(input) {
    let v = input.value.replace(/\D/g, '');
    
    if (v.length > 11) {
        v = v.substring(0, 11);
    }

    if (v.length > 9) {
        v = v.replace(/^(\d{3})(\d{3})(\d{3})(\d{1,2}).*/, '$1.$2.$3-$4');
    } else if (v.length > 6) {
        v = v.replace(/^(\d{3})(\d{3})(\d{1,3}).*/, '$1.$2.$3');
    } else if (v.length > 3) {
        v = v.replace(/^(\d{3})(\d{1,3}).*/, '$1.$2');
    }

    input.value = v;
}
</script>
