const sidebar = document.querySelector(".sidebar");
const sideBarToggler = document.querySelector(".sidebar-toggler");

//collapsed state
sideBarToggler.addEventListener("click", () => {
  sidebar.classList.toggle("collapsed");
});