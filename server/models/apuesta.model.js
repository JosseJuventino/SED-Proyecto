const pool = require("../database/db");

const apuestasModel = {
  // Obtener todas las apuestas
  getAll: async () => {
    const query = `SELECT * FROM get_all_apuestas();`;
    const result = await pool.query(query);
    return result.rows;
  },

  // Obtener todas las apuestas de un usuario
  getByUserId: async (userId) => {
    const query = `SELECT * FROM get_apuestas_usuario($1);`;
    const result = await pool.query(query, [userId]);
    return result.rows;
  },

  // Obtener una apuesta por ID
  getById: async (id) => {
    const query = `SELECT * FROM get_apuesta_by_id($1);`;
    const result = await pool.query(query, [id]);
    return result.rows[0];
  },

  // Crear una nueva apuesta
  create: async (apuesta) => {
    const query = `
      SELECT * FROM create_apuesta($1, $2, $3, $4, $5, $6);
    `;
    const values = [
      apuesta.idUsuario,
      apuesta.cantidadApostada,
      apuesta.idEstadoApuesta,
      apuesta.idPartido,
      apuesta.golEquipoLocal,
      apuesta.golEquipoVisitante,
    ];
    const result = await pool.query(query, values);
    return result.rows[0];
  },

  // Actualizar una apuesta
  update: async (id, apuesta) => {
    const query = `
      SELECT * FROM update_apuesta($1, $2, $3, $4, $5, $6, $7);
    `;
    const values = [
      id,
      apuesta.idUsuario || null,
      apuesta.cantidadApostada || null,
      apuesta.idEstadoApuesta || null,
      apuesta.idPartido || null,
      apuesta.golEquipoLocal || null,
      apuesta.golEquipoVisitante || null,
    ];
    const result = await pool.query(query, values);
    return result.rows[0];
  },

  // Eliminar una apuesta
  delete: async (id) => {
    const query = `SELECT * FROM delete_apuesta($1);`;
    const result = await pool.query(query, [id]);
    return result.rows[0];
  },
};

module.exports = apuestasModel;
