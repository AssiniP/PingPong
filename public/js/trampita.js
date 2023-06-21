function usarTrampita(){
    var idUsuario = document.getElementById("usuario").innerHTML;
    var idPregunta = document.getElementById("idPregunta").innerHTML;

    var data = {
        idUsuario: idUsuario
    };

    var requestOptions = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    };

    var url = 'http://localhost:80/partida/usarTrampita';

    fetch(url, requestOptions)
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error('Hubo un error al usar la trampita.');
            }
        })
        .then(result => {
            if (result.tieneTrampita) {
                dataAPI.forEach(pregunta => {
                    if (parseInt(idPregunta) === parseInt(pregunta.id)) {
                        var respuestaCorrecta = pregunta.opciones.respuesta_correcta;
                        var opcionCorrecta = 'http://localhost:80/partida/respuesta?opcion='+ respuestaCorrecta +'&pregunta='+idPregunta;
                        window.location.href = opcionCorrecta;
                    }
                })
            } else {
                mostrarPopupComprarTrampita();
            }
        })
        .catch(error => {
            console.log('Hubo un error en la solicitud AJAX:', error);
        });
}

function mostrarPopupComprarTrampita() {
    var popup = document.getElementById("popup-trampita");
    popup.style.display = "block";
}

function comprarTrampita() {
    console.log('Trampita comprada');
}