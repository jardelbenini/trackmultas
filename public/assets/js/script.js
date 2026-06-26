/**
 * TrackMultas - Script Principal
 * Sistema de Gestão de Multas para Transportadoras
 */

document.addEventListener('DOMContentLoaded', function () {
    console.log('✅ TrackMultas carregado com sucesso!');

    // Animação de entrada dos cards ao rolar a página
    const moduleCards = document.querySelectorAll('.module-card');

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

        moduleCards.forEach(function (card) {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(card);
        });
    }
});
