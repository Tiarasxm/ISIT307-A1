<?php
/**
 * Start or resume session
 */
function startSession() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
}

/**
 * Read questions from a text file
 * @param string $file Path to the question file
 * @return array Array of questions
 */
function readQuestions($file) {
    $questions = [];
    if (file_exists($file)) {
        $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos($line, '|') !== false) {
                list($question, $answer) = explode('|', $line, 2);
                $questions[] = [
                    'question' => trim($question),
                    'answer' => trim($answer)
                ];
            }
        }
    }
    return $questions;
}

/**
 * Get random questions from the question pool
 * @param array $questions Array of all questions
 * @param int $count Number of questions to select
 * @return array Array of random questions
 */
function getRandomQuestions($questions, $count = 4) {
    if (count($questions) <= $count) {
        return $questions;
    }
    $keys = array_rand($questions, $count);
    $selected = [];
    foreach ($keys as $key) {
        $selected[] = $questions[$key];
    }
    return $selected;
}

/**
 * Calculate quiz score based on correct and incorrect answers
 * @param int $correct Number of correct answers
 * @param int $incorrect Number of incorrect answers
 * @return int Calculated score
 */
function calculateScore($correct, $incorrect) {
    return ($correct * 2) - ($incorrect * 1);
}

/**
 * Update leaderboard with player score
 * @param string $nickname Player nickname
 * @param int $points Total points
 */
function updateLeaderboard($nickname, $points) {
    $leaderboardFile = 'data/leaderboard.txt';
    $players = [];
    
    // Read existing leaderboard
    if (file_exists($leaderboardFile)) {
        $lines = file($leaderboardFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos($line, '|') !== false) {
                list($name, $score) = explode('|', $line, 2);
                $players[$name] = (int)$score;
            }
        }
    }
    
    // Update or add player score (accumulates across all games)
    if (isset($players[$nickname])) {
        $players[$nickname] += $points;
    } else {
        $players[$nickname] = $points;
    }
    
    // Write back to file
    $content = '';
    foreach ($players as $name => $score) {
        $content .= "$name|$score\n";
    }
    file_put_contents($leaderboardFile, $content);
}

/**
 * Get player's cumulative score from leaderboard
 * @param string $nickname Player nickname
 * @return int Cumulative score from all games
 */
function getPlayerCumulativeScore($nickname) {
    $leaderboardFile = 'data/leaderboard.txt';
    
    if (file_exists($leaderboardFile)) {
        $lines = file($leaderboardFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos($line, '|') !== false) {
                list($name, $score) = explode('|', $line, 2);
                if (trim($name) === $nickname) {
                    return (int)$score;
                }
            }
        }
    }
    return 0;
}

/**
 * Get leaderboard data sorted by specified criteria
 * @param string $sortBy Sort by 'name' or 'score'
 * @return array Sorted leaderboard data
 */
function getLeaderboard($sortBy = 'score') {
    $leaderboardFile = 'data/leaderboard.txt';
    $players = [];
    
    if (file_exists($leaderboardFile)) {
        $lines = file($leaderboardFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos($line, '|') !== false) {
                list($name, $score) = explode('|', $line, 2);
                $players[] = [
                    'name' => trim($name),
                    'score' => (int)$score
                ];
            }
        }
    }
    
    if ($sortBy == 'name') {
        usort($players, fn($a, $b) => strcmp($a['name'], $b['name']));
    } else {
        usort($players, fn($a, $b) => $b['score'] - $a['score']);
    }
    
    return $players;
}
?>
