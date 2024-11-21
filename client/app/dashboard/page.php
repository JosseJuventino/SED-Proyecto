<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../../public/css/tailwind.css">
</head>

<body class="bg-black text-white mx-10 my-5">
    <?php session_start(); ?>
    <?php include '../../components/header.php'; ?>
    <?php include '../../components/MatchTable.php'; ?>
</body>

</html>