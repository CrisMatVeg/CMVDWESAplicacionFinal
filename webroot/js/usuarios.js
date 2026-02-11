const tokenAPI = "4db4c99a1258756d97732f80de66485f687b7711070547bff0b2496fa51fa741";
window.onload = function () {
  const descripcionInput = document.getElementById("descripcion");
  // Recuperar búsqueda guardada
  const busquedaGuardada = localStorage.getItem("busquedaUsuarios") ?? "";
  descripcionInput.value = busquedaGuardada;

  cargarUsuarios(busquedaGuardada);

  descripcionInput.addEventListener("input", function () {
    const valor = descripcionInput.value.trim();
    localStorage.setItem("busquedaUsuarios", valor);
    cargarUsuarios(valor);
  });
};

function cargarUsuarios(descripcion = "") {
  let url = `./api/wsBuscarUsuariosPorDescripcion.php?token=${tokenAPI}`;
  if (descripcion) {
    url += `&descripcion=${encodeURIComponent(descripcion)}`;
  }

  fetch(url)
    .then((response) => response.json())
    .then((listaUsuarios) => {
      const cuerpoTabla = document.querySelector("#tablaUsuarios tbody");
      cuerpoTabla.innerHTML = "";
      if (listaUsuarios.length > 0) {
        listaUsuarios.forEach((usuario) => {
          cuerpoTabla.innerHTML += `
            <tr>
            <td>${usuario.codUsuario}</td>
            <td>${usuario.descUsuario}</td>
            <td>${usuario.numConexiones}</td>
            <td>${usuario.fechaHoraUltimaConexion ?? ""}</td>
            <td>${usuario.perfil}</td>
            <td>
                <button onclick="consultarUsuario('${
                  usuario.codUsuario
                }')" class="opcionUsuario" type="button">
                  <i class="fa-solid fa-eye"></i>
                </button>
                <button onclick="borrarUsuario('${
                  usuario.codUsuario
                }')" class="opcionUsuario" type="button">
                  <i class="fa-solid fa-trash"></i>
                </button>
              </td>
            </tr>
          `;
        });
      } else {
        cuerpoTabla.innerHTML = `<td>No hay resultados que mostrar</td>`;
      }
    });
}

function consultarUsuario(codUsuario) {

  fetch(`./api/wsConsultarUsuario.php?token=${tokenAPI}`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ codUsuario: codUsuario })
  })
  .then(response => response.json())
  .then(usuario => {

      if (usuario.error) {
          alert(usuario.error);
          return;
      }

      const contenido = `
          <h2>Información del Usuario</h2>
          <p><strong>Usuario:</strong> ${usuario.codUsuario}</p>
          <p><strong>Descripción:</strong> ${usuario.descUsuario}</p>
          <p><strong>Nº Conexiones:</strong> ${usuario.numConexiones}</p>
          <p><strong>Última conexión:</strong> ${usuario.fechaHoraUltimaConexion ?? "Nunca"}</p>
          <p><strong>Perfil:</strong> ${usuario.perfil}</p>
      `;

      document.getElementById("contenidoModal").innerHTML = contenido;
      document.getElementById("accionesModal").innerHTML =
          `<button onclick="cerrarModal()" class="btn primary">Cerrar</button>`;

      abrirModal();
  });
}

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

function confirmarBorrado(codUsuario) {

  const confirmacion = document.getElementById("confirmacionInput").value;

  fetch(`./api/wsBorrarUsuario.php?token=${tokenAPI}`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      codUsuario: codUsuario,
      confirmacion: confirmacion
    })
  })
  .then(res => {
      if (!res.ok) {
          throw new Error("Error HTTP: " + res.status);
      }
      return res.json();
  })
  .then(resultado => {

      if (!resultado.exito) {

          if (resultado.errores && resultado.errores.confirmacion) {
              document.getElementById("errorConfirmacion").innerText =
                  resultado.errores.confirmacion;
          }

      } else {
          cerrarModal();
          const errorDiv = document.getElementById("errorConfirmacion");
          if (errorDiv) errorDiv.innerText = "";
          const descripcionActual = document.getElementById("descripcion").value.trim();
          cargarUsuarios(descripcionActual);
      }
  })
  .catch(error => {
      console.error("Error en borrado:", error);
  });
}

function abrirModal() {
  document.getElementById("overlayModal").style.display = "flex";
  document.body.style.overflow = "hidden"; // bloquea scroll
}

function cerrarModal() {
  document.getElementById("overlayModal").style.display = "none";
  document.body.style.overflow = "auto"; // restaura scroll
}
