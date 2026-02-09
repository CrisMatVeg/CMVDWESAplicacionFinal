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
  let tokenAPI = '38641cd2ecbb2fb866b28f2e104e94101e150a820f6201ae39c8e48c5c17f918';

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
  fetch("./api/wsConsultarUsuario.php", {
    method: "POST",
    body: JSON.stringify({ codUsuario: codUsuario }),
  }).then(() => window.location.reload());
}

function borrarUsuario(codUsuario) {
  fetch("./api/wsBorrarUsuario.php", {
    method: "POST",
    body: JSON.stringify({ codUsuario: codUsuario }),
  }).then(() => window.location.reload());
}
