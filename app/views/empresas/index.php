<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Empresas</h2>
        <a href="<?php echo BASE_URL; ?>index.php?controller=empresas&action=create" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Nova Empresa
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nome</th>
                            <th>CNPJ</th>
                            <th>Data de Cadastro</th>
                            <th class="text-center" style="width: 1%; white-space: nowrap;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($empresas)): ?>
                            <tr>
                                <td colspan="4" class="text-center py-4">Nenhuma empresa encontrada.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($empresas as $emp): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($emp['nome']); ?></td>
                                    <td><?php echo !empty($emp['cnpj']) ? htmlspecialchars($emp['cnpj']) : '-'; ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($emp['created_at'])); ?></td>
                                    <td class="text-center text-nowrap">
                                        <a href="<?php echo BASE_URL; ?>index.php?controller=empresas&action=edit&id=<?php echo $emp['id']; ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i> Editar
                                        </a>
                                        <a href="<?php echo BASE_URL; ?>index.php?controller=empresas&action=delete&id=<?php echo $emp['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tem certeza que deseja excluir esta empresa?');">
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
