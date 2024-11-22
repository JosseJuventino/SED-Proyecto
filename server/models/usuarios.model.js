const bcrypt = require("bcrypt");
const pool = require("../database/db");

const usuariosModel = {
  // Obtener todos los usuarios
  getAll: async (userId) => {
    const query = `SELECT * FROM get_all_users($1);`;
    const result = await pool.query(query, [userId]);
    return result.rows;
  },

  // Obtener usuario por ID
  getById: async (superadminId, userId) => {
    const query = `SELECT * FROM get_user_by_id($1, $2);`;
    const result = await pool.query(query, [superadminId, userId]);
    return result.rows[0];
  },

  // Crear un nuevo usuario
  create: async (user) => {
    const query = "SELECT * FROM create_user($1, $2, $3, $4, $5, $6, $7, $8)";
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

  // Actualizar un usuario
  update: async (superadminId, userId, user) => {
    // Si se pasa una clave, generamos su hash
    const hashedPassword = user.clave
      ? await bcrypt.hash(user.clave, 10)
      : null;

    const query = `
      SELECT * FROM update_user($1, $2, $3, $4, $5, $6, $7, $8, $9, $10);
    `;
    const values = [
      superadminId,
      userId,
      user.nombreUsuario || null, // Nombre
      user.apellidoUsuario || null, // Apellido
      user.dui || null, // DUI
      user.email || null, // Correo
      user.username || null, // Nombre de usuario
      hashedPassword || null, // Contraseña hasheada
      user.puntos || 0, // Puntos
      user.rol || null, // Rol
    ];

    const result = await pool.query(query, values);
    return result.rows[0]; // Devuelve el resultado del procedimiento almacenado
  },

  delete: async (superadminId, userId) => {
    const query = `SELECT * FROM delete_user($1, $2);`;
    const values = [superadminId, userId];
    const result = await pool.query(query, values);

    return result.rows[0]; // Devuelve los datos del usuario eliminado si tuvo éxito
  },

  // Funciones originales
  getByEmail: async (email) => {
    const query = `SELECT * FROM get_user_by_email($1);`;
    const result = await pool.query(query, [email]);
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
