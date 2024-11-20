// Valida si el ID es un número entero válido
const isValidNumericId = (id) => {
  return Number.isInteger(Number(id)) && Number(id) > 0;
};

// Valida si el texto solo contiene letras y espacios
const isValidText = (text) => {
  const textRegex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;
  return textRegex.test(text);
};

// Valida si el nombre del equipo es válido (opcional: longitud mínima/máxima)
const isValidNombreEquipo = (nombre) => {
  return isValidText(nombre) && nombre.length >= 3 && nombre.length <= 50;
};

// Valida si el nombre del representante es válido
const isValidRepresentante = (nombre) => {
  return isValidText(nombre) && nombre.length >= 3 && nombre.length <= 50;
};

// Exportar los validadores
module.exports = {
  isValidNumericId,
  isValidText,
  isValidNombreEquipo,
  isValidRepresentante,
};
