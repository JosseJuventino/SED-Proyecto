<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="../public/css/tailwind.css">
</head>
<body class="bg-black text-white h-screen flex justify-center items-center">
    <main class="flex flex-col justify-center h-screen">
        <div class="flex flex-col justify-center items-center">
            <h1 class="text-2xl z-10">BetApp Register</h1>
            <form class="flex flex-col z-10 items-center my-5 gap-5 w-full max-w-md" method="POST" action="your-register-endpoint.php">
                <input
                    type="text"
                    class="bg-gray-900 px-5 py-2 outline-none rounded-lg w-full"
                    placeholder="Nombre"
                    name="nombreUsuario"
                    required
                />
                <input
                    type="text"
                    class="bg-gray-900 px-5 py-2 outline-none rounded-lg w-full"
                    placeholder="Apellido"
                    name="apellidoUsuario"
                    required
                />
                <input
                    type="text"
                    class="bg-gray-900 px-5 py-2 outline-none rounded-lg w-full"
                    placeholder="Nombre de usuario"
                    name="userName"
                    required
                />
                <!-- Input para Correo -->
                <input
                    type="email"
                    class="bg-gray-900 px-5 py-2 outline-none rounded-lg w-full"
                    placeholder="Correo"
                    name="email"
                    required
                />
                <div class="relative w-full">
                    <input
                        id="password"
                        type="password"
                        class="bg-gray-900 px-5 py-2 outline-none rounded-lg w-full"
                        placeholder="Contraseña"
                        name="clave"
                        required
                    />
                    <button
                        id="togglePassword"
                        type="button"
                        class="absolute inset-y-0 right-3 flex items-center"
                    >
                        <img id="eyeIcon" src="../public/images/eye.svg" alt="Mostrar contraseña" class="h-6 w-6">
                    </button>
                </div>
                <!-- Enlace para volver a iniciar sesión -->
                <p class="gap-2 flex flex-row text-sm mt-4">
                    ¿Ya tienes una cuenta?
                    <a href="../index.php" class="text-blue-700 hover:underline">Inicia sesión</a>
                </p>
                <button class="bg-gray-900 px-5 py-2 rounded-lg w-full" type="submit">Registrar</button>
            </form>

            <div class="absolute opacity-15 bottom-0">
                <img src="../public/images/background.png" alt="Background" />
            </div>
        </div>
    </main>
    <script src="../public/js/showPassword.js"></script>
</body>
</html>
