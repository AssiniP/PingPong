// Obtener referencia al contenedor de contenido
const contentContainer = document.getElementById('content-container');

// Esperar 3 segundos antes de mostrar el contenido
setTimeout(() => {
    contentContainer.classList.remove('hidden');
}, 3000);

console.log("gola")