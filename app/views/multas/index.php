<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Controle de Multas</h2>
        <a href="<?php echo BASE_URL; ?>index.php?controller=multas&action=create" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Nova Multa
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Auto de Infração</th>
                            <th>Empresa</th>
                            <th>Motorista</th>
                            <th>Placa</th>
                            <th>Data da Infração</th>
                            <th>Cidade/UF</th>
                            <th>Órgão</th>
                            <th>Motivo</th>
                            <th>Valor Real</th>
                            <th>Status da Multa</th>
                            <th>Status Pagamento</th>
                            <th class="text-center" style="width: 1%; white-space: nowrap;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($multas)): ?>
                            <tr>
                                <td colspan="12" class="text-center py-4">Nenhuma multa encontrada.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($multas as $m): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($m['auto_infracao']); ?></td>
                                    <td><?php echo htmlspecialchars($m['empresa_nome'] ?? '-'); ?></td>
                                    <td><?php echo htmlspecialchars($m['motorista_nome']); ?></td>
                                    <td><?php echo htmlspecialchars($m['veiculo_placa']); ?></td>
                                    <td><?php echo $m['data_infracao'] ? date('d/m/Y', strtotime($m['data_infracao'])) : '-'; ?></td>
                                    <td>
                                        <?php 
                                            $cidadeUf = [];
                                            if (!empty($m['cidade'])) $cidadeUf[] = htmlspecialchars($m['cidade']);
                                            if (!empty($m['estado'])) $cidadeUf[] = htmlspecialchars($m['estado']);
                                            echo !empty($cidadeUf) ? implode('/', $cidadeUf) : '-';
                                        ?>
                                    </td>
                                    <td><?php echo htmlspecialchars(!empty($m['orgao_sigla']) ? $m['orgao_sigla'] : $m['orgao_nome']); ?></td>
                                    <td>
                                        <span class="d-inline-block text-truncate" style="max-width: 150px;" title="<?php echo htmlspecialchars($m['motivo_descricao']); ?>">
                                            <?php echo htmlspecialchars($m['motivo_descricao']); ?>
                                        </span>
                                    </td>
                                    <td>R$ <?php echo number_format($m['valor_real'], 2, ',', '.'); ?></td>
                                    <td>
                                        <span class="badge bg-secondary"><?php echo htmlspecialchars($m['status_andamento_nome']); ?></span>
                                    </td>
                                    <td>
                                        <span class="badge <?php echo htmlspecialchars($m['status_pagamento_cor'] ?? 'bg-info'); ?>"><?php echo htmlspecialchars($m['status_pagamento_nome']); ?></span>
                                    </td>
                                    <td class="text-center text-nowrap">
                                        <a href="<?php echo BASE_URL; ?>index.php?controller=multas&action=show&id=<?php echo $m['id']; ?>" class="btn btn-sm btn-outline-info" title="Ver Detalhes">
                                            <i class="bi bi-eye"></i> Ver
                                        </a>
                                        <a href="<?php echo BASE_URL; ?>index.php?controller=multas&action=edit&id=<?php echo $m['id']; ?>" class="btn btn-sm btn-outline-primary" title="Editar">
                                            <i class="bi bi-pencil"></i> Editar
                                        </a>
                                        <a href="<?php echo BASE_URL; ?>index.php?controller=multas&action=delete&id=<?php echo $m['id']; ?>" class="btn btn-sm btn-outline-danger" title="Excluir" onclick="return confirm('Deseja realmente excluir esta multa?');">
                                            <i class="bi bi-trash"></i> Excluir
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
