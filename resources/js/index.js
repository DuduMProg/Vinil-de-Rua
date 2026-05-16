document.addEventListener('DOMContentLoaded', function () {
    const cardOff = document.getElementById("cardOff");
    const closeCard = document.getElementById("closeCard");
    const catalogo = document.querySelector(".catalogoIndex");

    closeCard.addEventListener("click", () => {
        // esconder oferta
        cardOff.style.display = "none";

        // centralizar catálogo
        catalogo.classList.add("centered");
    });
});

window.openSidebar = function(type) {

    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("overlay");

    sidebar.classList.add("active");
    overlay.classList.add("active");
}

window.closeSidebar = function() {

    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("overlay");

    sidebar.classList.remove("active");
    overlay.classList.remove("active");
}
