// server/routes/partido.route.js
const partidoController = require("../controllers/partido.controller");
const authMiddleware = require("../middlewares/auth.middleware");

const partidoRoutes = async (req, res) => {
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
  if (req.url === "/partido" && req.method === "GET") {
    await applyAuthMiddleware(partidoController.getAll);
  } else if (req.url.match(/^\/partido\/\d+$/) && req.method === "GET") {
    const id = req.url.split("/")[2];
    req.params = { id };
    await applyAuthMiddleware(partidoController.getById);
  } else if (req.url === "/partido" && req.method === "POST") {
    await applyAuthMiddleware(partidoController.create);
  } else if (req.url.match(/^\/partido\/\d+$/) && req.method === "PUT") {
    const id = req.url.split("/")[2];
    req.params = { id };
    await applyAuthMiddleware(partidoController.update);
  } else if (req.url.match(/^\/partido\/\d+$/) && req.method === "DELETE") {
    const id = req.url.split("/")[2];
    req.params = { id };
    await applyAuthMiddleware(partidoController.delete);
  } else {
    // Ruta no encontrada
    res.writeHead(404, { "Content-Type": "application/json" });
    res.end(
      JSON.stringify({
        success: false,
        message: "Error",
      })
    );
  }
};

module.exports = partidoRoutes;
