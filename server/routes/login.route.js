const loginController = require("../controllers/login.controller");

const loginRoutes = (req, res) => {
  if (req.url === "/login" && req.method === "POST") {
    loginController.login(req, res);
  } else {
    res.writeHead(404, { "Content-Type": "application/json" });
    res.end(JSON.stringify({ error: "Ruta no encontrada" }));
  }
};

module.exports = loginRoutes;
