<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Tipos de Veículos</h2>
        <a href="<?php echo BASE_URL; ?>index.php?controller=tipos_veiculos&action=create" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Novo Tipo
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nome do Tipo</th>
                            <th class="text-center" style="width: 1%; white-space: nowrap;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($tipos)): ?>
                            <tr>
                                <td colspan="2" class="text-center py-4">Nenhum tipo de veículo encontrado.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($tipos as $t): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($t['nome']); ?></td>
                                    <td class="text-center" style="white-space: nowrap;">
                                        <a href="<?php echo BASE_URL; ?>index.php?controller=tipos_veiculos&action=edit&id=<?php echo $t['id']; ?>" class="btn btn-sm btn-outline-primary" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="<?php echo BASE_URL; ?>index.php?controller=tipos_veiculos&action=delete&id=<?php echo $t['id']; ?>" class="btn btn-sm btn-outline-danger" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir este tipo de veículo?');">
                                            <i class="bi bi-trash"></i>
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
