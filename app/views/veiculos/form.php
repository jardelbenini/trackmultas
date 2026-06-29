<div class="container-fluid px-4 py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h4 class="mb-0"><?php echo isset($isEdit) && $isEdit ? 'Editar Veículo' : 'Novo Veículo'; ?></h4>
                </div>
                <div class="card-body p-4">
                    
                    <?php 
                        $actionUrl = isset($isEdit) && $isEdit 
                            ? BASE_URL . 'index.php?controller=veiculos&action=update&id=' . $veiculo['id'] 
                            : BASE_URL . 'index.php?controller=veiculos&action=store';
                    ?>
                    
                    <form action="<?php echo $actionUrl; ?>" method="POST">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="placa" class="form-label">Placa <span class="text-danger">*</span></label>
                                <input type="text" class="form-control text-uppercase" id="placa" name="placa" value="<?php echo isset($veiculo['placa']) ? htmlspecialchars($veiculo['placa']) : ''; ?>" placeholder="ABC-1234" required oninput="maskPlaca(this)">
                                <div class="invalid-feedback" id="placa-feedback">Esta placa já está cadastrada.</div>
                            </div>
                            
                            <div class="col-md-4">
                                <label for="renavam" class="form-label">Renavam <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="renavam" name="renavam" value="<?php echo isset($veiculo['renavam']) ? htmlspecialchars($veiculo['renavam']) : ''; ?>" placeholder="Apenas números" required oninput="maskRenavam(this)" onblur="validateRenavamOnBlur(this)">
                                <div class="invalid-feedback" id="renavam-feedback">
                                    O Renavam deve conter exatamente 11 números.
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <label for="tipo_veiculo_id" class="form-label">Tipo de Veículo <span class="text-danger">*</span></label>
                                <select class="form-select" id="tipo_veiculo_id" name="tipo_veiculo_id" required>
                                    <option value="">Selecione...</option>
                                    <?php foreach ($tipos as $tipo): ?>
                                        <option value="<?php echo $tipo['id']; ?>" <?php echo (isset($veiculo['tipo_veiculo_id']) && $veiculo['tipo_veiculo_id'] == $tipo['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($tipo['nome']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="col-md-4">
                                <label for="marca" class="form-label">Marca</label>
                                <input type="text" class="form-control" id="marca" name="marca" value="<?php echo isset($veiculo['marca']) ? htmlspecialchars($veiculo['marca']) : ''; ?>">
                            </div>
                            
                            <div class="col-md-4">
                                <label for="modelo" class="form-label">Modelo</label>
                                <input type="text" class="form-control" id="modelo" name="modelo" value="<?php echo isset($veiculo['modelo']) ? htmlspecialchars($veiculo['modelo']) : ''; ?>">
                            </div>
                            
                            <div class="col-md-4">
                                <label for="ano_fabricacao" class="form-label">Ano de Fabricação</label>
                                <select class="form-select" id="ano_fabricacao" name="ano_fabricacao">
                                    <option value="">Selecione...</option>
                                    <?php 
                                        $anoAtual = date('Y');
                                        $anoSelecionado = isset($veiculo['ano_fabricacao']) ? $veiculo['ano_fabricacao'] : '';
                                        for ($ano = $anoAtual; $ano >= 1970; $ano--) {
                                            $selected = ($anoSelecionado == $ano) ? 'selected' : '';
                                            echo "<option value=\"$ano\" $selected>$ano</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="<?php echo BASE_URL; ?>index.php?controller=veiculos&action=index" class="btn btn-secondary">
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
function maskPlaca(input) {
    let v = input.value.toUpperCase();
    
    let letters = v.substring(0, 3).replace(/[^A-Z]/g, '');
    let numbers = v.substring(3).replace(/[^A-Z0-9]/g, '');
    
    v = letters + numbers;
    
    if (v.length > 7) {
        v = v.substring(0, 7);
    }
    
    if (v.length > 3) {
        v = v.replace(/^([A-Z]{3})([A-Z0-9]+)$/, '$1-$2');
    }

    input.value = v;
}

function maskRenavam(input) {
    let v = input.value.replace(/\D/g, ''); // Remove tudo que não é número
    
    if (v.length > 11) {
        v = v.substring(0, 11);
    }
    
    input.value = v;
    
    // Se o usuário voltar a digitar, remove o aviso de erro
    input.classList.remove('is-invalid');
}

function validateRenavamOnBlur(input) {
    if (input.value.length > 0 && input.value.length < 11) {
        input.classList.add('is-invalid');
        const feedback = document.getElementById('renavam-feedback');
        if (feedback) feedback.innerText = 'O Renavam deve conter exatamente 11 números.';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const placaInput = document.getElementById('placa');
    const renavamInput = document.getElementById('renavam');
    const saveBtn = document.querySelector('button[type="submit"]');
    const currentId = '<?php echo isset($veiculo['id']) ? $veiculo['id'] : ''; ?>';
    
    // Objeto para rastrear estado de erro dos campos
    const errors = { placa: false, renavam: false };
    
    function updateSaveBtn() {
        saveBtn.disabled = errors.placa || errors.renavam;
    }

    if(placaInput) {
        placaInput.addEventListener('blur', function() {
            const placa = this.value.trim();
            if(placa.length < 8) { // ABC-1234 or ABC1D23 (7 chars + 1 hyphen)
                this.classList.remove('is-invalid');
                errors.placa = false;
                updateSaveBtn();
                return;
            }
            
            let url = '<?php echo BASE_URL; ?>index.php?controller=veiculos&action=check_placa&placa=' + encodeURIComponent(placa);
            if(currentId) {
                url += '&id=' + encodeURIComponent(currentId);
            }
            
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if(data.exists) {
                        placaInput.classList.add('is-invalid');
                        errors.placa = true;
                    } else {
                        placaInput.classList.remove('is-invalid');
                        errors.placa = false;
                    }
                    updateSaveBtn();
                })
                .catch(err => console.error('Erro:', err));
        });
    }
    
    if(renavamInput) {
        renavamInput.addEventListener('blur', function() {
            const renavam = this.value.trim();
            if(renavam.length < 11) {
                // The validateRenavamOnBlur already adds is-invalid for length < 11
                errors.renavam = true;
                updateSaveBtn();
                return;
            }
            
            let url = '<?php echo BASE_URL; ?>index.php?controller=veiculos&action=check_renavam&renavam=' + encodeURIComponent(renavam);
            if(currentId) {
                url += '&id=' + encodeURIComponent(currentId);
            }
            
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const feedback = renavamInput.nextElementSibling;
                    if(data.exists) {
                        renavamInput.classList.add('is-invalid');
                        if (feedback) feedback.innerText = 'Este Renavam já está cadastrado.';
                        errors.renavam = true;
                    } else {
                        renavamInput.classList.remove('is-invalid');
                        if (feedback) feedback.innerText = 'O Renavam deve conter exatamente 11 números.';
                        errors.renavam = false;
                    }
                    updateSaveBtn();
                })
                .catch(err => console.error('Erro:', err));
        });
    }
});
</script>
