<?php
require_once "includes/functions.php";
startSession();

// Check if user is logged in and quiz data exists
if (!isset($_SESSION['nickname']) || !isset($_SESSION['quiz_questions'])) {
    header('Location: index.php');
    exit;
}

$nickname = $_SESSION['nickname'];
$topic = $_SESSION['topic'];
$questions = $_SESSION['quiz_questions'];
$userAnswers = $_POST['answers'] ?? [];

$correct = 0;
$incorrect = 0;
$results = [];

// Validate answers
foreach ($questions as $index => $q) {
    $userAnswer = trim($userAnswers[$index] ?? '');
    $correctAnswer = trim($q['answer']);
    
    // Case-insensitive comparison for text answers
    if ($topic === 'animals') {
        $isCorrect = strtolower($userAnswer) === strtolower($correctAnswer);
    } else {
        // For true/false, compare directly
        $isCorrect = strtolower($userAnswer) === strtolower($correctAnswer);
    }
    
    if ($isCorrect) {
        $correct++;
    } else {
        $incorrect++;
    }
    
    $results[] = [
        'question' => $q['question'],
        'user_answer' => $userAnswer,
        'correct_answer' => $correctAnswer,
        'is_correct' => $isCorrect
    ];
}

// Calculate score
$quizScore = calculateScore($correct, $incorrect);

// Update session data
$_SESSION['total_pts'] += $quizScore;
$_SESSION['quiz_count']++;

// Clear quiz questions from session
unset($_SESSION['quiz_questions']);
?>

<html>
<head>
    <link rel="stylesheet" href="css/style.css">
    <title>The World Around Us - Results</title>
</head>
<body>
    <div class="container center-align">
        <h1>Quiz Results</h1>
        <p class="player-info">Player: <?= htmlspecialchars($nickname) ?></p>
        <p class="topic-info">Topic: <?= ucfirst($topic) ?></p>
        
        <div class="score-summary">
            <h2>Your Score</h2>
            <p>Correct Answers: <strong><?= $correct ?></strong></p>
            <p>Incorrect Answers: <strong><?= $incorrect ?></strong></p>
            <p>Quiz Score: <strong><?= $quizScore ?> points</strong></p>
            <p>Total Points: <strong><?= $_SESSION['total_pts'] ?></strong></p>
        </div>
        
        <div class="results-details">
            <h3>Answer Review</h3>
            <?php foreach ($results as $index => $result): ?>
            <div class="result-item <?= $result['is_correct'] ? 'correct' : 'incorrect' ?>">
                <h4>Question <?= $index + 1 ?></h4>
                <p><?= htmlspecialchars($result['question']) ?></p>
                <p>Your answer: <strong><?= htmlspecialchars($result['user_answer'] ?: 'Not answered') ?></strong></p>
                <p>Correct answer: <strong><?= htmlspecialchars($result['correct_answer']) ?></strong></p>
                <p class="result-status"><?= $result['is_correct'] ? '✓ Correct' : '✗ Incorrect' ?></p>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="form-actions">
            <a href="quiz.php" class="btn">Start New Quiz</a>
            <a href="leaderboard.php" class="btn">View Leaderboard</a>
            <a href="exit.php" class="btn">Exit Game</a>
        </div>
    </div>
</body>
</html>
