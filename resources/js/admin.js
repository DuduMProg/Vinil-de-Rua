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
