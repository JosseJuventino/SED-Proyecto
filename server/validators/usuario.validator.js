// Valida si el email tiene un formato correcto
const isValidEmail = (email) => {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailRegex.test(email);
};

// Valida si el texto solo contiene letras y espacios
const isValidText = (text) => {
  const textRegex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;
  return textRegex.test(text);
};

// Valida si el DUI tiene el formato correcto (Ejemplo: 00000000-0)
const isValidDUI = (dui) => {
  const duiRegex = /^\d{8}-\d{1}$/;
  return duiRegex.test(dui);
};

// Valida si el ID es un número entero válido
const isValidNumericId = (id) => {
  return Number.isInteger(Number(id)) && Number(id) > 0;
};

// Exportar los validadores
module.exports = {
  isValidEmail,
  isValidText,
  isValidDUI,
  isValidNumericId,
};
