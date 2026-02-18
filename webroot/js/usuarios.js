/**
 * Token API para autenticar las llamadas a los servicios web.
 * @type {string}
 */
const tokenAPI =
  "04cddc393e711ca78e65a6b72f18d6051f6d6809feeb540de28625f2ce9ea05b";

/**
 * Inicializa la página al cargarla.
 * Recupera la búsqueda guardada en localStorage y configura el input de descripción.
 * Asocia el evento "input" para filtrar usuarios en tiempo real.
 */
window.onload = function () {
  const descripcionInput = document.getElementById("descripcion");

  const busquedaGuardada =
    sessionStorage.getItem("busquedaUsuarios") ?? "";

  descripcionInput.value = busquedaGuardada;

  cargarUsuarios(busquedaGuardada);

  descripcionInput.addEventListener("input", function () {
    const valor = descripcionInput.value.trim();
    sessionStorage.setItem("busquedaUsuarios", valor);
    cargarUsuarios(valor);
  });
};

function formatearFecha(fechaISO) {
  const fecha = new Date(fechaISO);
  const pad = (n) => n.toString().padStart(2, "0");
  const dia = pad(fecha.getDate());
  const mes = pad(fecha.getMonth() + 1);
  const anio = fecha.getFullYear();
  const hora = pad(fecha.getHours());
  const min = pad(fecha.getMinutes());
  const seg = pad(fecha.getSeconds());
  return `${dia}/${mes}/${anio} ${hora}:${min}:${seg}`;
}

/**
 * Carga la lista de usuarios desde la API y la muestra en la tabla.
 * @param {string} descripcion Filtro opcional por descripción
 */
async function cargarUsuarios(descripcion = "") {
  const cuerpoTabla = document.querySelector("#tablaUsuarios tbody");
  cuerpoTabla.innerHTML = "";

  try {
    let url = `./api/wsBuscarUsuariosPorDescripcion.php?token=${tokenAPI}`;

    if (descripcion) {
      url += `&descripcion=${encodeURIComponent(descripcion)}`;
    }

    const response = await fetch(url);

    if (!response.ok) {
      throw new Error("Error HTTP: " + response.status);
    }

    const listaUsuarios = await response.json();

    if (Array.isArray(listaUsuarios) && listaUsuarios.length > 0) {
      listaUsuarios.forEach((usuario) => {
        const fila = document.createElement("tr");

        function crearCelda(texto) {
          const td = document.createElement("td");
          td.textContent = texto ?? "";
          fila.appendChild(td);
        }

        const fechaUltimaConexion = usuario.fechaHoraUltimaConexion
          ? formatearFecha(usuario.fechaHoraUltimaConexion)
          : "";

        crearCelda(usuario.codUsuario);
        crearCelda(usuario.descUsuario);
        crearCelda(usuario.numConexiones);
        crearCelda(fechaUltimaConexion);
        crearCelda(usuario.perfil);

        // Celda de acciones
        const tdAcciones = document.createElement("td");

        // Botón consultar
        const btnConsultar = document.createElement("button");
        btnConsultar.className = "opcionUsuario";
        btnConsultar.type = "button";
        btnConsultar.innerHTML =
          '<i class="fa-solid fa-eye"></i>';
        btnConsultar.addEventListener("click", () => {
          consultarUsuario(usuario.codUsuario);
        });

        // Botón borrar
        const btnBorrar = document.createElement("button");
        btnBorrar.className = "opcionUsuario";
        btnBorrar.type = "button";
        btnBorrar.innerHTML =
          '<i class="fa-solid fa-trash"></i>';
        btnBorrar.addEventListener("click", () => {
          borrarUsuario(usuario.codUsuario);
        });

        tdAcciones.appendChild(btnConsultar);
        tdAcciones.appendChild(btnBorrar);

        fila.appendChild(tdAcciones);
        cuerpoTabla.appendChild(fila);
      });
    } else {
      const fila = document.createElement("tr");
      const td = document.createElement("td");
      td.colSpan = 6;
      td.textContent = "No hay resultados que mostrar";
      fila.appendChild(td);
      cuerpoTabla.appendChild(fila);
    }
  } catch (error) {
    console.error("Error al cargar usuarios:", error);

    const fila = document.createElement("tr");
    const td = document.createElement("td");
    td.colSpan = 6;
    td.textContent = "Error al conectar con el servidor";
    fila.appendChild(td);
    cuerpoTabla.appendChild(fila);
  }
}

