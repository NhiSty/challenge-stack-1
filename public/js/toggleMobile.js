document.addEventListener('DOMContentLoaded', function () {
  // Toggle the "menu-open" class on click
    document
    .querySelector('#toggleMobile')
    .addEventListener('click', function () {
        this.classList.toggle('menu-open');
        document.querySelector('#mobile-menu').classList.toggle('hidden');
        document.querySelector('#toggleMobile i').classList.toggle('fa-times');
    });
});