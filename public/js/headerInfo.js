window.addEventListener('load', () => {
    fetch('/user/getUserData')
        .then(response => response.json())
        .then(data => {
            console.log(data.rol);

            console.log(data.rol === 'Administrador');
            if (data.rol === 'Administrador' ) {
                let administrador = document.getElementById('estadisticas');
                let administrador_lg = document.getElementById('estadisticas-lg');
                console.log(administrador.href)
                administrador.classList.remove("hidden");
                administrador.classList.add("flex");
                administrador_lg.classList.remove("hidden");
                administrador_lg.classList.remove("flex");
                let rol = document.getElementById('rol');
                let rol_lg = document.getElementById('rol-lg');
                rol_lg.classList.remove("hidden");
                rol_lg.classList.remove("flex");
                rol.classList.remove("hidden");
                rol.classList.add("flex");
            }

            if (data.rol === 'Editor') { // Comparar con el string 'Editor'
                let editor = document.getElementById('editor');
                let editor_lg = document.getElementById('editor-lg');
                editor.classList.remove('hidden');
                editor.classList.add('flex');
                editor_lg.classList.remove('hidden');
                editor_lg.classList.add('flex');

                let administrador = document.getElementById('estadisticas');
                let administrador_lg = document.getElementById('estadisticas-lg');
                console.log(administrador.value)
                administrador.classList.remove("flex");
                administrador.classList.add("hidden");
                administrador_lg.classList.remove("flex");
                administrador_lg.classList.add("hidden");

                let rol = document.getElementById('rol');
                let rol_lg = document.getElementById('rol-lg');
                rol.classList.remove("flex");
                rol.classList.add("hidden");
                rol_lg.classList.remove("flex");
                rol_lg.classList.add("hidden");
            }

        })
        .catch(error => {
            console.error('Error al obtener datos del usuario:', error);
        });
});