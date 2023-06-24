function mostrarPopup() {
    var popup = document.getElementById("popup-reporte");
    popup.classList.remove('pop-up')
    popup.classList.add('show');
}

function enviarReporte() {
    var popup = document.getElementById("popup-reporte");
    var motivo = document.getElementById("motivo-reportar").value;
    var idUsuario = document.getElementById("idUsuario").innerHTML;
    var idPregunta = document.getElementById("idPregunta").innerHTML;

    popup.classList.remove('show')
    popup.classList.add('pop-up');

    if (motivo.trim() === '') {
        alert('Por favor, ingresa un motivo para reportar la pregunta.');
        return;
    }

    var data = {
        motivo: motivo,
        idUsuario: idUsuario,
        idPregunta: idPregunta
    };

    var requestOptions = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    };
    var url = 'http://localhost:80/partida/reportarPregunta';

    fetch(url, requestOptions)
        .then(response => {
            if (response.ok) {
                console.log(motivo);
                console.log(idUsuario);
                console.log(idPregunta);
                setTimeout(function() {
                    window.location.href = "/lobby/list";
                }, 5000);
            } else {
                console.log('Hubo un error al enviar el reporte.');
                setTimeout(function() {
                    window.location.href = '{{url}}';
                }, 5000);
            }
        })
        .catch(error => {
            console.log('Hubo un error en la solicitud AJAX:', error);
        });
}