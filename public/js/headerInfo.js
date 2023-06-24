window.addEventListener('load', () => {
    fetch('/user/getUserData')
        .then(response => response.json())
        .then(data => {
            console.log(data.rol);
            console.log(data.logueado);
            var anchoNavegador = window.innerWidth;
            if (data.rol === 'Administrador' && anchoNavegador>700) { // Comparar con el string 'Editor'
                // Generar enlace para ABM de preguntas
                const abmPreguntasLink = document.createElement('a');
                abmPreguntasLink.href = '/admin/list/';
                abmPreguntasLink.textContent = 'Administrar';
                abmPreguntasLink.classList.add('header-link');

                // Agregar enlace al contenedor de enlaces adicionales
                const additionalLinksContainer = document.getElementById('additional-links');
                additionalLinksContainer.appendChild(abmPreguntasLink);
            }else {
                if(data.rol === 'Administrador'){
                    const abmPreguntasLink = document.createElement('a');
                    abmPreguntasLink.href = '/admin/list/';
                    abmPreguntasLink.innerHTML = '<span class="material-symbols-outlined">analytics</span>';
                    abmPreguntasLink.classList.add('header-link');

                    // Agregar enlace al contenedor de enlaces adicionales
                    const additionalLinksContainer = document.getElementById('additional-links');
                    additionalLinksContainer.appendChild(abmPreguntasLink);
                }
            }

            if (data.rol === 'Editor' && anchoNavegador>700) { // Comparar con el string 'Editor'
                // Generar enlace para ABM de preguntas
                const abmPreguntasLink = document.createElement('a');
                abmPreguntasLink.href = '/editor/list/';
                abmPreguntasLink.textContent = 'Editar preguntas';
                abmPreguntasLink.classList.add('header-link');

                // Agregar enlace al contenedor de enlaces adicionales
                const additionalLinksContainer = document.getElementById('additional-links');
                additionalLinksContainer.appendChild(abmPreguntasLink);
            }else {
                if(data.rol === 'Editor'){
                    const abmPreguntasLink = document.createElement('a');
                    abmPreguntasLink.href = '/editor/list/';
                    abmPreguntasLink.innerHTML = '<span class="material-symbols-sharp">edit</span>';
                    abmPreguntasLink.classList.add('header-link');

                    const additionalLinksContainer = document.getElementById('additional-links');
                    additionalLinksContainer.appendChild(abmPreguntasLink);
                }


            }

            if (data.logueado && anchoNavegador>700) {
                const logoutLink = document.createElement('a');
                logoutLink.href = '/login/logout';
                logoutLink.innerHTML = '<div class="text-4xl"><i class="fa-solid fa-right-from-bracket"></i></div>';
                logoutLink.classList.add('header-link');

                const sugerirLink = document.createElement('a');
                sugerirLink.href = '/sugerir/list';
                sugerirLink.innerHTML = 'Fabrica de Preguntas';
                sugerirLink.classList.add('header-link');

                const rankingLink = document.createElement('a');
                rankingLink.href = '/lobby/ranking';
                rankingLink.innerHTML = 'Ranking';
                rankingLink.classList.add('header-link');

                const historialLink = document.createElement('a');
                historialLink.href = '/lobby/historial';
                historialLink.innerHTML = 'Historial';
                historialLink.classList.add('header-link');

                const additionalLinksContainer = document.getElementById('additional-links');
                additionalLinksContainer.appendChild(sugerirLink);
                additionalLinksContainer.appendChild(rankingLink);
                additionalLinksContainer.appendChild(historialLink);
                additionalLinksContainer.appendChild(logoutLink);
            }else {
                const logoutLink = document.createElement('a');
                logoutLink.href = '/login/logout';
                logoutLink.innerHTML = '<div class="text-2xl"><i class="fa-solid fa-right-from-bracket"></i></div>';
                logoutLink.classList.add('header-link');
                const sugerirLink = document.createElement('a');
                sugerirLink.href = '/sugerir/list';
                sugerirLink.innerHTML = '<span class="material-symbols-outlined">factory</span>';
                sugerirLink.classList.add('header-link');

                const rankingLink = document.createElement('a');
                rankingLink.href = '/lobby/ranking';
                rankingLink.innerHTML = '<span class="material-symbols-sharp">rewarded_ads</span>';
                rankingLink.classList.add('header-link');

                const historialLink = document.createElement('a');
                historialLink.href = '/lobby/historial';
                historialLink.innerHTML = '<span class="material-symbols-sharp">calendar_month</span>';
                historialLink.classList.add('header-link');

                const additionalLinksContainer = document.getElementById('additional-links');
                additionalLinksContainer.appendChild(sugerirLink);
                additionalLinksContainer.appendChild(rankingLink);
                additionalLinksContainer.appendChild(historialLink);
                additionalLinksContainer.appendChild(logoutLink);
            }

        })
        .catch(error => {
            console.error('Error al obtener datos del usuario:', error);
        });
});