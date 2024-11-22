const http = require("http");
const mainRouter = require("./routes/main.router");

require("dotenv").config();

const server = http.createServer(mainRouter);

server.listen(process.env.PORT, () => {
  console.log(`Bienvenido a la API`);
});
