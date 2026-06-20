document.addEventListener("DOMContentLoaded", function () {
  eventListener(); // ejecuta la función eventListener() cuando se carga el documento HTML
  darkMode();
});

function darkMode() {
  // obtenemos un objeto con el valor de true o false se esta en modo oscuro el sistema.

  // const prefiereDarkMode = window.matchMedia("(prefers-color-scheme: dark)");

  // console.log(prefiereDarkMode.matches);

  // evaluamos si el sistema esta en modo oscuro agrega la clase dark mode automaticamente.

  // if (prefiereDarkMode.matches) {
  //   document.body.classList.add("dark-mode");
  // } else {
  //   document.body.classList.remove("dark-mode");
  // }

  // este evento sirve para cambiar el darkmode cuando haya cun cambio en el color del sistema.

  // prefiereDarkMode.addEventListener("change", function () {
  //   if (prefiereDarkMode.matches) {
  //     document.body.classList.add("dark-mode");
  //   } else {
  //     document.body.classList.remove("dark-mode");
  //   }
  // });

  const botonDarkMode = document.querySelector(".dark-mode-boton");
  botonDarkMode.addEventListener("click", function () {
    document.body.classList.toggle("dark-mode"); // le agregamos una clase a <body>
  });
}

// función para obtener el clic de la hamburguesa

function eventListener() {
  const mobileMenu = document.querySelector(".mobile-menu"); // Obtenemos el elemento de la ha,burguesa
  mobileMenu.addEventListener("click", navegacionResponsive); // Cuando detecta el click ejecuta la función navegacionResponsive()
}

// función

function navegacionResponsive() {
  const navegacion = document.querySelector(".navegacion");

  // Forma larga para agregar y quitar una clase con un clic
  /*
  if (navegacion.classList.contains("mostrar")) {
    navegacion.classList.remove("mostrar");
  } else {
    navegacion.classList.add("mostrar");
  }
  */

  // Segunda forma de agregar y quitar una clase
  navegacion.classList.toggle("mostrar");
}
