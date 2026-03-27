// Parallax subtil sur les images des cartes au survol
document.querySelectorAll('.step-card').forEach(card => {
    const img = card.querySelector('.step-image-wrap img');
    if (!img) return;

    card.addEventListener('mousemove', (e) => {
        const rect = card.getBoundingClientRect();
        const x = (e.clientX - rect.left) / rect.width - 0.5;
        const y = (e.clientY - rect.top) / rect.height - 0.5;
        img.style.transform = `scale(1.05) translate(${x * 8}px, ${y * 8}px)`;
    });

    card.addEventListener('mouseleave', () => {
        img.style.transform = '';
    });
});

// Apparition progressive des cartes au scroll
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
            observer.unobserve(entry.target);
        }
    });
}, { threshold: 0.1 });

document.querySelectorAll('.step-card').forEach((card, i) => {
    card.style.opacity = '0';
    card.style.transform = 'translateY(24px)';
    card.style.transition = `opacity 0.5s ease ${i * 0.08}s, transform 0.5s ease ${i * 0.08}s, border-color 0.25s, box-shadow 0.25s`;
    observer.observe(card);
});

// Liens de navigation actifs
const navLinks = document.querySelectorAll('.main-nav a');
navLinks.forEach(link => {
    link.addEventListener('click', (e) => {
        if (e.currentTarget.getAttribute('href') === '#') {
            e.preventDefault();
        }
    });
});
