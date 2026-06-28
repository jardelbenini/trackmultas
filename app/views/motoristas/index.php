<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Motoristas</h2>
        <a href="<?php echo BASE_URL; ?>index.php?controller=motoristas&action=create" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Novo Motorista
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Empresa</th>
                            <th>Matrícula</th>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>Setor</th>
                            <th>Status</th>
                            <th>Data de Admissão</th>
                            <th class="text-center" style="width: 1%; white-space: nowrap;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($motoristas)): ?>
                            <tr>
                                <td colspan="8" class="text-center py-4">Nenhum motorista encontrado.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($motoristas as $mot): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($mot['empresa_nome']); ?></td>
                                    <td><?php echo !empty($mot['matricula']) ? htmlspecialchars($mot['matricula']) : '-'; ?></td>
                                    <td><?php echo htmlspecialchars($mot['nome']); ?></td>
                                    <td><?php echo !empty($mot['cpf']) ? htmlspecialchars($mot['cpf']) : '-'; ?></td>
                                    <td><?php echo htmlspecialchars($mot['setor_nome']); ?></td>
                                    <td><?php echo htmlspecialchars($mot['status_nome']); ?></td>
                                    <td><?php echo $mot['data_admissao'] ? date('d/m/Y', strtotime($mot['data_admissao'])) : '-'; ?></td>
                                    <td class="text-center text-nowrap">
                                        <a href="<?php echo BASE_URL; ?>index.php?controller=motoristas&action=edit&id=<?php echo $mot['id']; ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i> Editar
                                        </a>
                                        <a href="<?php echo BASE_URL; ?>index.php?controller=motoristas&action=delete&id=<?php echo $mot['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tem certeza que deseja excluir este motorista?');">
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
