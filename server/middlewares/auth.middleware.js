const { jwtVerify } = require("jose");

// Usa TextEncoder para codificar la clave secreta de manera consistente
const SECRET_KEY = new TextEncoder().encode(process.env.SECRET_KEY);

const authMiddleware = async (req, res) => {
  const authHeader = req.headers["authorization"];

  if (!authHeader) {
    res.writeHead(404, { "Content-Type": "application/json" });
    res.end(
      JSON.stringify({
        success: false,
        message: "Error",
      })
    );
    return false; // Detener la ejecución
  }

  const parts = authHeader.split(" ");
  if (parts.length !== 2 || parts[0] !== "Bearer") {
    res.writeHead(404, { "Content-Type": "application/json" });
    res.end(
      JSON.stringify({
        success: false,
        message: "Error",
      })
    );
    return false; // Detener la ejecución
  }

  const token = parts[1];

  try {
    await jwtVerify(token, SECRET_KEY);
    return true; // Autenticación exitosa
  } catch (error) {
    console.error("Error al verificar el token:", error);

    let message = "Error";
    if (error.code === "ERR_JWT_EXPIRED") {
      message = "Error";
    } else if (error.code === "ERR_JWT_SIGNATURE_VERIFICATION_FAILED") {
      message = "Error";
    }

    res.writeHead(404, { "Content-Type": "application/json" });
    res.end(
      JSON.stringify({
        success: false,
        message,
      })
    );
    return false; // Detener la ejecución
  }
};

module.exports = authMiddleware;
