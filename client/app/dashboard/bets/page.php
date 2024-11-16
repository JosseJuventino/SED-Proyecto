<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History</title>
    <link rel="stylesheet" href="../../../public/css/tailwind.css">
</head>
<body class="text-white bg-black">
    <div class="mx-10 my-5">
    <?php include '../../../components/header.php'; ?>

    <main class="flex flex-col lg:flex-row items-start my-5 gap-10">
         <?php include '../../../components/HistoryBets.php'; ?>
         <div class="w-full">
            <?php include '../../../components/MatchTable.php'; ?>
         </div>
         
    </main>
</div>
</body>
</html>