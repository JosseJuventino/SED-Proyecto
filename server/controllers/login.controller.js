const usuariosModel = require("../models/usuarios.model");
const bcrypt = require("bcrypt");
const { SignJWT } = require("jose");

const SECRET_KEY = process.env.SECRET_KEY;

const loginController = {
  login: async (req, res) => {
    let body = "";
    req.on("data", (chunk) => {
      body += chunk.toString();
    });

    req.on("end", async () => {
      try {
        if (!body) {
          res.writeHead(400, { "Content-Type": "application/json" });
          res.end(JSON.stringify({ error: "Cuerpo de la solicitud vacío" }));
          return;
        }

        const { email, password } = JSON.parse(body);

        if (!email || !password) {
          res.writeHead(400, { "Content-Type": "application/json" });
          res.end(
            JSON.stringify({ error: "Email y contraseña son requeridos" })
          );
          return;
        }

        // Buscar al usuario por email
        const user = await usuariosModel.getByEmail(email);
        console.log("Usuario encontrado");

        if (!user) {
          res.writeHead(401, { "Content-Type": "application/json" });
          res.end(JSON.stringify({ error: "Credenciales inválidas" }));
          return;
        }

        if (!user.clave) {
          console.error("La contraseña del usuario está vacía");
          res.writeHead(500, { "Content-Type": "application/json" });
          res.end(JSON.stringify({ error: "Error en el servidor" }));
          return;
        }

        // Verificar la contraseña con bcrypt
        const isValidPassword = await bcrypt.compare(password, user.clave);

        if (!isValidPassword) {
          res.writeHead(401, { "Content-Type": "application/json" });
          res.end(JSON.stringify({ error: "Credenciales inválidas" }));
          return;
        }

        // Generar JWT
        const jwt = await new SignJWT({ id: user.idusuario })
          .setProtectedHeader({ alg: "HS256" })
          .setExpirationTime("10m")
          .sign(Buffer.from(SECRET_KEY, "utf-8"));

        res.writeHead(200, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({
            token: jwt,
            user: { id: user.idusuario },
          })
        );
      } catch (error) {
        console.error("Error en el controlador de login:");
        res.writeHead(500, { "Content-Type": "application/json" });
        res.end(JSON.stringify({ error: "Error en el servidor" }));
      }
    });

    req.on("error", (err) => {
      console.error("Error en la solicitud:");
      res.writeHead(500, { "Content-Type": "application/json" });
      res.end(JSON.stringify({ error: "Error en la solicitud" }));
    });
  },
};

module.exports = loginController;
