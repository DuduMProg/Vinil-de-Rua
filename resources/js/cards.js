document.querySelectorAll('.cardDisco').forEach(card => {
    card.addEventListener('mousemove', e => {
        const r = card.getBoundingClientRect();
        const x = e.clientX - r.left;
        const y = e.clientY - r.top;
        const cx = r.width / 2;
        const cy = r.height / 2;
        const rotY =  ((x - cx) / cx) * 8;
        const rotX = -((y - cy) / cy) * 8;
        card.style.transform =
            `perspective(600px) rotateX(${rotX}deg) rotateY(${rotY}deg) scale(1.03)`;
    });

    card.addEventListener('mouseleave', () => {
        card.style.transform =
            'perspective(600px) rotateX(0deg) rotateY(0deg) scale(1)';
    });
});