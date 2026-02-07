<?php
require_once "functions.php";
startSession();

updateLeaderboard($_SESSION['nickname'], $_SESSION['total_pts']);

$nickname = $_SESSION['nickname'];
$points = $_SESSION['total_pts'];

session_destroy();
?>

<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Game Over</title>
</head>
<body>
    <h1>Thank You for Playing!</h1>
    <div class="container center-align">
    <p>Nickname: <strong><?= htmlspecialchars($nickname) ?></strong></p>
    <p>Total Points: <strong><?= $points ?></strong></p>
    <hr>
    <form method="post" action="index.php">
        <p><input type="text" name="nickname" placeholder="Enter nickname" required></p>
        <p><label><input type="radio" name="topic" value="animals" required> Animals</label>
        <label><input type="radio" name="topic" value="environment"> Environment</label></p>

        <button type="submit"> Start Game </button>
    </form>
    </div>
</body>
</html>
