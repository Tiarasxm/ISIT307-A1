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
    <title>Quiz Game</title>
</head>
<body>
    <div class="container center-align">
        <h1>Welcome to the Quiz Game</h1>
        
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
        
        <div class="nav-links">
            <a href="leaderboard.php">View Leaderboard</a>
        </div>
    </div>
</body>
</html>
