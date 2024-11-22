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
      console.error("Error al obtener partidos:");
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
      console.error("Error al obtener el partido:");
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

  // En tu controlador (partido.controller.js)
  create: async (req, res) => {
    try {
      // Analizar el cuerpo de la solicitud para obtener userId y los datos del partido
      const body = await parseBody(req);
      const userId = body.userId; // Asegúrate de que el userId esté en el cuerpo de la solicitud
      const partido = {
        fechaPartido: body.fechaPartido,
        marcadorLocal: body.marcadorLocal,
        marcadorVisitante: body.marcadorVisitante,
        idEquipoLocal: body.idEquipoLocal,
        idEquipoVisitante: body.idEquipoVisitante,
      };

      // Validaciones
      if (!userId || !isValidNumericId(userId)) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({ success: false, error: "ID de usuario inválido" })
        );
        return;
      }
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

      // Llamar al modelo para crear el partido
      await partidoModel.create(userId, partido);
      res.writeHead(201, { "Content-Type": "application/json" });
      res.end(
        JSON.stringify({
          success: true,
          message: "Partido creado correctamente",
        })
      );
    } catch (error) {
      console.error("Error al crear el partido:"); // Asegúrate de imprimir el error
      if (!res.headersSent) {
        res.writeHead(500, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({ success: false, error: "Error al crear el partido" })
        );
      }
    }
  },

  // En tu controlador (partido.controller.js)
  update: async (req, res) => {
    const id = req.params.id;

    if (!isValidNumericId(id)) {
      res.writeHead(400, { "Content-Type": "application/json" });
      res.end(JSON.stringify({ success: false, error: "ID inválido" }));
      return;
    }

    try {
      // Analizar el cuerpo de la solicitud para obtener userId y los datos del partido
      const body = await parseBody(req);
      const userId = body.userId; // Asegúrate de que el userId esté en el cuerpo de la solicitud
      const partido = {
        fechaPartido: body.fechaPartido,
        marcadorLocal: body.marcadorLocal,
        marcadorVisitante: body.marcadorVisitante,
        idEquipoLocal: body.idEquipoLocal,
        idEquipoVisitante: body.idEquipoVisitante,
      };

      // Validaciones
      if (!userId || !isValidNumericId(userId)) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({ success: false, error: "ID de usuario inválido" })
        );
        return;
      }
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

      // Llamar al modelo para actualizar el partido
      const updated = await partidoModel.update(userId, id, partido);
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
      console.error("Error al actualizar el partido:"); // Asegúrate de imprimir el error
      if (!res.headersSent) {
        res.writeHead(500, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({
            success: false,
            error: "Error al actualizar el partido",
          })
        );
      }
    }
  },

  delete: async (req, res) => {
    const partidoId = req.params.id;

    // Validar que el ID del partido sea válido
    if (!isValidNumericId(partidoId)) {
      res.writeHead(400, { "Content-Type": "application/json" });
      res.end(
        JSON.stringify({ success: false, error: "ID de partido inválido" })
      );
      return;
    }

    try {
      // Analizar el cuerpo de la solicitud para obtener el userId
      const body = await parseBody(req);
      const userId = body.userId;

      // Validar que el userId sea válido
      if (!userId || !isValidNumericId(userId)) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({ success: false, error: "ID de usuario inválido" })
        );
        return;
      }

      // Llamar al modelo para eliminar el partido
      const deleted = await partidoModel.delete(userId, partidoId);
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
      console.error("Error al eliminar el partido:"); // Registro del error
      if (!res.headersSent) {
        res.writeHead(500, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({
            success: false,
            error: "Error al eliminar el partido",
          })
        );
      }
    }
  },
};

module.exports = partidoController;
