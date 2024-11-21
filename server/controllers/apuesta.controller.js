const apuestasModel = require("../models/apuesta.model");
const parseBody = require("../utils/parseBody");
const {
  isValidNumericId,
  isValidAmount,
} = require("../validators/apuesta.validator");

const apuestasController = {
  getAll: async (req, res) => {
    try {
      const apuestas = await apuestasModel.getAll();
      if (!res.headersSent) {
        res.writeHead(200, { "Content-Type": "application/json" });
        res.end(JSON.stringify(apuestas));
      }
    } catch (error) {
      "Error al obtener las apuestas:", error;
      if (!res.headersSent) {
        res.writeHead(500, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({
            success: false,
            error: "Error al obtener las apuestas",
          })
        );
      }
    }
  },

  getById: async (req, res) => {
    const id = req.params.id;

    if (!isValidNumericId(id)) {
      res.writeHead(400, { "Content-Type": "application/json" });
      res.end(JSON.stringify({ success: false, error: "ID inválido" }));
      return;
    }

    try {
      const apuesta = await apuestasModel.getById(id);
      if (!apuesta) {
        res.writeHead(404, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({ success: false, error: "Apuesta no encontrada" })
        );
        return;
      }

      res.writeHead(200, { "Content-Type": "application/json" });
      res.end(JSON.stringify(apuesta));
    } catch (error) {
      "Error al obtener la apuesta:", error;
      res.writeHead(500, { "Content-Type": "application/json" });
      res.end(
        JSON.stringify({
          success: false,
          error: "Error al obtener la apuesta",
        })
      );
    }
  },

  create: async (req, res) => {
    try {
      const apuesta = await parseBody(req);

      if (!apuesta.idUsuario || !isValidNumericId(apuesta.idUsuario)) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({ success: false, error: "Usuario ID inválido" })
        );
        return;
      }

      if (!apuesta.idPartido || !isValidNumericId(apuesta.idPartido)) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({ success: false, error: "Partido ID inválido" })
        );
        return;
      }

      if (
        !apuesta.cantidadApostada ||
        !isValidAmount(apuesta.cantidadApostada)
      ) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({ success: false, error: "Monto apostado inválido" })
        );
        return;
      }

      if (
        apuesta.idEstadoApuesta &&
        ![1, 2, 3, 4].includes(apuesta.idEstadoApuesta)
      ) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({
            success: false,
            error: "Estado de apuesta inválido",
          })
        );
        return;
      }

      await apuestasModel.create(apuesta);
      res.writeHead(201, { "Content-Type": "application/json" });
      res.end(
        JSON.stringify({
          success: true,
          message: "Apuesta creada correctamente",
        })
      );
    } catch (error) {
      "Error al crear la apuesta:", error;
      res.writeHead(500, { "Content-Type": "application/json" });
      res.end(
        JSON.stringify({
          success: false,
          error: "Error al crear la apuesta",
        })
      );
    }
  },

  update: async (req, res) => {
    const id = req.params.id;

    if (!isValidNumericId(id)) {
      res.writeHead(400, { "Content-Type": "application/json" });
      res.end(JSON.stringify({ success: false, error: "ID inválido" }));
      return;
    }

    try {
      const apuesta = await parseBody(req);

      if (apuesta.idUsuario && !isValidNumericId(apuesta.idUsuario)) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({ success: false, error: "Usuario ID inválido" })
        );
        return;
      }

      if (apuesta.idPartido && !isValidNumericId(apuesta.idPartido)) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({ success: false, error: "Partido ID inválido" })
        );
        return;
      }

      if (
        apuesta.cantidadApostada &&
        !isValidAmount(apuesta.cantidadApostada)
      ) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({ success: false, error: "Monto apostado inválido" })
        );
        return;
      }

      if (
        apuesta.idEstadoApuesta &&
        ![1, 2, 3, 4].includes(apuesta.idEstadoApuesta)
      ) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({
            success: false,
            error: "Estado de apuesta inválido",
          })
        );
        return;
      }

      const updated = await apuestasModel.update(id, apuesta);
      if (!updated) {
        res.writeHead(404, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({ success: false, error: "Apuesta no encontrada" })
        );
        return;
      }

      res.writeHead(200, { "Content-Type": "application/json" });
      res.end(
        JSON.stringify({
          success: true,
          message: "Apuesta actualizada correctamente",
        })
      );
    } catch (error) {
      "Error al actualizar la apuesta:", error;
      res.writeHead(500, { "Content-Type": "application/json" });
      res.end(
        JSON.stringify({
          success: false,
          error: "Error al actualizar la apuesta",
        })
      );
    }
  },

  delete: async (req, res) => {
    const id = req.params.id;

    if (!isValidNumericId(id)) {
      res.writeHead(400, { "Content-Type": "application/json" });
      res.end(JSON.stringify({ success: false, error: "ID inválido" }));
      return;
    }

    try {
      const deleted = await apuestasModel.delete(id);
      if (!deleted) {
        res.writeHead(404, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({ success: false, error: "Apuesta no encontrada" })
        );
        return;
      }

      res.writeHead(200, { "Content-Type": "application/json" });
      res.end(
        JSON.stringify({
          success: true,
          message: "Apuesta eliminada correctamente",
        })
      );
    } catch (error) {
      "Error al eliminar la apuesta:", error;
      res.writeHead(500, { "Content-Type": "application/json" });
      res.end(
        JSON.stringify({
          success: false,
          error: "Error al eliminar la apuesta",
        })
      );
    }
  },
};

module.exports = apuestasController;
