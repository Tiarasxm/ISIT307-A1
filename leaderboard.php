<?php
session_start();
$sort = $_GET['sort'] ?? 'score';
$lines = file("leaderboard.txt", FILE_IGNORE_NEW_LINES);
$players = [];

foreach ($lines as $line) 
    {
        list($name, $score) = explode("|", $line);
        $score = (int)$score;
        $players[] = ["name" => $name, "score" => (int)$score];
    }

if ($sort == "name") 
    {
        usort($players, fn($a, $b) => strcmp($a["name"], $b["name"]));
    } else {
        usort($players, fn($a, $b) => ($b["score"] - $a["score"]));
    }
?>

<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <title>Leaderboard</title>
    </head>
    <body>
        <div class="container center-align">
            <h1>LEADERBOARD</h1>

            <table>
                <tr>
                    <th> Nickname </th>
                    <th> Score </th>
                </tr>
                <?php foreach ($players as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p["name"]) ?></td>
                    <td><?= ($p["score"]) ?></td>
                </tr>
                <?php endforeach; ?>
            </table>

            <a href="?sort=name">Sort by Nickname</a><br>
            <a href="?sort=score">Sort by Score</a>
            <br>
            <a href="exit.php"> Exit </a>
        </div>
    </body>
</html>
