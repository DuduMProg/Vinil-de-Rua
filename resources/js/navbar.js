// ── Scroll do header ──
window.addEventListener("scroll", function () {
    const header = document.querySelector("header");
    if (header) header.classList.toggle("scrolled", window.scrollY > 1);
});

const sidebar = document.getElementById("sidebar");
const overlay = document.getElementById("overlay");
const title = document.getElementById("sidebar-title");
const content = document.getElementById("sidebar-content");

// Menu mobile

document.getElementById('btnMenu')?.addEventListener('click', function () {
    const mobileNav = document.getElementById('mobileNav');
    mobileNav.classList.toggle('active');
});

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
    document.getElementById('sidebarFavorite')?.classList.remove('active');
    overlay.classList.remove("active");
}

// Recarrega sidebar após ações do carrinho
document.addEventListener("click", function (e) {
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
            fetch("/cart/sidebar")
                .then(res => res.text())
                .then(html => content.innerHTML = html);
        });
});

document.addEventListener("DOMContentLoaded", function () {

    // Ícone do carrinho no header
    document.getElementById("btnCart")?.addEventListener("click", function () {
        openSidebar("cart");
    });

    // Link "Editar" no checkout
    document.getElementById("btnEditarPedido")?.addEventListener("click", function (e) {
        e.preventDefault();
        openSidebar("cart");
    });

    // Fecha ao clicar no overlay
    document.getElementById("overlay")?.addEventListener("click", closeSidebar);

    // Fecha ao clicar no X
    document.getElementById("btnFecharSidebar")?.addEventListener("click", closeSidebar);
});

// Wishlist
// Abre sidebar de favoritos
document.getElementById('btnFavorite')?.addEventListener('click', function () {
    document.getElementById('sidebarFavorite').classList.add('active');
    document.getElementById('overlay').classList.add('active');
    atualizarFavoritos();
});

// Fecha sidebar de favoritos
document.getElementById('btnFecharFavorite')?.addEventListener('click', function () {
    document.getElementById('sidebarFavorite').classList.remove('active');
    document.getElementById('overlay').classList.remove('active');
});

// Carrega conteúdo dos favoritos via AJAX
async function atualizarFavoritos() {
    const res = await fetch('/whishlist/sidebar');
    const html = await res.text();
    const content = document.getElementById('favorite-content');
    if (content) content.innerHTML = html;
}

// Intercepta forms de desfavoritar dentro da sidebar
document.getElementById('sidebarFavorite')?.addEventListener('submit', async function (e) {
    const form = e.target;
    e.preventDefault();

    await fetch(form.action, {
        method: 'POST',
        body: new FormData(form),
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    });

    await atualizarFavoritos();
});



//esconder / aparecer sair do adm
const btnUsuario = document.getElementById('btnUsuario');
const menuLogout = document.getElementById('menuLogout');

if (btnUsuario && menuLogout) {

    btnUsuario.addEventListener('click', (e) => {
        e.stopPropagation();
        menuLogout.classList.toggle('ativo');
    });

    document.addEventListener('click', (e) => {

        if (
            !e.target.closest('#btnUsuario') &&
            !e.target.closest('#menuLogout')
        ) {
            menuLogout.classList.remove('ativo');
        }

    });

}
