const pool = require("../database/db");

const partidoModel = {
  // Obtener todos los partidos
  getAll: async () => {
    const query = `SELECT * FROM get_all_partidos();`;
    const result = await pool.query(query);
    return result.rows;
  },

  // Obtener un partido por ID
  getById: async (id) => {
    const query = `SELECT * FROM get_partido_by_id($1);`;
    const result = await pool.query(query, [id]);
    return result.rows[0];
  },

  // Crear un nuevo partido
  create: async (userId, partido) => {
    const query = `SELECT * FROM create_partido($1, $2, $3, $4, $5, $6);`;
    const values = [
      userId, // Agregar userId como primer parámetro
      partido.fechaPartido,
      partido.marcadorLocal,
      partido.marcadorVisitante,
      partido.idEquipoLocal,
      partido.idEquipoVisitante,
    ];
    const result = await pool.query(query, values);
    return result.rows[0];
  },

  // Actualizar un partido
  update: async (userId, id, partido) => {
    const query = `SELECT * FROM update_partido($1, $2, $3, $4, $5, $6, $7);`;
    const values = [
      userId, // Agregar userId como primer parámetro
      id,
      partido.fechaPartido,
      partido.marcadorLocal,
      partido.marcadorVisitante,
      partido.idEquipoLocal,
      partido.idEquipoVisitante,
    ];
    const result = await pool.query(query, values);
    return result.rows[0];
  },

  // Eliminar un partido
  delete: async (userId, partidoId) => {
    const query = `SELECT * FROM delete_partido($1, $2);`;
    const result = await pool.query(query, [userId, partidoId]);
    return result.rows[0];
  },
};

module.exports = partidoModel;
