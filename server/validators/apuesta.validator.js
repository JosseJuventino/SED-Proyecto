// Valida si el ID es un número entero válido
const isValidNumericId = (id) => {
  return Number.isInteger(Number(id)) && Number(id) > 0;
};

// Valida si la cantidad apostada es un número positivo
const isValidAmount = (amount) => {
  return !isNaN(amount) && Number(amount) > 0;
};

// Valida si el estado de la apuesta es válido
const isValidBetStatus = (status) => {
  const validStatuses = ["pendiente", "ganada", "perdida, empate"];
  return validStatuses.includes(status);
};

// Exportar los validadores
module.exports = {
  isValidNumericId,
  isValidAmount,
  isValidBetStatus,
};
