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

// Set page configuration
$pageTitle = 'Quiz Results - Learning Platform';
require_once '../includes/header.php';
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0 text-center">
                <div class="card-body p-5">
                    <div style="font-size: 5rem; margin-bottom: 20px;"><?php echo $grade_emoji; ?></div>
                    <h1 class="text-primary mb-3">Quiz Completed!</h1>
                    <h3 class="mb-4"><?php echo sanitize($quiz['title']); ?></h3>
                    
                    <div class="mb-4">
                        <div class="display-1 fw-bold text-primary mb-2">
                            <?php echo $score; ?> <span class="text-muted">/ <?php echo $max_score; ?></span>
                        </div>
                        <div class="display-4 fw-bold text-<?php echo $percentage >= 75 ? 'success' : ($percentage >= 60 ? 'warning' : 'danger'); ?>">
                            <?php echo $percentage; ?>%
                        </div>
                    </div>
                    
                    <div class="alert alert-<?php echo $percentage >= 75 ? 'success' : ($percentage >= 60 ? 'warning' : 'info'); ?> mb-4">
                        <h5><?php echo $grade_message; ?></h5>
                    </div>
                    
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="quiz.php?id=<?php echo $quiz_id; ?>" class="btn btn-outline-secondary btn-lg">
                            <i class="bi bi-arrow-repeat"></i> Retake Quiz
                        </a>
                        <a href="dashboard.php" class="btn btn-primary btn-lg">
                            <i class="bi bi-house-door"></i> Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
require_once '../includes/footer.php';
$stmt->close();
$conn->close();
?>
