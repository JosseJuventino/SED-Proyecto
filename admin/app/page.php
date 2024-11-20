<?php
session_start();

$pages = [
    'dashboard' => 'pages/dashboard.php',
    'matches'   => 'pages/matches.php',
    'users'     => 'pages/users.php',
    'teams'     => 'pages/teams.php',
    'bets'      => 'pages/bets.php',
    '404'       => 'pages/404.php' // Ruta del archivo 404
];

$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);
$currentPage = $page && array_key_exists($page, $pages) ? $page : '404';

$pageToInclude = array_key_exists($currentPage, $pages) && file_exists($pages[$currentPage])
    ? $pages[$currentPage]
    : $pages['404'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $currentPage === '404' ? '404 Not Found' : 'BetApp Admin'; ?></title>
    <link rel="stylesheet" href="../public/css/tailwind.css">
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self'; style-src 'self' 'unsafe-inline'; img-src 'self' data:;">
</head>
<body class="bg-background text-foreground">
    <?php if ($currentPage === '404'): ?>
        <?php include './pages/404.php'; ?>
    <?php else: ?>
        <div class="flex min-h-screen">
            <?php include '../components/Sidebar.php'; ?>

            <main class="flex-1 p-8">
                <?php include $pageToInclude; ?>
            </main>
        </div>
    <?php endif; ?>
</body>
</html>
