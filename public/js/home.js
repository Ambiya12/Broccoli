document.addEventListener("mousemove", (e) => {
    const x = e.clientX / window.innerWidth - 0.5;
    const y = e.clientY / window.innerHeight - 0.5;
    
    const centerImg = document.querySelector(".center-image img");
    const heroLeft = document.querySelector(".hero-title.left");
    const heroRight = document.querySelector(".hero-title.right");

    if (centerImg) {
        centerImg.style.transform = `translate(${x * 20}px, ${y * 20}px) rotate(${x * 5}deg)`;
    }
    
    if (heroLeft) {
        heroLeft.style.transform = `translate(${-x * 30}px, ${-y * 10}px)`;
    }
    
    if (heroRight) {
        heroRight.style.transform = `translate(${-x * 30}px, ${-y * 10}px)`;
    }
});

const navLinks = document.querySelectorAll('.main-nav a');
navLinks.forEach(link => {
    link.addEventListener('click', (e) => {
        e.preventDefault();
        navLinks.forEach(l => l.classList.remove('active'));
        e.target.classList.add('active');
    });
});