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

const comprarBtn = document.getElementById('comprarTrampita-btn');
comprarBtn.addEventListener('click', () => {
    // Realiza la solicitud AJAX utilizando fetch
    fetch('/partida/comprarTrampita', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
    })
        .then((response) => {
            if (response.ok) {
                // Si la compra fue exitosa, llama a la función para usar la trampita
                usarTrampita();
            } else {
                console.error('Error al comprar la trampita');
            }
        })
        .catch((error) => {
            console.error(error);
        });
});