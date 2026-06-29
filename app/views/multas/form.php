<div class="container-fluid px-4 py-4">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h4 class="mb-0"><?php echo isset($isEdit) && $isEdit ? 'Editar Multa' : 'Nova Multa'; ?></h4>
                </div>
                <div class="card-body p-4">
                    
                    <?php 
                        $actionUrl = isset($isEdit) && $isEdit 
                            ? BASE_URL . 'index.php?controller=multas&action=update&id=' . $multa['id'] 
                            : BASE_URL . 'index.php?controller=multas&action=store';
                    ?>
                    
                    <form action="<?php echo $actionUrl; ?>" method="POST">
                        <h5 class="border-bottom pb-2 mb-3 text-primary">Informações da Infração</h5>
                        <div class="row g-3 mb-4">
                            <div class="col-md-3">
                                <label for="auto_infracao" class="form-label">Auto de Infração <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="auto_infracao" name="auto_infracao" value="<?php echo isset($multa['auto_infracao']) ? htmlspecialchars($multa['auto_infracao']) : ''; ?>" required>
                            </div>
                            <div class="col-md-3">
                                <label for="data_infracao" class="form-label">Data da Infração <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="data_infracao" name="data_infracao" value="<?php echo isset($multa['data_infracao']) ? $multa['data_infracao'] : ''; ?>" required>
                            </div>
                            <div class="col-md-2">
                                <label for="hora_infracao" class="form-label">Hora da Infração <span class="text-danger">*</span></label>
                                <input type="time" class="form-control" id="hora_infracao" name="hora_infracao" value="<?php echo isset($multa['hora_infracao']) ? $multa['hora_infracao'] : ''; ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label for="orgao_id" class="form-label">Órgão <span class="text-danger">*</span></label>
                                <select class="form-select" id="orgao_id" name="orgao_id" required>
                                    <option value="">Selecione...</option>
                                    <?php foreach ($orgaos as $orgao): ?>
                                        <option value="<?php echo $orgao['id']; ?>" <?php echo (isset($multa['orgao_id']) && $multa['orgao_id'] == $orgao['id']) ? 'selected' : ''; ?>>
                                            <?php 
                                            $codigoText = !empty($orgao['codigo']) ? $orgao['codigo'] . ' - ' : '';
                                            $siglaText = !empty($orgao['sigla']) ? ' (' . $orgao['sigla'] . ')' : '';
                                            echo htmlspecialchars($codigoText . $orgao['nome'] . $siglaText); 
                                            ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="col-md-4">
                                <label for="local_multa" class="form-label">Local da Multa <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="local_multa" name="local_multa" value="<?php echo isset($multa['local_multa']) ? htmlspecialchars($multa['local_multa']) : ''; ?>" required oninput="this.value = this.value.toUpperCase()">
                            </div>
                            <div class="col-md-4">
                                <label for="estado" class="form-label">Estado <span class="text-danger">*</span></label>
                                <select class="form-select ts-select" id="estado" name="estado" required data-selected="<?php echo isset($multa['estado']) ? htmlspecialchars($multa['estado']) : ''; ?>">
                                    <option value="">Carregando estados...</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="cidade" class="form-label">Cidade <span class="text-danger">*</span></label>
                                <select class="form-select ts-select" id="cidade" name="cidade" required data-selected="<?php echo isset($multa['cidade']) ? htmlspecialchars($multa['cidade']) : ''; ?>" disabled>
                                    <option value="">Selecione o estado primeiro</option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label for="motivo_infracao_id" class="form-label">Motivo da Infração <span class="text-danger">*</span></label>
                                <select class="form-select ts-select" id="motivo_infracao_id" name="motivo_infracao_id" required placeholder="Escolher...">
                                    <option value="" <?php echo empty($multa['motivo_infracao_id']) ? 'selected' : ''; ?>>Escolher...</option>
                                    <?php foreach ($motivos as $motivo): ?>
                                        <option value="<?php echo $motivo['id']; ?>" <?php echo (isset($multa['motivo_infracao_id']) && $multa['motivo_infracao_id'] == $motivo['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($motivo['codigo'] . ' - ' . $motivo['descricao'] . ' (' . $motivo['pontos'] . ' pts)'); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <!-- Campos preenchidos automaticamente pelo Motivo -->
                            <div class="col-md-2" id="box_motivo_codigo">
                                <label class="form-label text-muted">Código CTB</label>
                                <input type="text" class="form-control bg-light text-muted" id="motivo_codigo_display" readonly>
                            </div>
                            <div class="col-md-8" id="box_motivo_descricao">
                                <label class="form-label text-muted">Descrição Resumida</label>
                                <input type="text" class="form-control bg-light text-muted" id="motivo_descricao_display" readonly>
                            </div>
                            <div class="col-md-2" id="box_motivo_pontos">
                                <label class="form-label text-muted">Pontos</label>
                                <input type="text" class="form-control bg-light text-muted" id="motivo_pontos_display" readonly>
                            </div>
                        </div>

                        <h5 class="border-bottom pb-2 mb-3 text-primary">Envolvidos</h5>
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label for="motorista_id" class="form-label">Motorista <span class="text-danger">*</span></label>
                                <select class="form-select" id="motorista_id" name="motorista_id" required>
                                    <option value="">Selecione...</option>
                                    <?php foreach ($motoristas as $motorista): ?>
                                        <option value="<?php echo $motorista['id']; ?>" data-empresa-id="<?php echo $motorista['empresa_id']; ?>" <?php echo (isset($multa['motorista_id']) && $multa['motorista_id'] == $motorista['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($motorista['nome'] . (!empty($motorista['matricula']) ? ' (Matrícula: ' . $motorista['matricula'] . ')' : '')); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="empresa_id" class="form-label">Empresa <span class="text-danger">*</span></label>
                                <select class="form-select" id="empresa_id" name="empresa_id" required>
                                    <option value="">Selecione...</option>
                                    <?php foreach ($empresas as $empresa): ?>
                                        <option value="<?php echo $empresa['id']; ?>" <?php echo (isset($multa['empresa_id']) && $multa['empresa_id'] == $empresa['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($empresa['nome']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="veiculo_id" class="form-label">Veículo / Placa <span class="text-danger">*</span></label>
                                <select class="form-select" id="veiculo_id" name="veiculo_id" required>
                                    <option value="">Selecione...</option>
                                    <?php foreach ($veiculos as $veiculo): ?>
                                        <option value="<?php echo $veiculo['id']; ?>" <?php echo (isset($multa['veiculo_id']) && $multa['veiculo_id'] == $veiculo['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($veiculo['placa'] . ' - ' . $veiculo['marca'] . ' ' . $veiculo['modelo']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <h5 class="border-bottom pb-2 mb-3 text-primary">Responsabilidade e Andamento</h5>
                        <div class="row g-3 mb-4">
                            <div class="col-md-3">
                                <label for="responsabilidade_id" class="form-label">Responsabilidade <span class="text-danger">*</span></label>
                                <select class="form-select" id="responsabilidade_id" name="responsabilidade_id" required>
                                    <option value="">Selecione...</option>
                                    <?php foreach ($responsabilidades as $resp): ?>
                                        <option value="<?php echo $resp['id']; ?>" <?php echo (isset($multa['responsabilidade_id']) && $multa['responsabilidade_id'] == $resp['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($resp['nome']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="status_motorista_id" class="form-label">Status do Motorista <span class="text-danger">*</span></label>
                                <select class="form-select" id="status_motorista_id" name="status_motorista_id" required>
                                    <option value="">Selecione...</option>
                                    <?php foreach ($statusMotoristas as $sm): ?>
                                        <option value="<?php echo $sm['id']; ?>" <?php echo (isset($multa['status_motorista_id']) && $multa['status_motorista_id'] == $sm['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($sm['nome']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="status_andamento_id" class="form-label">Status / Andamento <span class="text-danger">*</span></label>
                                <select class="form-select" id="status_andamento_id" name="status_andamento_id" required>
                                    <option value="">Selecione...</option>
                                    <?php foreach ($statusAndamentos as $sa): ?>
                                        <option value="<?php echo $sa['id']; ?>" <?php echo (isset($multa['status_andamento_id']) && $multa['status_andamento_id'] == $sa['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($sa['nome']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="prazo_indicar_condutor" class="form-label">Prazo para Defesa / Indicação do Condutor</label>
                                <input type="date" class="form-control" id="prazo_indicar_condutor" name="prazo_indicar_condutor" value="<?php echo isset($multa['prazo_indicar_condutor']) ? $multa['prazo_indicar_condutor'] : ''; ?>">
                            </div>
                        </div>

                        <h5 class="border-bottom pb-2 mb-3 text-primary">Financeiro e Pagamento</h5>
                        <div class="row g-3 mb-4">
                            <div class="col-md-3">
                                <label for="valor_real" class="form-label">Valor Real (R$)</label>
                                <input type="text" class="form-control mask-money" id="valor_real" name="valor_real" value="<?php echo (isset($multa['valor_real']) && $multa['valor_real'] > 0) ? number_format($multa['valor_real'], 2, ',', '.') : ''; ?>">
                            </div>
                            <div class="col-md-3">
                                <label for="status_pagamento_id" class="form-label">Status de Pagamento <span class="text-danger">*</span></label>
                                <select class="form-select" id="status_pagamento_id" name="status_pagamento_id" required>
                                    <option value="">Selecione...</option>
                                    <?php foreach ($statusPagamentos as $sp): ?>
                                        <option value="<?php echo $sp['id']; ?>" <?php echo (isset($multa['status_pagamento_id']) && $multa['status_pagamento_id'] == $sp['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($sp['nome']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="data_vencimento" class="form-label">Data de Vencimento</label>
                                <input type="date" class="form-control" id="data_vencimento" name="data_vencimento" value="<?php echo isset($multa['data_vencimento']) ? $multa['data_vencimento'] : ''; ?>">
                            </div>
                            <div class="col-md-3">
                                <label for="data_pagamento" class="form-label">Data de Pagamento</label>
                                <input type="date" class="form-control" id="data_pagamento" name="data_pagamento" max="<?php echo date('Y-m-d'); ?>" value="<?php echo isset($multa['data_pagamento']) ? $multa['data_pagamento'] : ''; ?>">
                            </div>
                            
                            <div class="col-md-3" id="box_valor_acordado">
                                <label for="valor_acordado" class="form-label">Valor Combinado R$</label>
                                <input type="text" class="form-control mask-money" id="valor_acordado" name="valor_acordado" value="<?php echo (isset($multa['valor_acordado']) && $multa['valor_acordado'] > 0) ? number_format($multa['valor_acordado'], 2, ',', '.') : ''; ?>">
                            </div>
                            <div class="col-md-3">
                                <label for="data_acerto_motorista" class="form-label">Data do Combinado</label>
                                <input type="date" class="form-control" id="data_acerto_motorista" name="data_acerto_motorista" value="<?php echo isset($multa['data_acerto_motorista']) ? $multa['data_acerto_motorista'] : ''; ?>">
                            </div>
                            <div class="col-md-3">
                                <label for="motorista_pagou" class="form-label">Motorista pagou?</label>
                                <select class="form-select" id="motorista_pagou" name="motorista_pagou">
                                    <option value="0" <?php echo (isset($multa['motorista_pagou']) && $multa['motorista_pagou'] == 0) ? 'selected' : ''; ?>>Não</option>
                                    <option value="1" <?php echo (isset($multa['motorista_pagou']) && $multa['motorista_pagou'] == 1) ? 'selected' : ''; ?>>Sim</option>
                                </select>
                            </div>
                            <div class="col-md-3" id="box_qtd_parcelas" style="display: none;">
                                <label for="qtd_parcelas" class="form-label">Qtd. Parcelas</label>
                                <input type="number" class="form-control" id="qtd_parcelas" name="qtd_parcelas" min="0" max="48" value="<?php echo isset($parcelas) ? count($parcelas) : '0'; ?>">
                            </div>
                            <div class="col-md-3">
                                <label for="valor_pago_motorista" class="form-label">Valor Pago Motorista (R$)</label>
                                <input type="text" class="form-control mask-money bg-light" id="valor_pago_motorista" name="valor_pago_motorista" value="<?php echo (isset($multa['valor_pago_motorista']) && $multa['valor_pago_motorista'] > 0) ? number_format($multa['valor_pago_motorista'], 2, ',', '.') : ''; ?>" readonly tabindex="-1">
                            </div>
                            <div class="col-md-3">
                                <label for="valor_pago_empresa" class="form-label">Valor Pago Empresa (R$)</label>
                                <input type="text" class="form-control mask-money" id="valor_pago_empresa" name="valor_pago_empresa" value="<?php echo (isset($multa['valor_pago_empresa']) && $multa['valor_pago_empresa'] > 0) ? number_format($multa['valor_pago_empresa'], 2, ',', '.') : ''; ?>">
                            </div>

                            <div class="col-md-3">
                                <label for="desconto_pagamento" class="form-label">Desconto no Pagamento</label>
                                <select class="form-select" id="desconto_pagamento" name="desconto_pagamento">
                                    <option value="" <?php echo (empty($multa['desconto_pagamento'])) ? 'selected' : ''; ?>>Sem informação</option>
                                    <option value="20%" <?php echo (isset($multa['desconto_pagamento']) && $multa['desconto_pagamento'] == '20%') ? 'selected' : ''; ?>>Desconto de 20%</option>
                                    <option value="40%" <?php echo (isset($multa['desconto_pagamento']) && $multa['desconto_pagamento'] == '40%') ? 'selected' : ''; ?>>Desconto de 40%</option>
                                    <option value="Não conseguiu" <?php echo (isset($multa['desconto_pagamento']) && $multa['desconto_pagamento'] == 'Não conseguiu') ? 'selected' : ''; ?>>Não conseguiu o desconto</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="resultado_financeiro" class="form-label">Resultado (Lucro/Prejuízo)</label>
                                <input type="text" class="form-control fw-bold" id="resultado_financeiro" name="resultado_financeiro" value="" readonly tabindex="-1">
                            </div>
                        </div>

                        <!-- Container para as parcelas geradas dinamicamente -->
                        <div id="parcelas_container" class="row g-3 mb-4" style="display: none;">
                            <div class="col-12">
                                <h6 class="text-secondary mb-3 mt-2"><i class="bi bi-list-ol me-2"></i>Detalhamento das Parcelas</h6>
                                
                                <!-- Cabeçalho explicativo -->
                                <div class="row g-2 align-items-center mb-2 fw-bold text-muted d-none d-md-flex" style="font-size: 0.85em;">
                                    <div class="col-md-2 text-center">Nº da Parcela</div>
                                    <div class="col-md-3">Valor (R$)</div>
                                    <div class="col-md-3">Vencimento (Previsão)</div>
                                    <div class="col-md-3">Pagamento (Data que pagou)</div>
                                </div>
                                
                                <div id="alerta_soma_parcelas" class="alert alert-warning py-2 px-3 mb-3" style="display: none; font-size: 0.9em;">
                                    <strong>Atenção:</strong> A soma das parcelas (<span id="soma_atual_parcelas">R$ 0,00</span>) está diferente do Valor Combinado.
                                </div>

                                <div id="parcelas_list" class="d-flex flex-column gap-2">
                                    <?php if (isset($parcelas) && count($parcelas) > 0): ?>
                                        <?php foreach ($parcelas as $index => $p): ?>
                                            <div class="row g-2 align-items-center parcela-row">
                                                <div class="col-md-2">
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-light text-muted">Nº</span>
                                                        <input type="text" class="form-control bg-light text-center" name="parcela_numero[]" value="<?php echo $p['numero_parcela']; ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group">
                                                        <span class="input-group-text">R$</span>
                                                        <input type="text" class="form-control parcela-valor mask-money" name="parcela_valor[]" value="<?php echo number_format($p['valor'], 2, ',', '.'); ?>" placeholder="Valor">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="date" class="form-control" name="parcela_vencimento[]" value="<?php echo $p['data_vencimento']; ?>" title="Data Vencimento" placeholder="Vencimento">
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="date" class="form-control parcela-pagamento" name="parcela_pagamento[]" max="<?php echo date('Y-m-d'); ?>" value="<?php echo $p['data_pagamento']; ?>" title="Data Pagamento" placeholder="Pagamento">
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <h5 class="border-bottom pb-2 mb-3 text-primary">Observações</h5>
                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <label for="tratativa" class="form-label">Tratativa</label>
                                <textarea class="form-control" id="tratativa" name="tratativa" rows="3"><?php echo isset($multa['tratativa']) ? htmlspecialchars($multa['tratativa']) : ''; ?></textarea>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2 mt-4 border-top pt-4">
                            <a href="<?php echo BASE_URL; ?>index.php?controller=multas&action=index" class="btn btn-secondary px-4">
                                Voltar
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                Salvar Multa
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
    const estadoSelect = document.getElementById('estado');
    const cidadeSelect = document.getElementById('cidade');
    const estadoSalvo = estadoSelect.dataset.selected;
    const cidadeSalva = cidadeSelect.dataset.selected;
    
    // Instâncias do TomSelect serão criadas após o carregamento, mas o layout footer vai cuidar disso.
    // Primeiro populamos o estado.
    fetch('https://brasilapi.com.br/api/ibge/uf/v1')
        .then(response => response.json())
        .then(estados => {
            // Ordenar por sigla
            estados.sort((a, b) => a.sigla.localeCompare(b.sigla));
            
            estadoSelect.innerHTML = '<option value="">Selecione um estado...</option>';
            estados.forEach(estado => {
                const option = document.createElement('option');
                option.value = estado.sigla;
                option.textContent = estado.sigla + ' - ' + estado.nome;
                if (estadoSalvo === estado.sigla) {
                    option.selected = true;
                }
                estadoSelect.appendChild(option);
            });
            
            if (estadoSalvo) {
                carregarCidades(estadoSalvo, cidadeSalva);
            }
            
            // Avisar ao TomSelect que atualizamos, se ele já estiver iniciado
            if (estadoSelect.tomselect) {
                estadoSelect.tomselect.sync();
            }
        })
        .catch(error => {
            console.error('Erro ao carregar estados:', error);
            estadoSelect.innerHTML = '<option value="">Erro ao carregar</option>';
        });
        
    estadoSelect.addEventListener('change', function() {
        const uf = this.value;
        if (uf) {
            carregarCidades(uf, null);
        } else {
            cidadeSelect.innerHTML = '<option value="">Selecione o estado primeiro</option>';
            cidadeSelect.disabled = true;
            if (cidadeSelect.tomselect) {
                cidadeSelect.tomselect.sync();
                cidadeSelect.tomselect.disable();
            }
        }
    });
    
    function carregarCidades(uf, cidadePreSelecionada) {
        cidadeSelect.innerHTML = '<option value="">Carregando cidades...</option>';
        cidadeSelect.disabled = true;
        if (cidadeSelect.tomselect) {
            cidadeSelect.tomselect.sync();
            cidadeSelect.tomselect.disable();
        }
        
        fetch(`https://brasilapi.com.br/api/ibge/municipios/v1/${uf}`)
            .then(response => response.json())
            .then(cidades => {
                cidadeSelect.innerHTML = '<option value="">Selecione uma cidade...</option>';
                cidades.forEach(cidade => {
                    const option = document.createElement('option');
                    option.value = cidade.nome;
                    option.textContent = cidade.nome;
                    if (cidadePreSelecionada === cidade.nome) {
                        option.selected = true;
                    }
                    cidadeSelect.appendChild(option);
                });
                
                cidadeSelect.disabled = false;
                if (cidadeSelect.tomselect) {
                    cidadeSelect.tomselect.sync();
                    cidadeSelect.tomselect.enable();
                }
            })
            .catch(error => {
                console.error('Erro ao carregar cidades:', error);
                cidadeSelect.innerHTML = '<option value="">Erro ao carregar</option>';
            });
    }
    // Lógica para preencher dados do Motivo da Infração
    const motivoSelect = document.getElementById('motivo_infracao_id');
    const inputCodigo = document.getElementById('motivo_codigo_display');
    const inputDescricao = document.getElementById('motivo_descricao_display');
    const inputPontos = document.getElementById('motivo_pontos_display');
    const inputValorReal = document.getElementById('valor_real');

    function fetchMotivoDetails(motivoId, init = false) {
        if (!motivoId) {
            inputCodigo.value = '';
            inputDescricao.value = '';
            inputPontos.value = '';
            return;
        }

        fetch(`<?php echo BASE_URL; ?>index.php?controller=motivos_infracoes&action=get_details&id=${motivoId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    inputCodigo.value = data.codigo;
                    inputDescricao.value = data.descricao;
                    inputPontos.value = data.pontos;
                    
                    // Só atualiza o valor real automaticamente se não for o carregamento inicial (edição)
                    // ou se o valor real estiver vazio
                    if (!init || !inputValorReal.value) {
                        const valorFloat = parseFloat(data.valor_multa) || 0;
                        inputValorReal.value = formatMoneyValue(valorFloat);
                    }
                }
            })
            .catch(error => console.error('Erro ao buscar detalhes do motivo:', error));
    }

    // Ouvir evento de mudança (tanto do HTML puro quanto do TomSelect se aplicado)
    motivoSelect.addEventListener('change', function() {
        fetchMotivoDetails(this.value, false);
    });

    // Disparar no carregamento inicial se houver motivo selecionado (Edição)
    if (motivoSelect.value) {
        fetchMotivoDetails(motivoSelect.value, true);
    }
    // Lógica para Parcelamento
    const motoristaPagouSelect = document.getElementById('motorista_pagou');
    const boxValorAcordado = document.getElementById('box_valor_acordado');
    const inputValorAcordado = document.getElementById('valor_acordado');
    const boxQtdParcelas = document.getElementById('box_qtd_parcelas');
    const inputQtdParcelas = document.getElementById('qtd_parcelas');
    const parcelasContainer = document.getElementById('parcelas_container');
    const parcelasList = document.getElementById('parcelas_list');
    const inputValorPagoMotorista = document.getElementById('valor_pago_motorista');
    
    const alerta_soma_parcelas = document.getElementById('alerta_soma_parcelas');
    const span_soma_atual = document.getElementById('soma_atual_parcelas');

    function checkMotoristaPagou() {
        if (motoristaPagouSelect.value === '1') {
            boxQtdParcelas.style.display = 'block';
            inputQtdParcelas.min = '1';
            let currentQtd = parseInt(inputQtdParcelas.value) || 0;
            if (currentQtd < 1) {
                inputQtdParcelas.value = '1';
                inputQtdParcelas.dispatchEvent(new Event('input'));
            } else {
                parcelasContainer.style.display = 'flex';
            }
        } else {
            boxQtdParcelas.style.display = 'none';
            parcelasContainer.style.display = 'none';
            inputQtdParcelas.min = '0';
            inputQtdParcelas.value = '0';
            parcelasList.innerHTML = '';
            
            // Limpamos o valor se marcou como Não
            inputValorPagoMotorista.value = '';
            atualizarResultadoFinanceiro();
        }
    }

    motoristaPagouSelect.addEventListener('change', checkMotoristaPagou);

    function unmaskMoneyValue(val) {
        if (!val) return 0;
        return parseFloat(val.replace(/\./g, '').replace(',', '.'));
    }

    function formatMoneyValue(val) {
        if (isNaN(val)) return '';
        let str = Math.abs(val).toFixed(2).replace('.', ',');
        return str.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
    }

    const inputValorPagoEmpresa = document.getElementById('valor_pago_empresa');
    const inputResultadoFinanceiro = document.getElementById('resultado_financeiro');

    function atualizarResultadoFinanceiro() {
        let vMotorista = unmaskMoneyValue(inputValorPagoMotorista.value);
        let vEmpresa = unmaskMoneyValue(inputValorPagoEmpresa.value);
        let resultado = vMotorista - vEmpresa;

        if (resultado > 0) {
            inputResultadoFinanceiro.value = '+ R$ ' + formatMoneyValue(resultado);
            inputResultadoFinanceiro.className = 'form-control fw-bold text-success bg-success bg-opacity-10';
        } else if (resultado < 0) {
            inputResultadoFinanceiro.value = '- R$ ' + formatMoneyValue(Math.abs(resultado));
            inputResultadoFinanceiro.className = 'form-control fw-bold text-danger bg-danger bg-opacity-10';
        } else {
            inputResultadoFinanceiro.value = 'R$ 0,00';
            inputResultadoFinanceiro.className = 'form-control fw-bold text-secondary bg-light';
        }
    }

    function atualizarTotaisParcelas() {
        let totalPago = 0;
        let somaTotalParcelas = 0;
        
        const rows = document.querySelectorAll('.parcela-row');
        rows.forEach(row => {
            const valorInput = row.querySelector('.parcela-valor');
            const pagtoInput = row.querySelector('.parcela-pagamento');
            
            let v = unmaskMoneyValue(valorInput.value);
            somaTotalParcelas += v;
            
            if (pagtoInput.value && valorInput.value) {
                totalPago += v;
            }
        });
        
        if (rows.length > 0) {
            inputValorPagoMotorista.value = formatMoneyValue(totalPago);
            
            // Verifica o valor acordado
            let valorAcordado = unmaskMoneyValue(inputValorAcordado.value);
            if (Math.abs(somaTotalParcelas - valorAcordado) > 0.01 && valorAcordado > 0) {
                alerta_soma_parcelas.style.display = 'block';
                span_soma_atual.textContent = 'R$ ' + formatMoneyValue(somaTotalParcelas);
            } else {
                alerta_soma_parcelas.style.display = 'none';
            }
        }
        atualizarResultadoFinanceiro();
    }

    function recalcularDistribuicao() {
        const qtd = parseInt(inputQtdParcelas.value) || 0;
        const valorAcordado = unmaskMoneyValue(inputValorAcordado.value);
        
        if (qtd > 0 && valorAcordado > 0) {
            const valorBase = Math.floor((valorAcordado / qtd) * 100) / 100;
            const diferenca = valorAcordado - (valorBase * qtd);
            const valorUltima = valorBase + diferenca;
            
            const valorBaseStr = formatMoneyValue(valorBase);
            const valorUltimaStr = formatMoneyValue(valorUltima);
            
            const rows = document.querySelectorAll('.parcela-row');
            rows.forEach((row, index) => {
                const valorInput = row.querySelector('.parcela-valor');
                if (index === qtd - 1) {
                    valorInput.value = valorUltimaStr;
                } else {
                    valorInput.value = valorBaseStr;
                }
            });
            atualizarTotaisParcelas();
        }
    }

    // Se mudar o valor acordado, recalcula a distribuição
    inputValorAcordado.addEventListener('change', function() {
        recalcularDistribuicao();
        atualizarTotaisParcelas();
    });

    inputQtdParcelas.addEventListener('input', function() {
        const qtd = parseInt(this.value) || 0;
        if (qtd > 0) {
            parcelasContainer.style.display = 'flex';
            
            const rowsAtuais = document.querySelectorAll('.parcela-row');
            const dataAtuais = [];
            
            rowsAtuais.forEach(row => {
                dataAtuais.push({
                    vencimento: row.querySelector('input[name="parcela_vencimento[]"]').value,
                    pagamento: row.querySelector('.parcela-pagamento').value
                });
            });

            parcelasList.innerHTML = '';
            
            const todayISO = new Date().toISOString().split('T')[0];
            
            for (let i = 1; i <= qtd; i++) {
                const prev = dataAtuais[i-1] || {vencimento: '', pagamento: ''};
                
                const div = document.createElement('div');
                div.className = 'row g-2 align-items-center parcela-row';
                div.innerHTML = `
                    <div class="col-md-2">
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted">Nº</span>
                            <input type="text" class="form-control bg-light text-center" name="parcela_numero[]" value="${i}" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <span class="input-group-text">R$</span>
                            <input type="text" class="form-control parcela-valor mask-money" name="parcela_valor[]" value="" placeholder="Valor">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="date" class="form-control" name="parcela_vencimento[]" value="${prev.vencimento}" title="Data Vencimento" placeholder="Vencimento">
                    </div>
                    <div class="col-md-3">
                        <input type="date" class="form-control parcela-pagamento" name="parcela_pagamento[]" max="${todayISO}" value="${prev.pagamento}" title="Data Pagamento" placeholder="Pagamento">
                    </div>
                `;
                parcelasList.appendChild(div);
            }
            bindParcelaEvents();
            
            // Sempre que gerar novas linhas, força a redistribuição uniforme
            recalcularDistribuicao();
        } else {
            parcelasContainer.style.display = 'none';
            parcelasList.innerHTML = '';
        }
    });

    function bindParcelaEvents() {
        const inputs = document.querySelectorAll('.parcela-valor, .parcela-pagamento');
        inputs.forEach(input => {
            input.addEventListener('change', atualizarTotaisParcelas);
            if (!input.classList.contains('mask-money')) {
                input.addEventListener('input', atualizarTotaisParcelas);
            }
        });
    }

    function applyMaskCurrency() {
        document.addEventListener('input', function(e) {
            if (e.target && e.target.classList.contains('mask-money')) {
                let value = e.target.value.replace(/\D/g, "");
                if (!value) {
                    e.target.value = '';
                } else {
                    value = (parseInt(value, 10) / 100).toFixed(2) + '';
                    value = value.replace(".", ",");
                    value = value.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
                    e.target.value = value;
                }
                
                // Se a função existir, atualiza os totais após a máscara aplicar
                if (typeof atualizarTotaisParcelas === 'function') {
                    atualizarTotaisParcelas();
                }
                if (typeof atualizarResultadoFinanceiro === 'function') {
                    atualizarResultadoFinanceiro();
                }
            }
        });
    }

    inputValorPagoEmpresa.addEventListener('input', atualizarResultadoFinanceiro);

    // Inicialização
    applyMaskCurrency();
    checkMotoristaPagou();

    // Autopreencher empresa ao selecionar motorista
    const selectMotorista = document.getElementById('motorista_id');
    const selectEmpresa = document.getElementById('empresa_id');
    if (selectMotorista && selectEmpresa) {
        selectMotorista.addEventListener('change', function() {
            const motoristaId = this.value;
            if (!motoristaId) return;
            
            const selectedOption = this.querySelector('option[value="' + motoristaId + '"]');
            if (selectedOption) {
                const empresaId = selectedOption.getAttribute('data-empresa-id');
                if (empresaId) {
                    if (selectEmpresa.tomselect) {
                        selectEmpresa.tomselect.setValue(empresaId);
                    } else {
                        selectEmpresa.value = empresaId;
                    }
                }
            }
        });
    }

    if (parseInt(inputQtdParcelas.value) > 0) {
        bindParcelaEvents();
    }
    atualizarResultadoFinanceiro();

});
</script>
