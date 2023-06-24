document.addEventListener('click', function(event) {
    var enlace = event.target.closest('a.header-link');
    if (enlace) {
        event.preventDefault();

        var url = enlace.getAttribute('href');
        var redirectUrl = '/partida/terminarPartida?url=' + encodeURIComponent(url);

        window.location.href = redirectUrl;
    }
});