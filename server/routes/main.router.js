const usuariosRoutes = require("./usuarios.route");
const equipoRoutes = require("./equipo.route");
const partidoRoute = require("./partido.route");
const apuestaRoute = require("./apuesta.route");
const loginRoutes = require("./login.route");
const authRoutes = require("./auth.route"); // Importar authRoutes

const mainRouter = (req, res) => {
  // Configurar cabeceras CORS
  res.setHeader("Access-Control-Allow-Origin", "*");
  res.setHeader(
    "Access-Control-Allow-Methods",
    "GET, POST, PUT, DELETE, OPTIONS"
  );
  res.setHeader("Access-Control-Allow-Headers", "Content-Type, Authorization");

  // Manejar opciones preflight de CORS
  if (req.method === "OPTIONS") {
    res.writeHead(204);
    res.end();
    return;
  }

  // Rutas principales
  if (req.url.startsWith("/usuarios")) {
    usuariosRoutes(req, res);
  } else if (req.url.startsWith("/equipo")) {
    equipoRoutes(req, res);
  } else if (req.url.startsWith("/partido")) {
    partidoRoute(req, res);
  } else if (req.url.startsWith("/apuesta")) {
    apuestaRoute(req, res);
  } else if (req.url.startsWith("/login")) {
    loginRoutes(req, res);
  } else if (req.url.startsWith("/auth")) {
    authRoutes(req, res); // Añadir authRoutes al router principal
  } else {
    // Ruta no encontrada
    res.writeHead(404, { "Content-Type": "application/json" });
    res.end(JSON.stringify({ error: "Ruta no encontrada" }));
  }
};

module.exports = mainRouter;
