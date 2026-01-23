document.addEventListener('DOMContentLoaded', function() {
    const descripcion = document.getElementById('descripcionNasa');

    if (!descripcion) return;
    // Detectar click para expandir/contraer
    descripcion.addEventListener('click', function() {
        if (descripcion.classList.contains('truncate-text')) {
            // Expandir
            descripcion.classList.remove('truncate-text');
        } else {
            // Contraer
            descripcion.classList.add('truncate-text');
        }
    });
});


