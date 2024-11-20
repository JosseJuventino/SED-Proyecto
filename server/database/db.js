// db.js
require("dotenv").config();
const { Pool } = require("pg");

const pool = new Pool({
  user: process.env.DB_USER,
  host: process.env.DB_HOST,
  database: process.env.DB_NAME,
  password: process.env.DB_PASS,
  port: process.env.DB_PORT,
});

// Probar la conexión
pool.connect((err, client, release) => {
  if (err) {
    return "Error al conectar a la base de datos:", err.stack;
  }
  release();
});

module.exports = pool;
