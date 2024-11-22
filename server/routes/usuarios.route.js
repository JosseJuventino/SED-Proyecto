const usuariosController = require("../controllers/usuarios.controller");
const authMiddleware = require("../middlewares/auth.middleware");

const usuariosRoutes = async (req, res) => {
  // Función para aplicar el middleware de autenticación
  const applyAuthMiddleware = async (handler) => {
    const isAuthenticated = await authMiddleware(req, res);
    if (!isAuthenticated) {
      return; // Si no pasa la autenticación, detener la ejecución
    }
    await handler(req, res); // Ejecutar el controlador si pasa la autenticación
  };

  // Rutas y métodos HTTP
  if (req.url === "/usuarios" && req.method === "GET") {
    await applyAuthMiddleware((req, res) =>
      usuariosController.getAll(req, res)
    );
  } else if (req.url.match(/^\/usuarios\/\d+$/) && req.method === "GET") {
    const id = req.url.split("/")[2];
    req.params = { id };
    await applyAuthMiddleware((req, res) =>
      usuariosController.getById(req, res)
    );
  } else if (req.url === "/usuarios" && req.method === "POST") {
    // Ruta pública, no requiere autenticación
    await usuariosController.create(req, res);
  } else if (req.url.match(/^\/usuarios\/\d+$/) && req.method === "PUT") {
    const id = req.url.split("/")[2];
    req.params = { id };
    await applyAuthMiddleware((req, res) =>
      usuariosController.update(req, res)
    );
  } else if (req.url.match(/^\/usuarios\/\d+$/) && req.method === "DELETE") {
    const id = req.url.split("/")[2];
    req.params = { id };
    await applyAuthMiddleware((req, res) =>
      usuariosController.delete(req, res)
    );
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

module.exports = usuariosRoutes;