/**
 * Consulta un usuario específico y muestra la información en un modal.
 * @param {string} codUsuario Código del usuario a consultar
 */
function consultarUsuario(codUsuario) {
  fetch(`./api/wsConsultarUsuario.php?token=${tokenAPI}`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ codUsuario: codUsuario }),
  })
    .then((response) => response.json())
    .then((usuario) => {
      if (usuario.error) {
        alert(usuario.error);
        return;
      }
      let fechaUltimaConexion = usuario.fechaHoraUltimaConexion
            ? formatearFecha(usuario.fechaHoraUltimaConexion)
            : "";
      const contenido = `
       <h2>Información del Usuario</h2>
       <p><strong>Usuario:</strong> ${usuario.codUsuario}</p>
       <p><strong>Descripción:</strong> ${usuario.descUsuario}</p>
       <p><strong>Nº Conexiones:</strong> ${usuario.numConexiones}</p>
       <p><strong>Última conexión:</strong> ${
        fechaUltimaConexion ?? "Nunca"
       }</p>
       <p><strong>Perfil:</strong> ${usuario.perfil}</p>
     `;

      document.getElementById("contenidoModal").innerHTML = contenido;
      document.getElementById(
        "accionesModal"
      ).innerHTML = `<button onclick="cerrarModal()" class="btn primary">Cerrar</button>`;

      abrirModal();
    })
    .catch((error) => console.error("Error al consultar usuario:", error));
}

/**
 * Muestra un modal de confirmación para borrar un usuario.
 * @param {string} codUsuario Código del usuario a eliminar
 */
function borrarUsuario(codUsuario) {
  const contenido = `
       <h3>Eliminar Usuario</h3>
       <p>Para confirmar escribe <strong>SI</strong></p>
       <input type="text" id="confirmacionInput">
       <div id="errorConfirmacion" style="color:red;"></div>
   `;

  const acciones = `
       <button onclick="confirmarBorrado('${codUsuario}')" class="btn primary">Eliminar</button>
       <button onclick="cerrarModal()" class="btn secondary">Cancelar</button>
   `;

  document.getElementById("contenidoModal").innerHTML = contenido;
  document.getElementById("accionesModal").innerHTML = acciones;
  abrirModal();
}

/**
 * Confirma el borrado de un usuario verificando la confirmación del input.
 * @param {string} codUsuario Código del usuario a eliminar
 */
function confirmarBorrado(codUsuario) {
  const confirmacion = document.getElementById("confirmacionInput").value;

  fetch(`./api/wsBorrarUsuario.php?token=${tokenAPI}`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      codUsuario: codUsuario,
      confirmacion: confirmacion,
    }),
  })
    .then((res) => {
      if (!res.ok) throw new Error("Error HTTP: " + res.status);
      return res.json();
    })
    .then((resultado) => {
      if (!resultado.exito) {
        if (resultado.errores && resultado.errores.confirmacion) {
          document.getElementById("errorConfirmacion").innerText =
            resultado.errores.confirmacion;
        }
      } else {
        cerrarModal();
        document.getElementById("errorConfirmacion").innerText = "";
        const descripcionActual = document
          .getElementById("descripcion")
          .value.trim();
        cargarUsuarios(descripcionActual);
      }
    })
    .catch((error) => console.error("Error en borrado:", error));
}

/**
 * Abre el modal y bloquea el scroll de la página.
 */
function abrirModal() {
  document.getElementById("overlayModal").style.display = "flex";
  document.body.style.overflow = "hidden"; // Bloquea scroll
}

/**
 * Cierra el modal y restaura el scroll de la página.
 */
function cerrarModal() {
  document.getElementById("overlayModal").style.display = "none";
  document.body.style.overflow = "auto"; // Restaura scroll
}
