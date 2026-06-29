<div class="container-fluid px-4 py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h4 class="mb-4"><?php echo isset($isEdit) && $isEdit ? 'Editar Motivo de Infração' : 'Novo Motivo de Infração'; ?></h4>
                    
                    <?php 
                        $actionUrl = isset($isEdit) && $isEdit 
                            ? BASE_URL . 'index.php?controller=motivos_infracoes&action=update&id=' . $motivo['id'] 
                            : BASE_URL . 'index.php?controller=motivos_infracoes&action=store';
                    ?>
                    
                    <form action="<?php echo $actionUrl; ?>" method="POST">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="codigo" class="form-label">Código (Ex: 7455) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="codigo" name="codigo" value="<?php echo isset($motivo['codigo']) ? htmlspecialchars($motivo['codigo']) : ''; ?>" required>
                                <div id="codigoFeedback" class="invalid-feedback">
                                    Este código já está em uso!
                                </div>
                            </div>
                            <div class="col-md-9">
                                <label for="descricao" class="form-label">Descrição <span class="text-danger">*</span></label>
                                <input type="text" class="form-control text-uppercase" id="descricao" name="descricao" value="<?php echo isset($motivo['descricao']) ? htmlspecialchars($motivo['descricao']) : ''; ?>" required oninput="this.value = this.value.toUpperCase()">
                            </div>
                            
                            <div class="col-md-4">
                                <label for="categoria_id" class="form-label">Categoria</label>
                                <select class="form-select" id="categoria_id" name="categoria_id">
                                    <option value="">Selecione...</option>
                                    <?php 
                                        $selectedCategoria = isset($motivo['categoria_id']) ? $motivo['categoria_id'] : '';
                                        foreach ($categorias as $cat): 
                                    ?>
                                        <option value="<?php echo htmlspecialchars($cat['id']); ?>" <?php echo $selectedCategoria == $cat['id'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($cat['nome']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="gravidade" class="form-label">Gravidade</label>
                                <select class="form-select" id="gravidade" name="gravidade" onchange="autoFillValorBase()">
                                    <option value="">Selecione...</option>
                                    <option value="LEVE" <?php echo (isset($motivo['gravidade']) && $motivo['gravidade'] === 'LEVE') ? 'selected' : ''; ?>>LEVE</option>
                                    <option value="MÉDIA" <?php echo (isset($motivo['gravidade']) && $motivo['gravidade'] === 'MÉDIA') ? 'selected' : ''; ?>>MÉDIA</option>
                                    <option value="GRAVE" <?php echo (isset($motivo['gravidade']) && $motivo['gravidade'] === 'GRAVE') ? 'selected' : ''; ?>>GRAVE</option>
                                    <option value="GRAVÍSSIMA" <?php echo (isset($motivo['gravidade']) && $motivo['gravidade'] === 'GRAVÍSSIMA') ? 'selected' : ''; ?>>GRAVÍSSIMA</option>
                                    <option value="SEM PONTUAÇÃO" <?php echo (isset($motivo['gravidade']) && $motivo['gravidade'] === 'SEM PONTUAÇÃO') ? 'selected' : ''; ?>>SEM PONTUAÇÃO</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="pontos" class="form-label">Pontuação na CNH</label>
                                <select class="form-select" id="pontos" name="pontos">
                                    <option value="0" <?php echo (isset($motivo['pontos']) && $motivo['pontos'] == 0) ? 'selected' : ''; ?>>0</option>
                                    <option value="3" <?php echo (isset($motivo['pontos']) && $motivo['pontos'] == 3) ? 'selected' : ''; ?>>3</option>
                                    <option value="4" <?php echo (isset($motivo['pontos']) && $motivo['pontos'] == 4) ? 'selected' : ''; ?>>4</option>
                                    <option value="5" <?php echo (isset($motivo['pontos']) && $motivo['pontos'] == 5) ? 'selected' : ''; ?>>5</option>
                                    <option value="7" <?php echo (isset($motivo['pontos']) && $motivo['pontos'] == 7) ? 'selected' : ''; ?>>7</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="valor_base" class="form-label">Valor Base (R$)</label>
                                <input type="text" class="form-control money" id="valor_base" name="valor_base" value="<?php echo isset($motivo['valor_base']) ? number_format($motivo['valor_base'], 2, ',', '.') : ''; ?>" oninput="calculateTotal()">
                            </div>
                            <div class="col-md-4">
                                <label for="fator_multiplicacao" class="form-label">Fator Multiplicação</label>
                                <select class="form-select" id="fator_multiplicacao" name="fator_multiplicacao" onchange="calculateTotal()">
                                    <?php 
                                        $fator = isset($motivo['fator_multiplicacao']) ? floatval($motivo['fator_multiplicacao']) : 1;
                                        $opcoes = [1, 2, 3, 5, 10, 20, 40, 60];
                                        foreach ($opcoes as $op):
                                    ?>
                                        <option value="<?php echo $op; ?>" <?php echo ($fator == $op) ? 'selected' : ''; ?>><?php echo $op; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="valor_multa" class="form-label">Valor Total (R$)</label>
                                <input type="text" class="form-control money text-danger fw-bold" id="valor_multa" name="valor_multa" value="<?php echo isset($motivo['valor_multa']) ? number_format($motivo['valor_multa'], 2, ',', '.') : ''; ?>">
                            </div>

                            <div class="col-md-12">
                                <div class="form-check form-switch form-switch-danger mt-2">
                                    <input class="form-check-input" type="checkbox" role="switch" id="gera_suspensao_cnh" name="gera_suspensao_cnh" value="1" <?php echo (!empty($motivo['gera_suspensao_cnh'])) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="gera_suspensao_cnh">Esta infração é passível de penalidade de suspensão do direito de dirigir?</label>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label for="observacao" class="form-label">Observações</label>
                                <textarea class="form-control" id="observacao" name="observacao" rows="2"><?php echo isset($motivo['observacao']) ? htmlspecialchars($motivo['observacao']) : ''; ?></textarea>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="<?php echo BASE_URL; ?>index.php?controller=motivos_infracoes&action=index" class="btn btn-secondary px-4">
                                Cancelar
                            </a>
                            <button type="submit" id="submitBtn" class="btn btn-primary px-4">
                                Salvar
                            </button>
                        </div>
                    </form>
                    
                    <script>
                        // Valores base por gravidade atualizados (2024)
                        const valoresGravidade = {
                            'LEVE': 88.38,
                            'MÉDIA': 130.16,
                            'GRAVE': 195.23,
                            'GRAVÍSSIMA': 293.47,
                            'SEM PONTUAÇÃO': 0.00
                        };

                        const pontosGravidade = {
                            'LEVE': '3',
                            'MÉDIA': '4',
                            'GRAVE': '5',
                            'GRAVÍSSIMA': '7',
                            'SEM PONTUAÇÃO': '0'
                        };

                        function parseMoney(val) {
                            if (!val) return 0;
                            return parseFloat(val.replace(/\./g, '').replace(',', '.'));
                        }

                        function formatMoney(val) {
                            return val.toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                        }

                        function autoFillValorBase() {
                            const gravidade = document.getElementById('gravidade').value;
                            if (valoresGravidade[gravidade] !== undefined) {
                                document.getElementById('valor_base').value = formatMoney(valoresGravidade[gravidade]);
                                
                                // Auto-fill pontos based on gravidade too (but user can override)
                                const selectPontos = document.getElementById('pontos');
                                if (selectPontos.tomselect) {
                                    selectPontos.tomselect.setValue(pontosGravidade[gravidade]);
                                } else {
                                    selectPontos.value = pontosGravidade[gravidade];
                                }
                                
                                calculateTotal();
                            }
                        }

                        function calculateTotal() {
                            const valorBaseStr = document.getElementById('valor_base').value;
                            const fator = parseFloat(document.getElementById('fator_multiplicacao').value) || 1;
                            
                            const valorBase = parseMoney(valorBaseStr);
                            const total = valorBase * fator;
                            
                            document.getElementById('valor_multa').value = formatMoney(total);
                        }

                        // Validação em tempo real do Código
                        let debounceTimer;
                        const codigoInput = document.getElementById('codigo');
                        const submitBtn = document.getElementById('submitBtn');
                        const ignoreId = <?php echo isset($motivo['id']) ? $motivo['id'] : 0; ?>;

                        codigoInput.addEventListener('input', function() {
                            clearTimeout(debounceTimer);
                            const codigoVal = this.value.trim();
                            
                            if (codigoVal.length === 0) {
                                codigoInput.classList.remove('is-invalid');
                                submitBtn.disabled = false;
                                return;
                            }

                            debounceTimer = setTimeout(() => {
                                fetch('<?php echo BASE_URL; ?>index.php?controller=motivos_infracoes&action=check_codigo&codigo=' + encodeURIComponent(codigoVal) + '&ignore_id=' + ignoreId)
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.exists) {
                                            codigoInput.classList.add('is-invalid');
                                            submitBtn.disabled = true;
                                        } else {
                                            codigoInput.classList.remove('is-invalid');
                                            submitBtn.disabled = false;
                                        }
                                    })
                                    .catch(err => console.error('Erro ao verificar código:', err));
                            }, 500); // Aguarda 500ms após parar de digitar
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
