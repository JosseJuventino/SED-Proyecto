const usuariosModel = require("../models/usuarios.model");
const bcrypt = require("bcrypt");
const {
  isValidEmail,
  isValidText,
  isValidDUI,
} = require("../validators/usuario.validator");
const parseBody = require("../utils/parseBody");

const usuariosController = {
  getAll: async (req, res) => {
    try {
      const usuarios = await usuariosModel.getAll();
      if (!res.headersSent) {
        res.writeHead(200, { "Content-Type": "application/json" });
        res.end(JSON.stringify(usuarios));
      }
    } catch (error) {
      "Error al obtener usuarios:", error;
      if (!res.headersSent) {
        res.writeHead(500, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({ success: false, error: "Error al obtener usuarios" })
        );
      }
    }
  },

  getById: async (req, res) => {
    const id = req.params.id;

    if (!id) {
      if (!res.headersSent) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(JSON.stringify({ success: false, error: "ID inválido" }));
      }
      return;
    }

    try {
      const usuario = await usuariosModel.getById(id);
      if (!usuario) {
        if (!res.headersSent) {
          res.writeHead(404, { "Content-Type": "application/json" });
          res.end(
            JSON.stringify({ success: false, error: "Usuario no encontrado" })
          );
        }
        return;
      }
      if (!res.headersSent) {
        res.writeHead(200, { "Content-Type": "application/json" });
        res.end(JSON.stringify(usuario));
      }
    } catch (error) {
      "Error al obtener usuario:", error;
      if (!res.headersSent) {
        res.writeHead(500, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({ success: false, error: "Error al obtener usuario" })
        );
      }
    }
  },

  create: async (req, res) => {
    try {
      const usuario = await parseBody(req);

      if (!usuario.email || !isValidEmail(usuario.email)) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(JSON.stringify({ success: false, error: "Email inválido" }));
        return;
      }

      if (!usuario.clave) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({ success: false, error: "Contraseña inválida" })
        );
        return;
      }

      if (!usuario.nombreUsuario || !isValidText(usuario.nombreUsuario)) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(JSON.stringify({ success: false, error: "Nombre inválido" }));
        return;
      }

      if (usuario.dui && !isValidDUI(usuario.dui)) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(JSON.stringify({ success: false, error: "DUI inválido" }));
        return;
      }

      usuario.clave = await bcrypt.hash(usuario.clave, 10);
      await usuariosModel.create(usuario);

      res.writeHead(201, { "Content-Type": "application/json" });
      res.end(
        JSON.stringify({
          success: true,
          message: "Usuario creado correctamente",
        })
      );
    } catch (error) {
      "Error al crear usuario:", error;
      res.writeHead(500, { "Content-Type": "application/json" });
      res.end(
        JSON.stringify({ success: false, error: "Error al crear usuario" })
      );
    }
  },

  update: async (req, res) => {
    const id = req.params.id;

    if (!id) {
      res.writeHead(400, { "Content-Type": "application/json" });
      res.end(JSON.stringify({ success: false, error: "ID inválido" }));
      return;
    }

    try {
      const usuario = await parseBody(req);

      if (usuario.email && !isValidEmail(usuario.email)) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(JSON.stringify({ success: false, error: "Email inválido" }));
        return;
      }

      if (!usuario.clave) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({ success: false, error: "Contraseña inválida" })
        );
        return;
      }

      if (usuario.nombreUsuario && !isValidText(usuario.nombreUsuario)) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(JSON.stringify({ success: false, error: "Nombre inválido" }));
        return;
      }

      if (usuario.dui && !isValidDUI(usuario.dui)) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(JSON.stringify({ success: false, error: "DUI inválido" }));
        return;
      }

      if (usuario.clave) {
        usuario.clave = await bcrypt.hash(usuario.clave, 10);
      }

      const updated = await usuariosModel.update(id, usuario);
      if (!updated) {
        res.writeHead(404, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({ success: false, error: "Usuario no encontrado" })
        );
        return;
      }

      res.writeHead(200, { "Content-Type": "application/json" });
      res.end(
        JSON.stringify({
          success: true,
          message: "Usuario actualizado correctamente",
        })
      );
    } catch (error) {
      "Error al actualizar usuario:", error;
      res.writeHead(500, { "Content-Type": "application/json" });
      res.end(
        JSON.stringify({ success: false, error: "Error al actualizar usuario" })
      );
    }
  },

  delete: async (req, res) => {
    const id = req.params.id;

    if (!id) {
      res.writeHead(400, { "Content-Type": "application/json" });
      res.end(JSON.stringify({ success: false, error: "ID inválido" }));
      return;
    }

    try {
      const deleted = await usuariosModel.delete(id);
      if (!deleted) {
        res.writeHead(404, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({ success: false, error: "Usuario no encontrado" })
        );
        return;
      }

      res.writeHead(200, { "Content-Type": "application/json" });
      res.end(
        JSON.stringify({
          success: true,
          message: "Usuario eliminado correctamente",
        })
      );
    } catch (error) {
      "Error al eliminar usuario:", error;
      res.writeHead(500, { "Content-Type": "application/json" });
      res.end(
        JSON.stringify({ success: false, error: "Error al eliminar usuario" })
      );
    }
  },
};

module.exports = usuariosController;
