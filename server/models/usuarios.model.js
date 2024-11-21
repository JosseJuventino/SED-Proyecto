const bcrypt = require("bcrypt");
const pool = require("../database/db");

const usuariosModel = {
  getAll: async () => {
    const query = `SELECT * FROM get_all_users();`;
    const result = await pool.query(query);
    return result.rows;
  },

  getById: async (id) => {
    const query = `SELECT * FROM get_user_by_id($1);`;
    const result = await pool.query(query, [id]);
    return result.rows[0];
  },

  getByEmail: async (email) => {
    const query = `SELECT * FROM get_user_by_email($1);`;
    const result = await pool.query(query, [email]);
    return result.rows[0];
  },

  create: async (user) => {
    const query = `SELECT * FROM create_user($1, $2, $3, $4, $5, $6, $7, $8);`;
    const values = [
      user.nombreUsuario,
      user.apellidoUsuario,
      user.dui,
      user.email,
      user.userName,
      user.clave,
      user.idRol,
      user.puntosUser || 0,
    ];

    const result = await pool.query(query, values);
    return result.rows[0];
  },

  update: async (id, user) => {
    const hashedPassword = user.clave
      ? await bcrypt.hash(user.clave, 10)
      : null;

    const query = `SELECT * FROM update_user($1, $2, $3, $4, $5, $6, $7, $8, $9);`;
    const values = [
      id,
      user.nombreUsuario || null,
      user.apellidoUsuario || null,
      user.dui || null,
      user.email || null,
      user.userName || null,
      hashedPassword || null,
      user.puntosUser || null,
      user.idRol || null,
    ];

    const result = await pool.query(query, values);
    return result.rows[0];
  },

  delete: async (id) => {
    const query = `SELECT * FROM delete_user($1);`;
    const result = await pool.query(query, [id]);
    return result.rows[0];
  },

  verifyPassword: async (email, providedPassword) => {
    const query = `SELECT clave FROM Usuarios WHERE email = $1;`;
    const result = await pool.query(query, [email]);
    if (result.rows.length === 0) return false;

    const { clave: storedHash } = result.rows[0];
    return bcrypt.compare(providedPassword, storedHash);
  },
};

module.exports = usuariosModel;
