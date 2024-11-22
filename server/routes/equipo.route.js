const equipoController = require("../controllers/equipo.controller");
const authMiddleware = require("../middlewares/auth.middleware");

const equipoRoutes = async (req, res) => {

  // Función para aplicar el middleware de autenticación
  const applyAuthMiddleware = async (handler) => {
    try {
      const isAuthenticated = await authMiddleware(req, res);
      if (isAuthenticated) {
        await handler(req, res); // Ejecutar el controlador si pasa la autenticación
      }
    } catch (error) {
      console.error("Error en applyAuthMiddleware:", error);
      if (!res.headersSent) {
        res.statusCode = 500;
        res.setHeader("Content-Type", "application/json");
        res.end(JSON.stringify({ error: "Error interno del servidor" }));
      }
    }
  };

  // Rutas y métodos HTTP
  if (req.url === "/equipo" && req.method === "GET") {
    await applyAuthMiddleware((req, res) => equipoController.getAll(req, res));
  } else if (req.url.match(/^\/equipo\/\d+$/) && req.method === "GET") {
    const id = req.url.split("/")[2];
    req.params = { id };
    await applyAuthMiddleware((req, res) => equipoController.getById(req, res));
  } else if (
    req.url.match(/^\/equipo\/nombre\/[a-zA-Z0-9_ ]+$/) &&
    req.method === "GET"
  ) {
    const nombre = req.url.split("/")[3];
    req.params = { nombre };
    await applyAuthMiddleware((req, res) =>
      equipoController.getByName(req, res)
    );
  } else if (req.url === "/equipo" && req.method === "POST") {
    await applyAuthMiddleware((req, res) => equipoController.create(req, res));
  } else if (req.url.match(/^\/equipo\/\d+$/) && req.method === "PUT") {
    const id = req.url.split("/")[2];
    req.params = { id };
    await applyAuthMiddleware((req, res) => equipoController.update(req, res));
  } else if (req.url.match(/^\/equipo\/\d+$/) && req.method === "DELETE") {
    const id = req.url.split("/")[2];
    req.params = { id };
    await applyAuthMiddleware((req, res) => equipoController.delete(req, res));
  } else {
    res.writeHead(404, { "Content-Type": "application/json" });
    res.end(
      JSON.stringify({
        success: false,
        message: "Error",
      })
    );
  }
};

module.exports = equipoRoutes;
