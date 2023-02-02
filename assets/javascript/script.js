// Menu burger on mobile

document.getElementById('toggleMobile').addEventListener('click', function () {
    document.getElementById('mobile-menu').classList.toggle('active');

    if (document.getElementById('mobile-menu').classList.contains('active')) {
        document.getElementById('toggleMobile').innerHTML = '<i class="fas fa-times"></i>';
    } else {
        document.getElementById('toggleMobile').innerHTML = '<i class="fas fa-bars"></i>';
    }
});