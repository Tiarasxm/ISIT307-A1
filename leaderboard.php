<?php
require_once "includes/functions.php";
startSession();

$sort = $_GET['sort'] ?? 'score';
$players = getLeaderboard($sort);
?>

<html>
    <head>
        <link rel="stylesheet" href="css/style.css">
        <title>Leaderboard</title>
    </head>
    <body>
        <div class="container center-align">
            <div class="leaderboard-header">
                <h1>LEADERBOARD</h1>
                <div class="filter-dropdown">
                    <button class="dropdown-btn" onclick="toggleDropdown()">Filter By ▼</button>
                    <div id="dropdown" class="dropdown-content">
                        <a href="?sort=score">Score</a>
                        <a href="?sort=name">Nickname</a>
                    </div>
                </div>
            </div>

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

            <a href="exit.php"> Exit </a>
        </div>

        <script>
            function toggleDropdown() {
                document.getElementById("dropdown").classList.toggle("show");
            }

            // Close dropdown when clicking outside
            window.onclick = function(event) {
                if (!event.target.matches('.dropdown-btn')) {
                    var dropdowns = document.getElementsByClassName("dropdown-content");
                    for (var i = 0; i < dropdowns.length; i++) {
                        var openDropdown = dropdowns[i];
                        if (openDropdown.classList.contains('show')) {
                            openDropdown.classList.remove('show');
                        }
                    }
                }
            }
        </script>
    </body>
</html>
