
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

            let opcion1HTML = document.getElementById("opcion1");
            opcion1HTML.innerText = primeraPregunta.opciones.opcion_1;
            opcion1HTML.href = '/partida/respuesta?opcion=1&pregunta='+primeraPregunta.id;
            opcion1HTML.classList.add('boton-opcion');
            opcion1HTML.style.backgroundColor = primeraPregunta.categoria.color;
            let opcion2HTML = document.getElementById("opcion2");
            opcion2HTML.innerText = primeraPregunta.opciones.opcion_2;
            opcion2HTML.href = '/partida/respuesta?opcion=2&pregunta='+primeraPregunta.id;
            opcion2HTML.classList.add('boton-opcion');
            opcion2HTML.style.backgroundColor = primeraPregunta.categoria.color;
            let opcion3HTML = document.getElementById("opcion3");
            opcion3HTML.innerText = primeraPregunta.opciones.opcion_3;
            opcion3HTML.href = '/partida/respuesta?opcion=3&pregunta='+primeraPregunta.id;
            opcion3HTML.classList.add('boton-opcion');
            opcion3HTML.style.backgroundColor = primeraPregunta.categoria.color;
            let opcion4HTML = document.getElementById("opcion4");
            opcion4HTML.innerText = primeraPregunta.opciones.opcion_4;
            opcion4HTML.href = '/partida/respuesta?opcion=4&pregunta='+primeraPregunta.id;
            opcion4HTML.classList.add('boton-opcion');
            opcion4HTML.style.backgroundColor = primeraPregunta.categoria.color;
            console.log(data);
            let idPregunta = document.getElementById("idPregunta");
            idPregunta.innerText = primeraPregunta.id;

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
                        number--;
                }else {
                        window.location.href = "/lobby/list";
                }

                input.innerText = number;
        }
}


