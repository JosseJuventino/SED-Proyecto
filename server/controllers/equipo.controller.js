const equiposModel = require("../models/equipo.model");
const parseBody = require("../utils/parseBody");
const {
  isValidNumericId,
  isValidNombreEquipo,
  isValidRepresentante,
} = require("../validators/equipo.validator");

const equiposController = {
  getAll: async (req, res) => {
    try {
      const equipos = await equiposModel.getAll();
      if (!res.headersSent) {
        res.writeHead(200, { "Content-Type": "application/json" });
        res.end(JSON.stringify(equipos));
      }
    } catch (error) {
      if (!res.headersSent) {
        res.writeHead(500, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({
            success: false,
            error: "Error al obtener los equipos",
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
      const equipo = await equiposModel.getById(id);
      if (!equipo) {
        res.writeHead(404, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({ success: false, error: "Equipo no encontrado" })
        );
        return;
      }

      res.writeHead(200, { "Content-Type": "application/json" });
      res.end(JSON.stringify(equipo));
    } catch (error) {
      console.error("Error al obtener el equipo:");
      res.writeHead(500, { "Content-Type": "application/json" });
      res.end(
        JSON.stringify({ success: false, error: "Error al obtener el equipo" })
      );
    }
  },

  getByName: async (req, res) => {
    const { nombre } = req.params;

    try {
      const equipo = await equiposModel.getByName(nombre);
      if (!equipo) {
        res.writeHead(404, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({ success: false, error: "Equipo no encontrado" })
        );
        return;
      }

      res.writeHead(200, { "Content-Type": "application/json" });
      res.end(JSON.stringify(equipo));
    } catch (error) {
      console.error("Error al obtener el equipo:");
      res.writeHead(500, { "Content-Type": "application/json" });
      res.end(
        JSON.stringify({ success: false, error: "Error al obtener el equipo" })
      );
    }
  },

  create: async (req, res) => {
    try {
      const equipo = await parseBody(req);

      // Asegúrate de que el userId esté presente en el cuerpo de la solicitud
      if (!equipo.userId) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({
            success: false,
            error: "El user es obligatorio",
          })
        );
        return;
      }

      // Validación del nombre del equipo
      if (!equipo.nombreEquipo || !isValidNombreEquipo(equipo.nombreEquipo)) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({
            success: false,
            error: "Nombre del equipo inválido",
          })
        );
        return;
      }

      // Validación del representante del equipo
      if (
        !equipo.representanteEquipo ||
        !isValidRepresentante(equipo.representanteEquipo)
      ) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({
            success: false,
            error: "Nombre del representante inválido",
          })
        );
        return;
      }

      // Crear el equipo en la base de datos
      await equiposModel.create(equipo);
      res.writeHead(201, { "Content-Type": "application/json" });
      res.end(
        JSON.stringify({
          success: true,
          message: "Equipo creado correctamente",
        })
      );
    } catch (error) {
      console.error("Error al crear el equipo:"); // Asegúrate de imprimir el error
      res.writeHead(500, { "Content-Type": "application/json" });
      res.end(
        JSON.stringify({ success: false, error: "Error al crear el equipo" })
      );
    }
  },

  update: async (req, res) => {
    const id = req.params.id;

    // Validar el ID del equipo
    if (!isValidNumericId(id)) {
      res.writeHead(400, { "Content-Type": "application/json" });
      res.end(JSON.stringify({ success: false, error: "ID inválido" }));
      return;
    }

    try {
      // Analiza el cuerpo de la solicitud
      const equipo = await parseBody(req);

      const userId = equipo.userId; // Asegúrate de que el userId esté en el cuerpo de la solicitud

      // Validar el userId
      if (!userId) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({ success: false, error: "El userId es obligatorio" })
        );
        return;
      }

      // Validación del nombre del equipo
      if (equipo.nombreEquipo && !isValidNombreEquipo(equipo.nombreEquipo)) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({
            success: false,
            error: "Nombre del equipo inválido",
          })
        );
        return;
      }

      // Validación del representante del equipo
      if (
        equipo.representanteEquipo &&
        !isValidRepresentante(equipo.representanteEquipo)
      ) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({
            success: false,
            error: "Nombre del representante inválido",
          })
        );
        return;
      }

      // Actualizar el equipo en la base de datos
      const updatedEquipo = await equiposModel.update(userId, id, equipo);

      if (!updatedEquipo) {
        res.writeHead(404, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({ success: false, error: "Equipo no encontrado" })
        );
        return;
      }

      res.writeHead(200, { "Content-Type": "application/json" });
      res.end(
        JSON.stringify({
          success: true,
          message: "Equipo actualizado correctamente",
        })
      );
    } catch (error) {
      console.error("Error al actualizar el equipo:"); // Asegúrate de imprimir el error
      res.writeHead(500, { "Content-Type": "application/json" });
      res.end(
        JSON.stringify({
          success: false,
          error: "Error al actualizar el equipo",
        })
      );
    }
  },

  // En tu controlador (equipo.controller.js)
  delete: async (req, res) => {
    const equipoId = req.params.id; // ID del equipo a eliminar

    // Validar el ID del equipo
    if (!isValidNumericId(equipoId)) {
      res.writeHead(400, { "Content-Type": "application/json" });
      res.end(JSON.stringify({ success: false, error: "ID inválido" }));
      return;
    }

    try {
      // Analizar el cuerpo de la solicitud para obtener userId
      const body = await parseBody(req);
      const userId = body.userId; // Asegúrate de que el userId esté en el cuerpo de la solicitud

      // Validar el userId
      if (!userId) {
        res.writeHead(400, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({ success: false, error: "El userId es obligatorio" })
        );
        return;
      }

      // Llamar al modelo para eliminar el equipo
      const deletedEquipo = await equiposModel.delete(userId, equipoId);
      if (!deletedEquipo) {
        res.writeHead(404, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({ success: false, error: "Equipo no encontrado" })
        );
        return;
      }

      res.writeHead(200, { "Content-Type": "application/json" });
      res.end(
        JSON.stringify({
          success: true,
          message: "Equipo eliminado correctamente",
        })
      );
    } catch (error) {
      console.error("Error al eliminar el equipo:"); // Asegúrate de imprimir el error
      res.writeHead(500, { "Content-Type": "application/json" });
      res.end(
        JSON.stringify({ success: false, error: "Error al eliminar el equipo" })
      );
    }
  },
};

module.exports = equiposController;
