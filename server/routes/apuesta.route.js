const apuestasController = require("../controllers/apuesta.controller");
const authMiddleware = require("../middlewares/auth.middleware");

const apuestasRoutes = async (req, res) => {
  // Función para aplicar el middleware de autenticación
  const applyAuthMiddleware = async (handler) => {
    try {
      const isAuthenticated = await authMiddleware(req, res);
      if (isAuthenticated) {
        handler(req, res); // Ejecutar el controlador si pasa la autenticación
      }
      // Si no está autenticado, el middleware ya envió la respuesta
    } catch (error) {
      // Manejo de errores inesperados (opcional)
      "Error en applyAuthMiddleware:", error;
      if (!res.headersSent) {
        res.statusCode = 500;
        res.setHeader("Content-Type", "application/json");
        res.end(JSON.stringify({ error: "Error interno del servidor" }));
      }
    }
  };

  // Rutas y métodos HTTP
  if (req.url === "/apuesta" && req.method === "GET") {
    await applyAuthMiddleware(apuestasController.getAll);
  } else if (req.url.match(/^\/apuesta\/\d+$/) && req.method === "GET") {
    const id = req.url.split("/")[2];
    req.params = { id };
    await applyAuthMiddleware(apuestasController.getById);
  } else if (req.url === "/apuesta" && req.method === "POST") {
    await applyAuthMiddleware(apuestasController.create);
  } else if (req.url.match(/^\/apuesta\/\d+$/) && req.method === "PUT") {
    const id = req.url.split("/")[2];
    req.params = { id };
    await applyAuthMiddleware(apuestasController.update);
  } else if (req.url.match(/^\/apuesta\/\d+$/) && req.method === "DELETE") {
    const id = req.url.split("/")[2];
    req.params = { id };
    await applyAuthMiddleware(apuestasController.delete);
  } else {
    // Ruta no encontrada
    res.writeHead(404, { "Content-Type": "application/json" });
    res.end(JSON.stringify({ error: "Ruta no encontrada" }));
  }
};

module.exports = apuestasRoutes;
