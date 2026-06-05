// ── Scroll do header ──
window.addEventListener("scroll", function () {
    const header = document.querySelector("header");
    if (header) header.classList.toggle("scrolled", window.scrollY > 1);
});

const sidebar = document.getElementById("sidebar");
const overlay = document.getElementById("overlay");
const title   = document.getElementById("sidebar-title");
const content = document.getElementById("sidebar-content");

function openSidebar(type) {
    sidebar.classList.add("active");
    overlay.classList.add("active");

    if (type === "cart") {
        title.innerText = "Carrinho";
        content.innerHTML = "<p>Carregando...</p>";

        fetch("/cart/sidebar")
            .then(res => res.text())
            .then(html => content.innerHTML = html)
            .catch(() => content.innerHTML = "<p>Erro ao carregar carrinho.</p>");
    }

    if (type === "wishlist") {
        title.innerText = "Wishlist";
        content.innerHTML = "<p>Você ainda não possui favoritos.</p>";
    }
}

function closeSidebar() {
    sidebar.classList.remove("active");
    overlay.classList.remove("active");
}
// Recarrega sidebar após ações do carrinho
document.addEventListener("click", function(e) {
    const btn = e.target.closest(".qntdProd button, .deleteBtn");
    if (!btn) return;

    const form = btn.closest("form");
    if (!form) return;

    e.preventDefault();

    fetch(form.action, {
        method: "POST",
        body: new FormData(form)
    })
    .then(() => {
        // Recarrega o conteúdo da sidebar
        fetch("/cart/sidebar")
            .then(res => res.text())
            .then(html => content.innerHTML = html);
    });
});

document.addEventListener("DOMContentLoaded", function () {

    // Abre sidebar do carrinho
    document.getElementById("btnCart")?.addEventListener("click", function () {
        openSidebar("cart");
    });

    // Fecha sidebar
    document.getElementById("overlay")?.addEventListener("click", closeSidebar);

});
document.getElementById("btnFecharSidebar")?.addEventListener("click", closeSidebar);


//esconder / aparecer sair do adm
const btnUsuario = document.getElementById('btnUsuario');
const menuLogout = document.getElementById('menuLogout');

btnUsuario.addEventListener('click', () => {
    menuLogout.classList.toggle('ativo');
});

document.addEventListener('click', (e) => {
    if (!e.target.closest('.areaUsuario')) {
        menuLogout.classList.remove('ativo');
    }
});
