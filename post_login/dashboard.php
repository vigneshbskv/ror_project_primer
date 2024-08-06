<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../prelogin/login.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashboard</title>

</head>

<body>
    <?php
    include('header.php');
    ?>
    <h1 class="m-4 text-center">Hello, <?php echo htmlspecialchars($_SESSION["username"]); ?></h1>

</body>

</html>