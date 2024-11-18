<header class="flex flex-row sm:flex-row justify-between items-center my-5">
        <div>
            <h1 class="text-2xl">BetApp</h1>
        </div>

        <!-- Navigation -->
        <nav id="navMenu" class="fixed z-10 inset-0 bg-gray-950 p-5 transform -translate-x-full transition-transform ease-in-out duration-500 sm:duration-700 sm:flex sm:relative sm:translate-x-0 sm:p-0 sm:bg-transparent">
            <button id="closeNav" class="absolute top-0 right-0 p-5 text-2xl sm:hidden">
                ✖
            </button>
            <div class="flex flex-col items-center gap-5 sm:flex-row mt-10 sm:mt-0 text-xl">
                <a href="/app/dashboard/page.php" class="hover:text-white font-bold">Inicio</a>
                <a href="/app/dashboard/bets/page.php" class="hover:text-white font-bold">Gestionar apuestas</a>
                <a href="/app/dashboard/teams/page.php" class="hover:text-white font-bold">Equipos</a>
                <div class="bg-gray-900 py-2 px-10 gap-2 rounded-lg flex flex-row items-center">
                    <span class="material-icons">$ </span>
                    <span id="userPoints">10</span>
                </div>
                <div class="relative">
                    <div id="dropdownToggle" class="bg-gray-900 px-4 w-48 py-2 rounded-lg flex flex-row items-center justify-between gap-3 cursor-pointer">
                        <span id="userName">Jose</span>
                        ▼
                    </div>
                    <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-48 rounded-md shadow-lg z-20">
                        <button id="logoutBtn" class="block w-full px-4 font-bold text-white py-2 text-left rounded-lg bg-red-600 transition-all duration-500">
                            Cerrar sesión
                        </button>
                    </div>
                </div>
            </div>
        </nav>
        <button id="openNav" class="sm:hidden">
            ☰
        </button>
        <script>
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

        </script>
</header>


