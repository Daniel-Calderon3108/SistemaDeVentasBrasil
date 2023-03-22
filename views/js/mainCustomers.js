$(document).ready(function () {
  // Obtén todos los botones de tab y su contenido
  const tabButtons = document.querySelectorAll(".tab_buttons .tab_button");
  const tabContents = document.querySelectorAll(".tab_content div");

  // Agrega un controlador de eventos a cada botón de tab
  tabButtons.forEach((button, index) => {
    button.addEventListener("click", () => {
      // Elimina la clase 'active' de todos los botones y contenido de tab
      tabButtons.forEach((btn) => {
        btn.classList.remove("active");
      });
      tabContents.forEach((content) => {
        content.classList.remove("active");
      });

      // Agrega la clase 'active' al botón y contenido de tab correspondiente
      button.classList.add("active");
      tabContents[index].classList.add("active");
    });
  });
});
