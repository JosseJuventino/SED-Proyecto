<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/tailwind.css">
</head>
<body class="bg-black text-white h-screen flex justify-center items-center">
        <main className="flex flex-col justify-center h-screen">
            <div class="flex flex-col justify-center items-center">
                <h1 class="text-2xl z-10">BetApp login</h1>
                <form class="flex flex-col z-10 items-center my-5 gap-5" method="POST" action="your-login-endpoint.php">
                    <!-- Input para Usuario -->
                    <input
                        type="text"
                        class="bg-gray-900 px-5 py-2 outline-none rounded-lg"
                        placeholder="Usuario"
                        name="username"
                    />
                    <!-- Input para Contraseña -->
                    <div class="relative w-full">
                        <input
                            type="password"
                            class="bg-gray-900 px-5 py-2 outline-none rounded-lg"
                            placeholder="Contraseña"
                            name="password"
                        />
                        <button
                            type="button"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-700"
                        >
                            <span>Mostrar/Ocultar</span>
                        </button>
                    </div>
                    <!-- Enlace para registro -->
                    <p class="gap-2 flex flex-row">¿No tienes una aún?
                        <a href="/register" class="text-blue-700">Crea una</a>
                    </p>
                    <!-- Botón para enviar -->
                    <button class="bg-gray-900 px-5 py-2 rounded-lg" type="submit">Iniciar sesión</button>
                </form>
                <!-- Imagen de fondo -->
                <div class="absolute opacity-15 bottom-0">
                    <img src="./images/background.png" alt="Background" />
                </div>
            </div>

        </main>
    </div>
</body>
</html>