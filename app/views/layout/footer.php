    <!-- Footer -->
    <footer class="footer-section text-center py-4 mt-auto">
        <div class="container-fluid px-4">
            <p class="mb-1 text-muted-custom">
                <i class="bi bi-truck me-1"></i>
                <strong>TrackMultas</strong> &mdash; Sistema de Gestão de Multas para Transportadoras
            </p>
            <p class="mb-0 small text-muted-custom">
                &copy; <?php echo date('Y'); ?> TrackMultas. Todos os direitos reservados.
            </p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Chart.js (para Dashboard) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>

    <!-- TomSelect JS -->
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar TomSelect em todos os selects, exceto os que estiverem com a classe .no-ts
            document.querySelectorAll('select:not(.no-ts)').forEach(function(el) {
                if (!el.tomselect) {
                    let hasCreate = el.classList.contains('ts-create');
                    new TomSelect(el, {
                        create: hasCreate,
                        allowEmptyOption: true
                        // Removido o sortField para respeitar a ordem original do HTML
                    });
                }
            });
        });
    </script>

    <!-- JS customizado -->
    <script src="<?php echo BASE_URL; ?>assets/js/script.js?v=<?php echo time(); ?>"></script>
</body>
</html>
