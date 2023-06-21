let dataAPI;
function consultarAPI() {
        let usuario = document.getElementById("usuario");
    fetch('http://localhost:80/api/list?usuario=' + usuario.innerText)
        .then(response => response.json())
        .then(data => {
                console.log(data)
                var primeraPregunta = data.preguntas[0];
                let contenedorCategoria = document.getElementById('contenedor-categoria')
            let botonJugar = document.getElementById("btn-jugar");
            if(botonJugar!=null){
                    botonJugar.classList.add('hidden');
            }
            let contenedor = document.getElementById("contenedor-pregunta");
                contenedorCategoria.classList.add('pregunta-container');
                contenedorCategoria.classList.add('cuadro');
                contenedorCategoria.classList.add('text-center');
                contenedorCategoria.classList.add('text-4xl');
                contenedorCategoria.style.backgroundColor = primeraPregunta.categoria.color;
                contenedorCategoria.style.color = 'white';
                contenedorCategoria.innerText =  primeraPregunta.categoria.nombre;
                contenedor.classList.add('pregunta-container');
                contenedor.classList.add('cuadro');
                contenedor.classList.add('text-center');
                contenedor.style.backgroundColor = primeraPregunta.categoria.color;

            let preguntaHTML = document.getElementById("pregunta");
            preguntaHTML.innerText = primeraPregunta.pregunta;
            const numerosMezclados = mezcladorNumerico();
            console.log(numerosMezclados);
            const num1 = numerosMezclados[0];
            const num2 = numerosMezclados[1];
            const num3 = numerosMezclados[2];
            const num4 = numerosMezclados[3];
            let opcion1 = "opcion"+num1;
            let opcion2 = "opcion"+num2;
            let opcion3 = "opcion"+num3;
            let opcion4 = "opcion"+num4;


            console.log(num1);
            console.log(num2);
            console.log(num3);
            console.log(num4);
            let opcion1HTML = document.getElementById(opcion1);
            console.log(opcion1HTML);
            opcion1HTML.innerText = primeraPregunta.opciones.opcion_1;
            opcion1HTML.href = 'http://localhost:80/partida/respuesta?opcion='+ opcion1HTML.innerText+'&pregunta='+primeraPregunta.id;
            opcion1HTML.classList.add('boton-opcion');
            console.log( "esta es la url = "+ opcion1HTML.href);
            opcion1HTML.style.backgroundColor = primeraPregunta.categoria.color;
            let opcion2HTML = document.getElementById(opcion2);
            opcion2HTML.innerText = primeraPregunta.opciones.opcion_2;
            opcion2HTML.href = 'http://localhost:80/partida/respuesta?opcion='+ opcion2HTML.innerText+'&pregunta='+primeraPregunta.id;
            opcion2HTML.classList.add('boton-opcion');
            console.log( "esta es la url = "+ opcion2HTML.href);
            opcion2HTML.style.backgroundColor = primeraPregunta.categoria.color;
            let opcion3HTML = document.getElementById(opcion3);
            opcion3HTML.innerText = primeraPregunta.opciones.opcion_3;
            opcion3HTML.href = 'http://localhost:80/partida/respuesta?opcion='+ opcion3HTML.innerText+'&pregunta='+primeraPregunta.id;
            opcion3HTML.classList.add('boton-opcion');

            console.log( "esta es la url = "+ opcion3HTML.href);
            opcion3HTML.style.backgroundColor = primeraPregunta.categoria.color;
            let opcion4HTML = document.getElementById(opcion4);
            opcion4HTML.innerText = primeraPregunta.opciones.respuesta_correcta;
            opcion4HTML.href = 'http://localhost:80/partida/respuesta?opcion='+ opcion4HTML.innerText+'&pregunta='+primeraPregunta.id;
            opcion4HTML.classList.add('boton-opcion');
            opcion4HTML.style.backgroundColor = primeraPregunta.categoria.color;
            console.log( "esta es la url = "+ opcion4HTML.href);
            console.log(data);
            dataAPI = data.preguntas;
            console.log("Estoy en colsutla api" + primeraPregunta.id);
            let idPregunta = document.getElementById("idPregunta");
            idPregunta.innerText = primeraPregunta.id;
            let idPreguntaJugada = primeraPregunta.id;
            empezarJugada(idPreguntaJugada);
        })
        .catch(error => {
            // Manejo de errores
            console.error(error);
        });
        let number;

    let input = document.getElementById("numero");
    input.classList.remove("hidden");
    input.classList.add("number");
                number = input.textContent;
        countdown();
        function countdown() {
                repeater = setInterval(runner, 1000);
        }
        function runner() {
                if (number > 0) {
                        number --;
                }else {
                        window.location.href = "/lobby/list";
                }

                input.innerText = number;
        }

    function mezcladorNumerico() {
        const numbers = [1, 2, 3, 4];
        for (let index = 0; index < numbers.length; index++) {
            let j = Math.round(Math.floor(Math.random(1, 4) * (10)));

            if (j >= 0 && j <= 3) {
                [numbers[index], numbers[j]] = [numbers[j], numbers[index]];
            }
        }
        return numbers;
    }

    function empezarJugada(idPregunta){
        const data = {
            idPregunta: idPregunta
        };

        fetch('/partida/empezarJugada', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
            .then(response => {
                if (response.ok) {
                    console.log('La tabla "jugada" se ha creado exitosamente.');
                } else {
                    console.error('Hubo un error al crear la tabla "jugada".');
                }
            })
            .catch(error => {
                console.error('Error en la solicitud AJAX:', error);
            });
    }


}


