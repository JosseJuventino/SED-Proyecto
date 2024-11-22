<?php session_start(); ?>

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

                                    <!-- Mostrar errores generales (si existen) -->
                                    <?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
                <div class="bg-red-500 text-white p-3 rounded-lg mb-4">
                    <ul>
                        <?php foreach ($_SESSION['errors'] as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php unset($_SESSION['errors']); ?>
            <?php endif; ?>

            <!-- Mostrar errores de la contraseña (si existen) -->
            <?php if (isset($_SESSION['password_errors']) && !empty($_SESSION['password_errors'])): ?>
                <div class="text-red-500 p-3 rounded-lg mb-4 w-full">
                    <ul>
                        <?php foreach ($_SESSION['password_errors'] as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php unset($_SESSION['password_errors']); ?>
            <?php endif; ?>
            
            <form class="flex flex-col z-10 items-center my-5 gap-5 w-full max-w-xs" method="POST" action="registerHandler.php">
                <input
                    type="text"
                    class="bg-gray-900 px-5 py-2 outline-none rounded-lg w-full"
                    placeholder="Nombre"
                    name="nombreUsuario"
                    value = "<?php echo $_SESSION['nombreUsuario'] ?? '' ?>"
                    required
                />
                <input
                    type="text"
                    class="bg-gray-900 px-5 py-2 outline-none rounded-lg w-full"
                    placeholder="Apellido"
                    name="apellidoUsuario"
                    value = "<?php echo $_SESSION['apellidoUsuario'] ?? '' ?>"
                    required
                />
                <input
                    type="text"
                    class="bg-gray-900 px-5 py-2 outline-none rounded-lg w-full"
                    placeholder="Nombre de usuario"
                    name="userName"
                    value = "<?php echo $_SESSION['userName'] ?? '' ?>"
                    required
                />
                <!-- Input para Correo -->
                <input
                    type="email"
                    class="bg-gray-900 px-5 py-2 outline-none rounded-lg w-full"
                    placeholder="Correo"
                    name="email"
                    value = "<?php echo $_SESSION['email'] ?? '' ?>"
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

                <p class="gap-2 flex flex-row">¿Ya tienes una cuenta?
                    <a href="../index.php" class="text-blue-700">Inicia sesión</a>
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

<?php 
    // Limpiar los valores de la sesión
    unset($_SESSION['nombreUsuario']);
    unset($_SESSION['apellidoUsuario']);
    unset($_SESSION['userName']);
    unset($_SESSION['email']);
?>

