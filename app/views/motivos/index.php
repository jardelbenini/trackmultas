<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Motivos de Infração</h2>
        <a href="<?php echo BASE_URL; ?>index.php?controller=motivos_infracoes&action=create" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Novo Motivo
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Código</th>
                            <th>Descrição</th>
                            <th>Gravidade</th>
                            <th>Pontos</th>
                            <th>Valor Total</th>
                            <th class="text-center" style="width: 1%; white-space: nowrap;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($motivos)): ?>
                            <tr>
                                <td colspan="4" class="text-center py-4">Nenhum motivo encontrado.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($motivos as $motivo): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($motivo['codigo']); ?></td>
                                    <td>
                                        <span class="d-inline-block text-truncate" style="max-width: 450px;" title="<?php echo htmlspecialchars($motivo['descricao']); ?>">
                                            <?php echo htmlspecialchars($motivo['descricao']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($motivo['gravidade'] === 'Gravíssima'): ?>
                                            <span class="badge bg-danger">Gravíssima</span>
                                        <?php elseif ($motivo['gravidade'] === 'Grave'): ?>
                                            <span class="badge bg-warning text-dark">Grave</span>
                                        <?php elseif ($motivo['gravidade'] === 'Média'): ?>
                                            <span class="badge bg-info text-dark">Média</span>
                                        <?php elseif ($motivo['gravidade'] === 'Leve'): ?>
                                            <span class="badge bg-success">Leve</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary"><?php echo htmlspecialchars($motivo['gravidade'] ?: '-'); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($motivo['pontos']); ?></td>
                                    <td><?php echo $motivo['valor_multa'] ? 'R$ ' . number_format($motivo['valor_multa'], 2, ',', '.') : '-'; ?></td>
                                    <td class="text-center text-nowrap">
                                        <a href="<?php echo BASE_URL; ?>index.php?controller=motivos_infracoes&action=edit&id=<?php echo $motivo['id']; ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i> Editar
                                        </a>
                                        <a href="<?php echo BASE_URL; ?>index.php?controller=motivos_infracoes&action=delete&id=<?php echo $motivo['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tem certeza que deseja excluir?');">
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
