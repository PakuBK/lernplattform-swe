<?php
/**
 * Quiz Results Page
 * 
 * This page displays the results after completing a quiz.
 */

require_once '../includes/config.php';
require_once '../includes/functions.php';

requireLogin();

// Get result data from URL
$quiz_id = isset($_GET['quiz_id']) ? (int)$_GET['quiz_id'] : 0;
$score = isset($_GET['score']) ? (int)$_GET['score'] : 0;
$max_score = isset($_GET['max']) ? (int)$_GET['max'] : 1;

if ($quiz_id === 0) {
    redirect('dashboard.php');
}

$conn = getDBConnection();

// Get quiz details
$stmt = executeQuery($conn, "SELECT * FROM quizzes WHERE id = ?", [$quiz_id], "i");
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    redirect('dashboard.php');
}

$quiz = $result->fetch_assoc();

// Calculate percentage
$percentage = calculatePercentage($score, $max_score);

// Determine grade message
if ($percentage >= 90) {
    $grade_message = "Excellent! Outstanding performance!";
    $grade_emoji = "🌟";
} elseif ($percentage >= 75) {
    $grade_message = "Great job! You did very well!";
    $grade_emoji = "🎉";
} elseif ($percentage >= 60) {
    $grade_message = "Good effort! Keep studying!";
    $grade_emoji = "👍";
} else {
    $grade_message = "Keep practicing! You can do better!";
    $grade_emoji = "💪";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results - Learning Platform</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="header-content">
                <a href="dashboard.php" class="logo">🎓 Learning Platform</a>
                <nav class="nav">
                    <a href="dashboard.php">Dashboard</a>
                    <div class="user-info">
                        <span>Welcome, <?php echo sanitize($_SESSION['full_name']); ?>!</span>
                        <a href="logout.php">Logout</a>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <main class="main-content">
        <div class="container">
            <div class="result-summary">
                <div style="font-size: 4em; margin-bottom: 20px;"><?php echo $grade_emoji; ?></div>
                <h1 style="color: #667eea; margin-bottom: 20px;">Quiz Completed!</h1>
                <h2 style="margin-bottom: 30px;"><?php echo sanitize($quiz['title']); ?></h2>
                
                <div class="score-display">
                    <?php echo $score; ?> / <?php echo $max_score; ?>
                </div>
                
                <div class="percentage">
                    <?php echo $percentage; ?>%
                </div>
                
                <div style="font-size: 1.3em; color: #666; margin-bottom: 40px;">
                    <?php echo $grade_message; ?>
                </div>
                
                <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                    <a href="quiz.php?id=<?php echo $quiz_id; ?>" class="btn btn-secondary">
                        Retake Quiz
                    </a>
                    <a href="dashboard.php" class="btn btn-primary">
                        Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2025 Learning Platform. Designed for young learners.</p>
        </div>
    </footer>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>
