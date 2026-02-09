<?php
require_once "includes/functions.php";
startSession();

// Check if user is logged in
if (!isset($_SESSION['nickname'])) {
    header('Location: index.php');
    exit;
}

$nickname = $_SESSION['nickname'];
$currentGamePoints = $_SESSION['total_pts'] ?? 0;
$quizCount = $_SESSION['quiz_count'] ?? 0;

// Update leaderboard before destroying session
updateLeaderboard($nickname, $currentGamePoints);

// Get cumulative score from all games (previous + current)
$cumulativePoints = getPlayerCumulativeScore($nickname);

// Store data for display before destroying session
$displayData = [
    'nickname' => $nickname,
    'current_game_points' => $currentGamePoints,
    'cumulative_points' => $cumulativePoints,
    'quiz_count' => $quizCount
];

session_destroy();
?>

<html>
<head>
    <link rel="stylesheet" href="css/style.css">
    <title>The World Around Us - Game Over</title>
</head>
<body>
    <div class="container center-align">
        <h1>Thank You for Playing!</h1>
        
        <div class="final-score">
            <h2>Final Statistics</h2>
            <p>Nickname: <strong><?= htmlspecialchars($displayData['nickname']) ?></strong></p>
            <p>Current Game Points: <strong><?= $displayData['current_game_points'] ?></strong></p>
            <p>Overall Points (All Games): <strong><?= $displayData['cumulative_points'] ?></strong></p>
            <p>Quizzes Completed (This Game): <strong><?= $displayData['quiz_count'] ?></strong></p>
            <?php if ($displayData['quiz_count'] > 0): ?>
            <p>Average Score per Quiz: <strong><?= round($displayData['current_game_points'] / $displayData['quiz_count'], 1) ?></strong></p>
            <?php endif; ?>
        </div>
        
        <div class="game-over-actions">
            <h3>Start a New Game</h3>
            
            <form method="post" action="index.php">
                <div class="form-group">
                    <label for="nickname">Enter your nickname:</label>
                    <input type="text" id="nickname" name="nickname" required>
                </div>
                
                <div class="form-group">
                    <label>Select a topic:</label>
                    <div class="radio-group">
                        <label class="radio-label">
                            <input type="radio" name="topic" value="animals" required>
                            <span>Animals</span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="topic" value="environment">
                            <span>Environment</span>
                        </label>
                    </div>
                </div>
                
                <button type="submit" class="btn">Start New Game</button>
            </form>
            
            <div class="action-buttons" style="margin-top: 20px;">
                <a href="leaderboard.php" class="btn">View Leaderboard</a>
            </div>
        </div>
        
        <div class="farewell-message">
            <p>Your score has been saved to the leaderboard. Thanks for playing!</p>
        </div>
    </div>
</body>
</html>
