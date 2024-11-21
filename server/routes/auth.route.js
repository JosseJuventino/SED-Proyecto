const authController = require("../controllers/auth.controller");

const authRoutes = async (req, res) => {
  if (req.url === "/auth/verify" && req.method === "GET") {
    await authController.verifyToken(req, res); // Usamos `await` por si hay tareas asíncronas
  } else {
    res.writeHead(404, { "Content-Type": "application/json" });
    res.end(JSON.stringify({ error: "Ruta no encontrada" }));
  }
};

module.exports = authRoutes;
