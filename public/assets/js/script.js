/**
 * TrackMultas - Script Principal
 * Sistema de Gestão de Multas para Transportadoras
 */

document.addEventListener('DOMContentLoaded', function () {
    console.log('✅ TrackMultas carregado com sucesso!');

    // ========================================
    // Animação de entrada dos cards ao rolar
    // ========================================
    const animatedElements = document.querySelectorAll('.module-card, .kpi-card, .chart-card, .detail-card');

    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        animatedElements.forEach(function (el) {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            observer.observe(el);
        });
    }

    // ========================================
    // Máscaras de Input
    // ========================================

    // Máscara CPF: 000.000.000-00
    document.querySelectorAll('.mask-cpf').forEach(function (input) {
        input.addEventListener('input', function (e) {
            let v = e.target.value.replace(/\D/g, '').substring(0, 11);
            if (v.length > 9) {
                v = v.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, '$1.$2.$3-$4');
            } else if (v.length > 6) {
                v = v.replace(/(\d{3})(\d{3})(\d{1,3})/, '$1.$2.$3');
            } else if (v.length > 3) {
                v = v.replace(/(\d{3})(\d{1,3})/, '$1.$2');
            }
            e.target.value = v;
        });
    });

    // Máscara Telefone: (00) 00000-0000
    document.querySelectorAll('.mask-telefone').forEach(function (input) {
        input.addEventListener('input', function (e) {
            let v = e.target.value.replace(/\D/g, '').substring(0, 11);
            if (v.length > 6) {
                v = v.replace(/(\d{2})(\d{5})(\d{1,4})/, '($1) $2-$3');
            } else if (v.length > 2) {
                v = v.replace(/(\d{2})(\d{1,5})/, '($1) $2');
            } else if (v.length > 0) {
                v = v.replace(/(\d{1,2})/, '($1');
            }
            e.target.value = v;
        });
    });

    // ========================================
    // Auto-dismiss de alertas
    // ========================================
    document.querySelectorAll('.alert-dismissible').forEach(function (alert) {
        setTimeout(function () {
            var bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            if (bsAlert) {
                bsAlert.close();
            }
        }, 5000);
    });

    // ========================================
    // Placa uppercase automático
    // ========================================
    document.querySelectorAll('.text-uppercase').forEach(function (input) {
        input.addEventListener('input', function (e) {
            e.target.value = e.target.value.toUpperCase();
        });
    });

    // ========================================
    // Highlight de linha ativa na tabela
    // ========================================
    document.querySelectorAll('.table-custom tbody tr').forEach(function (row) {
        row.addEventListener('mouseenter', function () {
            this.style.cursor = 'default';
        });
    });
});
