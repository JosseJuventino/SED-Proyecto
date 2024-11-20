const { jwtVerify } = require("jose");

const SECRET_KEY = new TextEncoder().encode(process.env.SECRET_KEY);

const authController = {
  verifyToken: async (req, res) => {
    try {
      const authHeader = req.headers["authorization"];

      // Verificar si no hay encabezado de autorización
      if (!authHeader) {
        res.writeHead(401, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({
            success: false,
            message: "No se proporcionó el encabezado Authorization",
          })
        );
        return;
      }

      const parts = authHeader.split(" ");
      if (parts.length !== 2 || parts[0] !== "Bearer") {
        res.writeHead(401, { "Content-Type": "application/json" });
        res.end(
          JSON.stringify({
            success: false,
            message:
              "Formato inválido del encabezado Authorization. Se esperaba 'Bearer <token>'",
          })
        );
        return;
      }

      const token = parts[1];

      // Intentar verificar el token
      const { payload } = await jwtVerify(token, SECRET_KEY);

      // Si la verificación es exitosa
      res.writeHead(200, { "Content-Type": "application/json" });
      res.end(
        JSON.stringify({
          success: true,
          message: "Token válido",
          payload, // Opcional: información contenida en el token
        })
      );
    } catch (error) {
      // Si ocurre algún error en la verificación del token
      let errorMessage = "Token inválido o expirado";

      if (error.code === "ERR_JWT_EXPIRED") {
        errorMessage = "El token ha expirado";
      } else if (error.code === "ERR_JWT_SIGNATURE_VERIFICATION_FAILED") {
        errorMessage = "La firma del token es inválida";
      }

      res.writeHead(401, { "Content-Type": "application/json" });
      res.end(
        JSON.stringify({
          success: false,
          message: errorMessage,
          error: error.message, // Detalle del error para depuración
        })
      );
    }
  },
};

module.exports = authController;
