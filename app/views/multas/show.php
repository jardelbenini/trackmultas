<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Detalhes da Multa #<?php echo $multa['id']; ?></h2>
        <div>
            <a href="<?php echo BASE_URL; ?>index.php?controller=multas&action=edit&id=<?php echo $multa['id']; ?>" class="btn btn-primary me-2">
                <i class="bi bi-pencil"></i> Editar
            </a>
            <a href="<?php echo BASE_URL; ?>index.php?controller=multas&action=index" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Voltar
            </a>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0 text-primary">Informações da Infração</h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-sm-3"><strong>Auto de Infração:</strong></div>
                <div class="col-sm-9"><?php echo htmlspecialchars($multa['auto_infracao']); ?></div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-3"><strong>Data/Hora:</strong></div>
                <div class="col-sm-9">
                    <?php echo $multa['data_infracao'] ? date('d/m/Y', strtotime($multa['data_infracao'])) : '-'; ?> 
                    <?php echo $multa['hora_infracao'] ? ' às ' . date('H:i', strtotime($multa['hora_infracao'])) : ''; ?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-3"><strong>Local da Multa:</strong></div>
                <div class="col-sm-9"><?php echo htmlspecialchars($multa['local_multa']); ?></div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-3"><strong>Cidade/UF:</strong></div>
                <div class="col-sm-9">
                    <?php echo htmlspecialchars($multa['cidade'] . (!empty($multa['estado']) ? '/' . $multa['estado'] : '')); ?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-3"><strong>Órgão Autuador:</strong></div>
                <div class="col-sm-9"><?php echo htmlspecialchars($multa['orgao_nome']); ?></div>
            </div>
            <div class="row">
                <div class="col-sm-3"><strong>Motivo da Infração:</strong></div>
                <div class="col-sm-9">
                    <?php echo htmlspecialchars($multa['motivo_codigo'] . ' - ' . $multa['motivo_descricao']); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0 text-primary">Envolvidos</h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-sm-3"><strong>Motorista:</strong></div>
                <div class="col-sm-9"><?php echo htmlspecialchars($multa['motorista_nome']); ?></div>
            </div>
            <div class="row">
                <div class="col-sm-3"><strong>Veículo / Placa:</strong></div>
                <div class="col-sm-9">
                    <?php echo htmlspecialchars($multa['veiculo_placa'] . ' - ' . $multa['veiculo_marca'] . ' ' . $multa['veiculo_modelo']); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0 text-primary">Responsabilidade e Andamento</h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-sm-3"><strong>Responsabilidade:</strong></div>
                <div class="col-sm-9"><?php echo htmlspecialchars($multa['responsabilidade_nome']); ?></div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-3"><strong>Status do Motorista:</strong></div>
                <div class="col-sm-9"><?php echo htmlspecialchars($multa['status_motorista_nome']); ?></div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-3"><strong>Status / Andamento:</strong></div>
                <div class="col-sm-9">
                    <span class="badge bg-secondary"><?php echo htmlspecialchars($multa['status_andamento_nome']); ?></span>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3"><strong>Prazo para Defesa / Indicação do Condutor:</strong></div>
                <div class="col-sm-9">
                    <?php echo $multa['prazo_indicar_condutor'] ? date('d/m/Y', strtotime($multa['prazo_indicar_condutor'])) : '-'; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0 text-primary">Financeiro e Pagamento</h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-sm-3"><strong>Valor Real:</strong></div>
                <div class="col-sm-9 text-danger fw-bold">R$ <?php echo number_format($multa['valor_real'], 2, ',', '.'); ?></div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-3"><strong>Status de Pagamento:</strong></div>
                <div class="col-sm-9">
                    <span class="badge <?php echo htmlspecialchars($multa['status_pagamento_cor'] ?? 'bg-info'); ?>"><?php echo htmlspecialchars($multa['status_pagamento_nome']); ?></span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-3"><strong>Data de Vencimento:</strong></div>
                <div class="col-sm-9"><?php echo $multa['data_vencimento'] ? date('d/m/Y', strtotime($multa['data_vencimento'])) : '-'; ?></div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-3"><strong>Data de Pagamento:</strong></div>
                <div class="col-sm-9"><?php echo $multa['data_pagamento'] ? date('d/m/Y', strtotime($multa['data_pagamento'])) : '-'; ?></div>
            </div>
            <hr>
            <div class="row mb-3">
                <div class="col-sm-3"><strong>Motorista Pagou?</strong></div>
                <div class="col-sm-9"><?php echo $multa['motorista_pagou'] ? 'Sim' : 'Não'; ?></div>
            </div>
            <?php if ($multa['motorista_pagou']): ?>
            <div class="row mb-3">
                <div class="col-sm-3"><strong>Valor Combinado R$:</strong></div>
                <div class="col-sm-9 text-primary fw-bold">R$ <?php echo number_format($multa['valor_acordado'] ?? 0, 2, ',', '.'); ?></div>
            </div>
            <?php endif; ?>
            <div class="row mb-3">
                <div class="col-sm-3"><strong>Valor Pago pelo Motorista:</strong></div>
                <div class="col-sm-9">R$ <?php echo number_format($multa['valor_pago_motorista'], 2, ',', '.'); ?></div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-3"><strong>Valor Pago pela Empresa:</strong></div>
                <div class="col-sm-9">R$ <?php echo number_format($multa['valor_pago_empresa'], 2, ',', '.'); ?></div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-3"><strong>Desconto no Pagamento:</strong></div>
                <div class="col-sm-9">
                    <?php 
                        if ($multa['desconto_pagamento']) {
                            echo htmlspecialchars($multa['desconto_pagamento']);
                        } else {
                            echo '<span class="text-muted">Sem informação</span>';
                        }
                    ?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-3"><strong>Resultado (Lucro/Prejuízo):</strong></div>
                <div class="col-sm-9">
                    <?php 
                        $res = $multa['resultado_financeiro'] ?? 0;
                        if ($res > 0) {
                            echo '<span class="text-success fw-bold">+ R$ ' . number_format($res, 2, ',', '.') . ' (Lucro)</span>';
                        } else if ($res < 0) {
                            echo '<span class="text-danger fw-bold">- R$ ' . number_format(abs($res), 2, ',', '.') . ' (Prejuízo)</span>';
                        } else {
                            echo '<span class="text-secondary fw-bold">R$ 0,00</span>';
                        }
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3"><strong>Data do Combinado:</strong></div>
                <div class="col-sm-9"><?php echo $multa['data_acerto_motorista'] ? date('d/m/Y', strtotime($multa['data_acerto_motorista'])) : '-'; ?></div>
            </div>
            
            <?php if (isset($parcelas) && count($parcelas) > 0): ?>
            <hr>
            <h6 class="text-secondary mb-3"><i class="bi bi-list-ol me-2"></i>Detalhamento das Parcelas</h6>
            <div class="table-responsive">
                <table class="table table-sm table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width: 10%;">Nº</th>
                            <th>Valor</th>
                            <th>Vencimento</th>
                            <th>Pagamento</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($parcelas as $p): ?>
                            <tr>
                                <td class="text-center"><?php echo $p['numero_parcela']; ?></td>
                                <td>R$ <?php echo number_format($p['valor'], 2, ',', '.'); ?></td>
                                <td><?php echo $p['data_vencimento'] ? date('d/m/Y', strtotime($p['data_vencimento'])) : '-'; ?></td>
                                <td>
                                    <?php if ($p['data_pagamento']): ?>
                                        <span class="text-success"><i class="bi bi-check-circle-fill me-1"></i> <?php echo date('d/m/Y', strtotime($p['data_pagamento'])); ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if (!empty($multa['tratativa'])): ?>
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0 text-primary">Observações / Tratativa</h5>
        </div>
        <div class="card-body">
            <p class="mb-0 text-break"><?php echo nl2br(htmlspecialchars($multa['tratativa'])); ?></p>
        </div>
    </div>
    <?php endif; ?>
</div>
