<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Status de Andamento</h2>
        <a href="<?php echo BASE_URL; ?>index.php?controller=status_andamento&action=create" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Novo Status
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nome do Status</th>
                            <th class="text-center" style="width: 1%; white-space: nowrap;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($status_andamento)): ?>
                            <tr>
                                <td colspan="2" class="text-center py-4">Nenhum status encontrado.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($status_andamento as $item): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['nome']); ?></td>
                                    <td class="text-center text-nowrap">
                                        <a href="<?php echo BASE_URL; ?>index.php?controller=status_andamento&action=edit&id=<?php echo $item['id']; ?>" class="btn btn-sm btn-outline-primary" title="Editar">
                                            <i class="bi bi-pencil"></i> Editar
                                        </a>
                                        <a href="<?php echo BASE_URL; ?>index.php?controller=status_andamento&action=delete&id=<?php echo $item['id']; ?>" class="btn btn-sm btn-outline-danger" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir?');">
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