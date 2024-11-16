// Funcionalidad para mostrar/ocultar contraseña
const togglePasswordButton = document.getElementById("togglePassword");
const passwordInput = document.getElementById("password");
const eyeIcon = document.getElementById("eyeIcon");

togglePasswordButton.addEventListener("click", () => {
  // Cambiar entre tipo texto y contraseña
  const isPassword = passwordInput.type === "password";
  passwordInput.type = isPassword ? "text" : "password";

  // Cambiar el icono
  eyeIcon.src = isPassword
    ? "../../public/images/eye-off.svg"
    : "../../public/images/eye.svg";
  eyeIcon.alt = isPassword ? "Ocultar contraseña" : "Mostrar contraseña";
});
