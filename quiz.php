<?php
require_once "includes/functions.php";
startSession();

// Check if user is logged in
if (!isset($_SESSION['nickname']) || !isset($_SESSION['topic'])) {
    header('Location: index.php');
    exit;
}

$topic = $_SESSION['topic'];
$nickname = $_SESSION['nickname'];

// Load questions based on topic
if ($topic === 'animals') {
    $questions = readQuestions('data/animals.txt');
} else {
    $questions = readQuestions('data/environment.txt');
}

// Get 4 random questions
$quizQuestions = getRandomQuestions($questions, 4);

// Store questions in session for result validation
$_SESSION['quiz_questions'] = $quizQuestions;
?>

<html>
<head>
    <link rel="stylesheet" href="css/style.css">
    <title>The World Around Us - Quiz</title>
</head>
<body>
    <div class="container center-align">
        <h1><?= ucfirst($topic) ?> Quiz</h1>
        <p class="player-info">Player: <?= htmlspecialchars($nickname) ?></p>
        
        <form method="post" action="result.php">
            <?php foreach ($quizQuestions as $index => $q): ?>
            <div class="question-block">
                <h3>Question <?= $index + 1 ?></h3>
                <p class="question-text"><?= htmlspecialchars($q['question']) ?></p>
                
                <?php if ($topic === 'animals'): ?>
                    <!-- Animals: Text input for answer -->
                    <div class="answer-input">
                        <input type="text" name="answers[<?= $index ?>]" 
                               placeholder="Enter your answer" required>
                    </div>
                <?php else: ?>
                    <!-- Environment: True/False radio buttons -->
                    <div class="answer-options">
                        <label class="radio-label">
                            <input type="radio" name="answers[<?= $index ?>]" value="true" required>
                            <span>True</span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="answers[<?= $index ?>]" value="false">
                            <span>False</span>
                        </label>
                    </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
            
            <div class="form-actions">
                <button type="submit" class="btn">Submit Answers</button>
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
        
        <div class="nav-links">
            <a href="leaderboard.php">View Leaderboard</a>
            <a href="exit.php">Exit Game</a>
        </div>
    </div>
</body>
</html>
