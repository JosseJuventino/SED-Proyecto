const pool = require("../database/db");

const equiposModel = {
  // Obtener todos los equipos
  getAll: async () => {
    const query = `SELECT * FROM get_all_equipos();`;
    const result = await pool.query(query);
    return result.rows;
  },

  // Obtener un equipo por ID
  getById: async (id) => {
    const query = `SELECT * FROM get_equipo_by_id($1);`;
    const result = await pool.query(query, [id]);
    return result.rows[0];
  },

  // Obtener equipos por nombre
  getByName: async (nombre) => {
    const query = `SELECT * FROM get_equipo_by_name($1);`;
    const result = await pool.query(query, [`%${nombre}%`]);
    return result.rows;
  },

  // Crear un nuevo equipo
  create: async (equipo) => {
    const query = `SELECT * FROM create_equipo($1, $2, $3);`;
    const values = [
      equipo.nombreEquipo,
      equipo.representanteEquipo,
      equipo.fechaFundacion || null, // Pasar null si no hay fecha
    ];
    const result = await pool.query(query, values);
    return result.rows[0];
  },

  // Actualizar un equipo
  update: async (id, equipo) => {
    const query = `SELECT * FROM update_equipo($1, $2, $3, $4);`;
    const values = [
      id,
      equipo.nombreEquipo,
      equipo.representanteEquipo,
      equipo.fechaFundacion || null, // Pasar null si no hay fecha
    ];
    const result = await pool.query(query, values);
    return result.rows[0];
  },

  // Eliminar un equipo
  delete: async (id) => {
    const query = `SELECT * FROM delete_equipo($1);`;
    const result = await pool.query(query, [id]);
    return result.rows[0];
  },
};

module.exports = equiposModel;
