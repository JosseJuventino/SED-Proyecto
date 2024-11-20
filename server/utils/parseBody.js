// server/utils/parseBody.js
const parseBody = (req) => {
  return new Promise((resolve, reject) => {
    let body = "";
    req.on("data", (chunk) => {
      body += chunk;
      // Opcional: Limitar el tamaño del cuerpo para evitar ataques de denegación de servicio
      if (body.length > 1e6) {
        // ~1MB
        req.connection.destroy();
        reject(new Error("Cuerpo de solicitud demasiado grande"));
      }
    });
    req.on("end", () => {
      try {
        const parsed = JSON.parse(body);
        resolve(parsed);
      } catch (error) {
        reject(new Error("JSON inválido"));
      }
    });
    req.on("error", (err) => {
      reject(err);
    });
  });
};

module.exports = parseBody;
