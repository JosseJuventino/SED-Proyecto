// Valida si el ID es un número entero válido
const isValidNumericId = (id) => {
  return Number.isInteger(Number(id)) && Number(id) > 0;
};

// Valida si el texto solo contiene letras y espacios
const isValidText = (text) => {
  const textRegex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;
  return textRegex.test(text);
};

// Valida si una fecha tiene un formato correcto (ISO 8601: YYYY-MM-DD)
const isValidDate = (date) => {
  const dateRegex = /^\d{4}-\d{2}-\d{2}$/;
  return dateRegex.test(date) && !isNaN(new Date(date).getTime());
};

// Valida si la puntuación es un número entero no negativo
const isValidScore = (score) => {
  return Number.isInteger(Number(score)) && Number(score) >= 0;
};

// Exportar los validadores
module.exports = {
  isValidNumericId,
  isValidText,
  isValidDate,
  isValidScore,
};
