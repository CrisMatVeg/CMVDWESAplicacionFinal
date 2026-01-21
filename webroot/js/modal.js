document.addEventListener("DOMContentLoaded", function () {
  // Seleccionamos los elementos
  const btnAbrirNasa = document.getElementById("btnabrirmodal");
  const btnCerrarNasa = document.getElementById("btncerrarmodal");
  const modalnasa = document.querySelector(".modal.mnasa");
  const btnAbrirPerro = document.getElementById("btnabrirmodalperro");
  const btnCerrarPerro = document.getElementById("btncerrarmodalperro");
  const modalperro = document.querySelector(".modal.mperro");

  // Abrir modal nasa
  btnAbrirNasa.addEventListener("click", function (e) {
    e.preventDefault(); // Evita que el enlace haga scroll
    modalnasa.style.display = "block";
  });

  // Cerrar modal nasa
  btnCerrarNasa.addEventListener("click", function (e) {
    e.preventDefault();
    modalnasa.style.display = "none";
  });

  // También cerrar modal nasa si se hace clic fuera del contenido del modal
  window.addEventListener("click", function (e) {
    if (e.target === modalnasa) {
      modalnasa.style.display = "none";
    }
  });

  // Abrir modal perro
  btnAbrirPerro.addEventListener("click", function (e) {
    e.preventDefault(); // Evita que el enlace haga scroll
    modalperro.style.display = "block";
  });

  // Cerrar modal perro
  btnCerrarPerro.addEventListener("click", function (e) {
    e.preventDefault();
    modalperro.style.display = "none";
  });

  // También cerrar modal perro si se hace clic fuera del contenido del modal
  window.addEventListener("click", function (e) {
    if (e.target === modalperro) {
      modalperro.style.display = "none";
    }
  });
});
