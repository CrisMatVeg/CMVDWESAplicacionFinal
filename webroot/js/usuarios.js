window.onload = function () {
  cargarUsuarios();
  const descripcion = document.getElementById("descripcion");
  descripcion.addEventListener("input", function (e) {
    e.preventDefault();
    cargarUsuarios(descripcion.value.trim());
  });
};

function cargarUsuarios(descripcion = "") {
  let url = `./api/wsBuscarUsuariosPorDescripcion.php?token=apikey1234`;
  if (descripcion) {
    url += `&descripcion=${encodeURIComponent(descripcion)}`;
  }

  fetch(url)
    .then((response) => response.json())
    .then((listaUsuarios) => {
      const cuerpoTabla = document.querySelector("#tablaUsuarios tbody");
      cuerpoTabla.innerHTML = "";
      if (listaUsuarios!=[]) {
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
        cuerpoTabla.innerHTML = `<td>No hay resultados que coincidan con la busqueda</td>`;
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
