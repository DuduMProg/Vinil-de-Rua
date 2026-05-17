// ── Scroll do header ──
window.addEventListener("scroll", function () {
    const header = document.querySelector("header");
    if (header) header.classList.toggle("scrolled", window.scrollY > 1);
});

// ── Sidebar ──
window.openSidebar = function () {
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("overlay");

    sidebar.classList.add("active");
    overlay.classList.add("active");

    atualizarSidebar(); // carrega conteúdo atualizado ao abrir
}

window.closeSidebar = function () {
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("overlay");

    sidebar.classList.remove("active");
    overlay.classList.remove("active");
}

// ── Atualiza conteúdo da sidebar via AJAX ──
async function atualizarSidebar() {
    const res = await fetch("/cart/sidebar", {
        headers: {
            "X-Requested-With": "XMLHttpRequest",
            "Accept": "text/html"
        }
    });
    const html = await res.text();
    const content = document.querySelector(".sidebar-content");
    if (content) content.innerHTML = html;
}

// ── Inicialização ──
document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.getElementById("sidebar");
    if (!sidebar) return;

    // Impede que cliques dentro da sidebar fechem ela
    sidebar.addEventListener("click", function (e) {
        e.stopPropagation();
    });

    // Intercepta forms da sidebar via AJAX
    sidebar.addEventListener("submit", async function (e) {
        const form = e.target;

        // Deixa o checkout funcionar normalmente
        if (form.closest(".btnResumo")) return;

        e.preventDefault();

        // Espera o POST terminar antes de atualizar
        await fetch(form.action, {
            method: "POST",
            body: new FormData(form),
            headers: { "X-Requested-With": "XMLHttpRequest" }
        });

        // Busca HTML atualizado e injeta na sidebar
        await atualizarSidebar();
    });
});