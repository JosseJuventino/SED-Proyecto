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
      "Error al obtener el equipo:", error;
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
      "Error al obtener el equipo:", error;
      res.writeHead(500, { "Content-Type": "application/json" });
      res.end(
        JSON.stringify({ success: false, error: "Error al obtener el equipo" })
      );
    }
  },

  create: async (req, res) => {
    try {
      const equipo = await parseBody(req);

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

      await equiposModel.create(equipo);
      res.writeHead(201, { "Content-Type": "application/json" });
      res.end(
        JSON.stringify({
          success: true,
          message: "Equipo creado correctamente",
        })
      );
    } catch (error) {
      "Error al crear el equipo:", error;
      res.writeHead(500, { "Content-Type": "application/json" });
      res.end(
        JSON.stringify({ success: false, error: "Error al crear el equipo" })
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
      const equipo = await parseBody(req);

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

      const updatedEquipo = await equiposModel.update(id, equipo);
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
      "Error al actualizar el equipo:", error;
      res.writeHead(500, { "Content-Type": "application/json" });
      res.end(
        JSON.stringify({
          success: false,
          error: "Error al actualizar el equipo",
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
      const deletedEquipo = await equiposModel.delete(id);
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
      "Error al eliminar el equipo:", error;
      res.writeHead(500, { "Content-Type": "application/json" });
      res.end(
        JSON.stringify({ success: false, error: "Error al eliminar el equipo" })
      );
    }
  },
};

module.exports = equiposController;
