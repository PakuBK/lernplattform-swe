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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo sanitize($quiz['title']); ?> - Learning Platform</title>
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
            <div style="margin-bottom: 20px;">
                <a href="dashboard.php" style="color: #667eea; text-decoration: none;">← Back to Dashboard</a>
            </div>

            <div class="card">
                <h1 style="color: #667eea; margin-bottom: 10px;"><?php echo sanitize($quiz['title']); ?></h1>
                <p style="color: #666; margin-bottom: 15px;"><?php echo sanitize($quiz['description']); ?></p>
                <div style="color: #888;">
                    <span>⏱️ Time Limit: <?php echo $quiz['time_limit']; ?> minutes</span>
                    <span style="margin-left: 20px;">📝 Questions: <?php echo count($questions); ?></span>
                </div>
            </div>

            <form method="POST" action="quiz.php?id=<?php echo $quiz_id; ?>">
                <?php foreach ($questions as $index => $question): ?>
                    <div class="question-card">
                        <div class="question-number">Question <?php echo $index + 1; ?> of <?php echo count($questions); ?></div>
                        <div class="question-text"><?php echo sanitize($question['question_text']); ?></div>
                        
                        <div class="options">
                            <div class="option">
                                <input type="radio" 
                                       id="q<?php echo $question['id']; ?>_a" 
                                       name="question_<?php echo $question['id']; ?>" 
                                       value="A" 
                                       required>
                                <label for="q<?php echo $question['id']; ?>_a">
                                    A) <?php echo sanitize($question['option_a']); ?>
                                </label>
                            </div>
                            
                            <div class="option">
                                <input type="radio" 
                                       id="q<?php echo $question['id']; ?>_b" 
                                       name="question_<?php echo $question['id']; ?>" 
                                       value="B">
                                <label for="q<?php echo $question['id']; ?>_b">
                                    B) <?php echo sanitize($question['option_b']); ?>
                                </label>
                            </div>
                            
                            <div class="option">
                                <input type="radio" 
                                       id="q<?php echo $question['id']; ?>_c" 
                                       name="question_<?php echo $question['id']; ?>" 
                                       value="C">
                                <label for="q<?php echo $question['id']; ?>_c">
                                    C) <?php echo sanitize($question['option_c']); ?>
                                </label>
                            </div>
                            
                            <div class="option">
                                <input type="radio" 
                                       id="q<?php echo $question['id']; ?>_d" 
                                       name="question_<?php echo $question['id']; ?>" 
                                       value="D">
                                <label for="q<?php echo $question['id']; ?>_d">
                                    D) <?php echo sanitize($question['option_d']); ?>
                                </label>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="card text-center">
                    <button type="submit" class="btn btn-success" style="font-size: 1.2em; padding: 15px 40px;">
                        Submit Quiz
                    </button>
                </div>
            </form>
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
$questions_stmt->close();
$conn->close();
?>
