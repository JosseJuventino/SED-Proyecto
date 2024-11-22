<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History</title>
    <link rel="stylesheet" href="../../../public/css/tailwind.css">
</head>

<body class="text-white bg-black">
    <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Verificar que el usuario está logueado
    if (!isset($_SESSION['token']) || !isset($_SESSION['user_id'])) {
        error_log('$token: ' . $_SESSION['token'] . ', $user_id: ' . $_SESSION['user_id']);
        header('Location: ../../../index.php');
        exit;
    }
    ?>
    <div class="mx-10 my-5">
        <?php include '../../../components/header.php'; ?>

        <main class="flex flex-col lg:flex-row items-start my-5 gap-10">
            <?php include '../../../components/HistoryBets.php'; ?>
            <div class="w-full">
                <?php include '../../../components/Teams.php'; ?>
            </div>

        </main>
    </div>
</body>

</html>