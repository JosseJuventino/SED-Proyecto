const partidoModel = require("../models/partido.model");
const parseBody = require("../utils/parseBody");
const {
  isValidNumericId,
  isValidDate,
  isValidScore,
} = require("../validators/partido.validator");

const partidoController = {
  getAll: async (req, res) => {
    try {
      const partidos = await partidoModel.getAll();
      if (!res.headersSent) {
        res.writeHead(200, { "Content-Type": "application/json" });
        res.end(JSON.stringify(partidos));
      }
    } catch (error) {
      error;
      if (!res.headersSent) {
        res.writeHead(500, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({ success: false, error: "Error al obtener partidos" })
        );
      }
    }
  },

  getById: async (req, res) => {
    const id = req.params.id;

    if (!isValidNumericId(id)) {
      if (!res.headersSent) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(JSON.stringify({ success: false, error: "ID inválido" }));
      }
      return;
    }

    try {
      const partido = await partidoModel.getById(id);
      if (!partido) {
        if (!res.headersSent) {
          res.writeHead(404, { "Content-Type": "application/json" });
          res.end(
            JSON.stringify({ success: false, error: "Partido no encontrado" })
          );
        }
        return;
      }
      if (!res.headersSent) {
        res.writeHead(200, { "Content-Type": "application/json" });
        res.end(JSON.stringify(partido));
      }
    } catch (error) {
      error;
      if (!res.headersSent) {
        res.writeHead(500, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({
            success: false,
            error: "Error al obtener el partido",
          })
        );
      }
    }
  },

  create: async (req, res) => {
    try {
      const partido = await parseBody(req);

      // Validaciones
      if (!partido.idEquipoLocal || !isValidNumericId(partido.idEquipoLocal)) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({
            success: false,
            error: "ID del equipo local inválido",
          })
        );
        return;
      }
      if (
        !partido.idEquipoVisitante ||
        !isValidNumericId(partido.idEquipoVisitante)
      ) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({
            success: false,
            error: "ID del equipo visitante inválido",
          })
        );
        return;
      }
      if (!partido.fechaPartido || !isValidDate(partido.fechaPartido)) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(JSON.stringify({ success: false, error: "Fecha inválida" }));
        return;
      }
      if (
        partido.marcadorLocal !== undefined &&
        !isValidScore(partido.marcadorLocal)
      ) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({ success: false, error: "Marcador local inválido" })
        );
        return;
      }
      if (
        partido.marcadorVisitante !== undefined &&
        !isValidScore(partido.marcadorVisitante)
      ) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({
            success: false,
            error: "Marcador visitante inválido",
          })
        );
        return;
      }

      await partidoModel.create(partido);
      res.writeHead(201, { "Content-Type": "application/json" });
      res.end(
        JSON.stringify({
          success: true,
          message: "Partido creado correctamente",
        })
      );
    } catch (error) {
      error;
      if (!res.headersSent) {
        res.writeHead(500, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({ success: false, error: "Error al crear el partido" })
        );
      }
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
      const partido = await parseBody(req);

      // Validaciones dinámicas
      if (partido.idEquipoLocal && !isValidNumericId(partido.idEquipoLocal)) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({
            success: false,
            error: "ID del equipo local inválido",
          })
        );
        return;
      }
      if (
        partido.idEquipoVisitante &&
        !isValidNumericId(partido.idEquipoVisitante)
      ) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({
            success: false,
            error: "ID del equipo visitante inválido",
          })
        );
        return;
      }
      if (partido.fechaPartido && !isValidDate(partido.fechaPartido)) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(JSON.stringify({ success: false, error: "Fecha inválida" }));
        return;
      }
      if (
        partido.marcadorLocal !== undefined &&
        !isValidScore(partido.marcadorLocal)
      ) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({ success: false, error: "Marcador local inválido" })
        );
        return;
      }
      if (
        partido.marcadorVisitante !== undefined &&
        !isValidScore(partido.marcadorVisitante)
      ) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({
            success: false,
            error: "Marcador visitante inválido",
          })
        );
        return;
      }

      const updated = await partidoModel.update(id, partido);
      if (!updated) {
        res.writeHead(404, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({ success: false, error: "Partido no encontrado" })
        );
        return;
      }

      res.writeHead(200, { "Content-Type": "application/json" });
      res.end(
        JSON.stringify({
          success: true,
          message: "Partido actualizado correctamente",
        })
      );
    } catch (error) {
      error;
      res.writeHead(500, { "Content-Type": "application/json" });
      res.end(
        JSON.stringify({
          success: false,
          error: "Error al actualizar el partido",
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
      const deleted = await partidoModel.delete(id);
      if (!deleted) {
        res.writeHead(404, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({ success: false, error: "Partido no encontrado" })
        );
        return;
      }

      res.writeHead(200, { "Content-Type": "application/json" });
      res.end(
        JSON.stringify({
          success: true,
          message: "Partido eliminado correctamente",
        })
      );
    } catch (error) {
      error;
      res.writeHead(500, { "Content-Type": "application/json" });
      res.end(
        JSON.stringify({
          success: false,
          error: "Error al eliminar el partido",
        })
      );
    }
  },
};

module.exports = partidoController;
