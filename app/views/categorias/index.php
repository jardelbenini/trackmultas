<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Categorias de Infrações</h2>
        <a href="<?php echo BASE_URL; ?>index.php?controller=categorias_infracoes&action=create" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Nova Categoria
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nome da Categoria</th>
                            <th class="text-center" style="width: 1%; white-space: nowrap;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($categorias)): ?>
                            <tr>
                                <td colspan="2" class="text-center py-4">Nenhuma categoria encontrada.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($categorias as $cat): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($cat['nome']); ?></td>
                                    <td class="text-center text-nowrap">
                                        <a href="<?php echo BASE_URL; ?>index.php?controller=categorias_infracoes&action=edit&id=<?php echo $cat['id']; ?>" class="btn btn-sm btn-outline-primary" title="Editar">
                                            <i class="bi bi-pencil"></i> Editar
                                        </a>
                                        <a href="<?php echo BASE_URL; ?>index.php?controller=categorias_infracoes&action=delete&id=<?php echo $cat['id']; ?>" class="btn btn-sm btn-outline-danger" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir esta categoria? Ela será desvinculada dos motivos de infração correspondentes.');">
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
