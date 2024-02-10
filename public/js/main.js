

const sidebar = document.getElementById('sidebar');
const toggleButton = document.getElementById('toggleButton');
const labelA = sidebar.querySelectorAll('label');


toggleButton.addEventListener('click', () => {
    sidebar.classList.toggle('w-14');
    sidebar.classList.toggle('w-48'); // Ajuste o tamanho desejado aqui

    labelA.forEach((label) => {

        setTimeout(() => {
            label.classList.toggle('hidden');
        }, 50); // 300 milissegundos (0,3 segundos) de atraso
    });
});

const abrirModal = document.querySelector('.abrir-modal');
const fecharModal = document.querySelector('.fechar-modal');
const cancelarModal = document.querySelector('.cancelar-modal');
const modalContainer = document.querySelector('.modal-container');

if (abrirModal) {
    abrirModal.addEventListener("click", () => {
        modalContainer.classList.toggle("hidden");// O botão existe, então você pode adicionar o evento de click.
    });
}
if (fecharModal) {
    fecharModal.addEventListener("click", () => {

        modalContainer.classList.toggle("hidden");// O botão existe, então você pode adicionar o evento de click.
    });
    cancelarModal.addEventListener("click", () => {

        modalContainer.classList.toggle("hidden");// O botão existe, então você pode adicionar o evento de click.
    });

}
