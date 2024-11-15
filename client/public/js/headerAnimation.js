document.addEventListener("DOMContentLoaded", () => {
  const navMenu = document.getElementById("navMenu");
  const openNav = document.getElementById("openNav");
  const closeNav = document.getElementById("closeNav");
  const dropdownToggle = document.getElementById("dropdownToggle");
  const dropdownMenu = document.getElementById("dropdownMenu");
  const logoutBtn = document.getElementById("logoutBtn");

  openNav.addEventListener("click", () => {
    navMenu.classList.remove("-translate-x-full");
  });

  closeNav.addEventListener("click", () => {
    navMenu.classList.add("-translate-x-full");
  });

  dropdownToggle.addEventListener("click", () => {
    dropdownMenu.classList.toggle("hidden");
  });

  logoutBtn.addEventListener("click", () => {
    alert("Sesión cerrada correctamente");
    window.location.href = "/";
  });
});
