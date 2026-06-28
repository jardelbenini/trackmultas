<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Veículos</h2>
        <a href="<?php echo BASE_URL; ?>index.php?controller=veiculos&action=create" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Novo Veículo
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Placa</th>
                            <th>Renavam</th>
                            <th>Tipo</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Ano de Fabricação</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($veiculos)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-4">Nenhum veículo encontrado.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($veiculos as $veiculo): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($veiculo['placa']); ?></td>
                                    <td><?php echo htmlspecialchars($veiculo['renavam']); ?></td>
                                    <td><?php echo htmlspecialchars($veiculo['tipo_nome']); ?></td>
                                    <td><?php echo htmlspecialchars($veiculo['marca'] ?? '-'); ?></td>
                                    <td><?php echo htmlspecialchars($veiculo['modelo'] ?? '-'); ?></td>
                                    <td><?php echo htmlspecialchars($veiculo['ano_fabricacao'] ?? '-'); ?></td>
                                    <td class="text-end">
                                        <a href="<?php echo BASE_URL; ?>index.php?controller=veiculos&action=edit&id=<?php echo $veiculo['id']; ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i> Editar
                                        </a>
                                        <a href="<?php echo BASE_URL; ?>index.php?controller=veiculos&action=delete&id=<?php echo $veiculo['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tem certeza que deseja excluir este veículo?');">
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
