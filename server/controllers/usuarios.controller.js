const usuariosModel = require("../models/usuarios.model");
const bcrypt = require("bcrypt");
const {
  isValidEmail,
  isValidText,
  isValidDUI,
  isValidNumericId,
} = require("../validators/usuario.validator");
const parseBody = require("../utils/parseBody");

const usuariosController = {
  // Obtener todos los usuarios
  getAll: async (req, res) => {
    try {
      const body = await parseBody(req);
      const userId = body.userId;

      if (!isValidNumericId(userId)) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({ success: false, error: "ID de usuario inválido" })
        );
        return;
      }

      const usuarios = await usuariosModel.getAll(userId);

      res.writeHead(200, { "Content-Type": "application/json" });
      res.end(JSON.stringify(usuarios));
    } catch (error) {
      console.error("Error al obtener usuarios:");
      res.writeHead(500, { "Content-Type": "application/json" });
      res.end(
        JSON.stringify({ success: false, error: "Error al obtener usuarios" })
      );
    }
  },

  // Obtener usuario por ID
  getById: async (req, res) => {
    try {
      const body = await parseBody(req);
      const superadminId = body.superadminId;
      const userId = req.params.id;

      if (!isValidNumericId(superadminId) || !isValidNumericId(userId)) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(JSON.stringify({ success: false, error: "ID inválido" }));
        return;
      }

      const usuario = await usuariosModel.getById(superadminId, userId);

      if (!usuario) {
        res.writeHead(404, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({ success: false, error: "Usuario no encontrado" })
        );
        return;
      }

      res.writeHead(200, { "Content-Type": "application/json" });
      res.end(JSON.stringify(usuario));
    } catch (error) {
      console.error("Error al obtener usuario:");
      res.writeHead(500, { "Content-Type": "application/json" });
      res.end(
        JSON.stringify({ success: false, error: "Error al obtener usuario" })
      );
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
      console.error("Error al crear usuario:");
      res.writeHead(500, { "Content-Type": "application/json" });
      res.end(
        JSON.stringify({ success: false, error: "Error al crear usuario" })
      );
    }
  },

  // Actualizar un usuario
  update: async (req, res) => {
    try {
      // Obtener el cuerpo de la solicitud
      const body = await parseBody(req);

      // Extraer valores del cuerpo
      const superadminId = body.superadminId;
      const userId = req.params.id;

      // Validaciones básicas
      if (!isValidNumericId(superadminId) || !isValidNumericId(userId)) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(JSON.stringify({ success: false, error: "ID inválido" }));
        return;
      }

      if (!isValidEmail(body.email)) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(JSON.stringify({ success: false, error: "Correo inválido" }));
        return;
      }

      if (!body.nombreUsuario || !isValidText(body.nombreUsuario)) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(JSON.stringify({ success: false, error: "Nombre inválido" }));
        return;
      }

      // Llamar al modelo para realizar la actualización
      const updated = await usuariosModel.update(superadminId, userId, body);

      if (!updated) {
        res.writeHead(404, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({ success: false, error: "Usuario no encontrado" })
        );
        return;
      }

      // Responder éxito
      res.writeHead(200, { "Content-Type": "application/json" });
      res.end(
        JSON.stringify({
          success: true,
          message: "Usuario actualizado correctamente",
        })
      );
    } catch (error) {
      console.error("Error al actualizar usuario:");
      res.writeHead(500, { "Content-Type": "application/json" });
      res.end(
        JSON.stringify({ success: false, error: "Error al actualizar usuario" })
      );
    }
  },

  // Eliminar un usuario
  delete: async (req, res) => {
    try {
      const body = await parseBody(req);
      const superadminId = body.superadminId; // ID del superadministrador
      const userId = req.params.id; // ID del usuario a eliminar

      // Validar IDs
      if (!isValidNumericId(superadminId) || !isValidNumericId(userId)) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(JSON.stringify({ success: false, error: "IDs inválidos" }));
        return;
      }

      // Eliminar el usuario
      const deleted = await usuariosModel.delete(superadminId, userId);

      if (!deleted) {
        res.writeHead(404, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({
            success: false,
            error: "Usuario no encontrado o ya eliminado",
          })
        );
        return;
      }

      // Responder éxito
      res.writeHead(200, { "Content-Type": "application/json" });
      res.end(
        JSON.stringify({
          success: true,
          message: "Usuario eliminado correctamente",
        })
      );
    } catch (error) {
      console.error("Error al eliminar usuario");
      res.writeHead(500, { "Content-Type": "application/json" });
      res.end(
        JSON.stringify({
          success: false,
          error: "Error al eliminar usuario",
        })
      );
    }
  },
};

module.exports = usuariosController;
