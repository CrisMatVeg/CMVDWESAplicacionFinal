document.addEventListener('DOMContentLoaded', function () {
    const tabla = document.getElementById('tablaDepartamentos');
    const paginacion = document.getElementById('paginacion');
    const inputDescripcion = document.getElementById('descripcion');
    const botonBuscar = document.getElementById('enviar');

    let paginaActual = 1;
    const porPagina = 5;
    let todosDepartamentos = [];

    function renderTabla() {
        if (!todosDepartamentos || todosDepartamentos.length === 0) {
            tabla.innerHTML = '<p>No se encontraron departamentos.</p>';
            paginacion.innerHTML = '';
            return;
        }

        const inicio = (paginaActual - 1) * porPagina;
        const fin = inicio + porPagina;
        const paginaDepartamentos = todosDepartamentos.slice(inicio, fin);

        let html = '<table>';
        html += '<tr class="titulotabla"><td>Codigo</td><td>Descripción</td><td>Fecha Creación</td><td>Volumen</td><td>Fecha Baja</td></tr>';
        paginaDepartamentos.forEach(d => {
            html += '<tr>';
            html += `<td>${d.T02_CodDepartamento}</td>`;
            html += `<td>${d.T02_DescDepartamento}</td>`;
            html += `<td>${d.T02_FechaCreacionDepartamento ?? '-'}</td>`;
            html += `<td>${d.T02_VolumenDeNegocio ?? '-'}</td>`;
            html += `<td>${d.T02_FechaBajaDepartamento ?? '-'}</td>`;
            html += '</tr>';
        });
        html += '</table>';
        tabla.innerHTML = html;

        // Paginación
        const totalPaginas = Math.ceil(todosDepartamentos.length / porPagina);
        let pagHtml = '';
        for (let i = 1; i <= totalPaginas; i++) {
            if (i === paginaActual) {
                pagHtml += `<button class="btn paginacion" disabled>${i}</button> `;
            } else {
                pagHtml += `<button class="btn paginacion" onclick="cambiarPagina(${i})">${i}</button> `;
            }
        }
        paginacion.innerHTML = pagHtml;
    }

    window.cambiarPagina = function (pagina) {
        paginaActual = pagina;
        renderTabla();
    }

    function cargarDepartamentos() {
        const descripcion = inputDescripcion.value;
        fetch(`api/ajaxDepartamentos.php?descripcion=${encodeURIComponent(descripcion)}`)
            .then(res => res.json())
            .then(data => {
                todosDepartamentos = data;
                paginaActual = 1;
                renderTabla();
            });
    }

    // Evento buscar
    botonBuscar.addEventListener('click', e => {
        e.preventDefault();
        cargarDepartamentos();
    });

    // Cargar inicialmente
    cargarDepartamentos();
});
