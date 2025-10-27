<?php
/**
 * Quiz Page
 * 
 * This page displays quiz questions and handles quiz submission.
 */

require_once '../includes/config.php';
require_once '../includes/functions.php';

requireLogin();

// Get quiz ID from URL
$quiz_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

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

// Get quiz questions
$questions_query = "SELECT * FROM questions WHERE quiz_id = ? ORDER BY id";
$questions_stmt = executeQuery($conn, $questions_query, [$quiz_id], "i");
$questions_result = $questions_stmt->get_result();
$questions = [];
while ($q = $questions_result->fetch_assoc()) {
    $questions[] = $q;
}

// Handle quiz submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $score = 0;
    $max_score = 0;
    
    foreach ($questions as $question) {
        $max_score += $question['points'];
        $user_answer = $_POST['question_' . $question['id']] ?? '';
        
        if ($user_answer === $question['correct_answer']) {
            $score += $question['points'];
        }
    }
    
    // Save quiz attempt
    $user_id = getCurrentUserId();
    $save_query = "INSERT INTO quiz_attempts (user_id, quiz_id, score, max_score) VALUES (?, ?, ?, ?)";
    $save_stmt = executeQuery($conn, $save_query, [$user_id, $quiz_id, $score, $max_score], "iiii");
    
    // Redirect to results
    $save_stmt->close();
    $stmt->close();
    $questions_stmt->close();
    $conn->close();
    
    redirect('result.php?quiz_id=' . $quiz_id . '&score=' . $score . '&max=' . $max_score);
}

// Set page configuration
$pageTitle = sanitize($quiz['title']) . ' - Learning Platform';
require_once '../includes/header.php';
?>
<div class="container">
    <div class="mb-3">
        <a href="dashboard.php" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h1 class="text-primary mb-3"><?php echo sanitize($quiz['title']); ?></h1>
            <p class="text-muted mb-3"><?php echo sanitize($quiz['description']); ?></p>
            <div>
                <span class="badge bg-info">
                    <i class="bi bi-clock"></i> Time Limit: <?php echo $quiz['time_limit']; ?> minutes
                </span>
                <span class="badge bg-secondary ms-2">
                    <i class="bi bi-question-circle"></i> Questions: <?php echo count($questions); ?>
                </span>
            </div>
        </div>
    </div>

    <form method="POST" action="quiz.php?id=<?php echo $quiz_id; ?>">
        <?php foreach ($questions as $index => $question): ?>
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="badge bg-primary mb-3">
                        Question <?php echo $index + 1; ?> of <?php echo count($questions); ?>
                    </div>
                    <h5 class="card-title mb-4"><?php echo sanitize($question['question_text']); ?></h5>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" 
                               id="q<?php echo $question['id']; ?>_a" 
                               name="question_<?php echo $question['id']; ?>" 
                               value="A" 
                               required>
                        <label class="form-check-label" for="q<?php echo $question['id']; ?>_a">
                            <strong>A)</strong> <?php echo sanitize($question['option_a']); ?>
                        </label>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" 
                               id="q<?php echo $question['id']; ?>_b" 
                               name="question_<?php echo $question['id']; ?>" 
                               value="B">
                        <label class="form-check-label" for="q<?php echo $question['id']; ?>_b">
                            <strong>B)</strong> <?php echo sanitize($question['option_b']); ?>
                        </label>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" 
                               id="q<?php echo $question['id']; ?>_c" 
                               name="question_<?php echo $question['id']; ?>" 
                               value="C">
                        <label class="form-check-label" for="q<?php echo $question['id']; ?>_c">
                            <strong>C)</strong> <?php echo sanitize($question['option_c']); ?>
                        </label>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" 
                               id="q<?php echo $question['id']; ?>_d" 
                               name="question_<?php echo $question['id']; ?>" 
                               value="D">
                        <label class="form-check-label" for="q<?php echo $question['id']; ?>_d">
                            <strong>D)</strong> <?php echo sanitize($question['option_d']); ?>
                        </label>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="card shadow-sm">
            <div class="card-body text-center">
                <button type="submit" class="btn btn-success btn-lg px-5">
                    <i class="bi bi-check-circle"></i> Submit Quiz
                </button>
            </div>
        </div>
    </form>
</div>
<?php 
require_once '../includes/footer.php';
$stmt->close();
$questions_stmt->close();
$conn->close();
?>
