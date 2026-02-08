<?php
require_once "includes/functions.php";
startSession();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nickname = trim($_POST['nickname'] ?? '');
    $topic = $_POST['topic'] ?? '';
    
    if (!empty($nickname) && in_array($topic, ['animals', 'environment'])) {
        $_SESSION['nickname'] = $nickname;
        $_SESSION['topic'] = $topic;
        $_SESSION['total_pts'] = $_SESSION['total_pts'] ?? 0;
        $_SESSION['quiz_count'] = $_SESSION['quiz_count'] ?? 0;
        
        header('Location: quiz.php');
        exit;
    }
}
?>

<html>
<head>
    <link rel="stylesheet" href="css/style.css">
    <title>The World Around Us</title>
</head>
<body>
    <div class="container center-align">
        <h1>The World Around Us</h1>
        
        <form method="post" action="">
            <div class="form-group">
                <label for="nickname">Enter your nickname:</label>
                <input type="text" id="nickname" name="nickname" required 
                       value="<?= htmlspecialchars($_POST['nickname'] ?? '') ?>">
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
            
            <button type="submit" class="btn">Start Quiz</button>
        </form>
        
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && (empty($nickname) || !in_array($topic ?? '', ['animals', 'environment']))): ?>
            <p class="error">Please enter a nickname and select a topic.</p>
        <?php endif; ?>
        
        <div class="tutorial-section">
            <h2>How to Play</h2>
            <div class="tutorial-content">
                <div class="tutorial-item">
                    <h4>🎯 Getting Started</h4>
                    <p>Enter your nickname and choose between <strong>Animals</strong> or <strong>Environment</strong> topics.</p>
                </div>
                
                <div class="tutorial-item">
                    <h4>📝 Quiz Format</h4>
                    <p>Each quiz has <strong>4 random questions</strong>. For Animals, type your answer. For Environment, choose True or False.</p>
                </div>
                
                <div class="tutorial-item">
                    <h4>🏆 Scoring</h4>
                    <p>Correct answers: <strong>+2 points</strong><br>Incorrect answers: <strong>-1 point</strong></p>
                </div>
                
                <div class="tutorial-item">
                    <h4>🔄 Multiple Rounds</h4>
                    <p>Play as many quizzes as you want! Your total score accumulates across all games.</p>
                </div>
                
                <div class="tutorial-item">
                    <h4>📊 Leaderboard</h4>
                    <p>Check your ranking on the leaderboard and compete with other players!</p>
                </div>
            </div>
        </div>
        
        <div class="nav-links">
            <a href="leaderboard.php">View Leaderboard</a>
        </div>
    </div>
</body>
</html>
