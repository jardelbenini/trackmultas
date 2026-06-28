<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Órgãos Autuadores</h2>
        <a href="<?php echo BASE_URL; ?>index.php?controller=orgaos&action=create" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Novo Órgão
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nome do Órgão</th>
                            <th class="text-center" style="width: 1%; white-space: nowrap;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($orgaos)): ?>
                            <tr>
                                <td colspan="3" class="text-center py-4">Nenhum órgão encontrado.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($orgaos as $orgao): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($orgao['nome']); ?></td>
                                    <td class="text-center text-nowrap">
                                        <a href="<?php echo BASE_URL; ?>index.php?controller=orgaos&action=edit&id=<?php echo $orgao['id']; ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i> Editar
                                        </a>
                                        <a href="<?php echo BASE_URL; ?>index.php?controller=orgaos&action=delete&id=<?php echo $orgao['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tem certeza que deseja excluir?');">
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
