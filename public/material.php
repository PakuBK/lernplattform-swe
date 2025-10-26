<?php
/**
 * Learning Material Viewer
 * 
 * This page displays the content of a specific learning material.
 */

require_once '../includes/config.php';
require_once '../includes/functions.php';

requireLogin();

// Get material ID from URL
$material_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($material_id === 0) {
    redirect('dashboard.php');
}

$conn = getDBConnection();

// Get material details
$stmt = executeQuery($conn, "SELECT * FROM learning_materials WHERE id = ?", [$material_id], "i");
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    redirect('dashboard.php');
}

$material = $result->fetch_assoc();

// Get related quizzes
$quiz_query = "SELECT * FROM quizzes WHERE material_id = ?";
$quiz_stmt = executeQuery($conn, $quiz_query, [$material_id], "i");
$quiz_result = $quiz_stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo sanitize($material['title']); ?> - Learning Platform</title>
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
                <h1 style="color: #667eea; margin-bottom: 10px;"><?php echo sanitize($material['title']); ?></h1>
                <div style="margin-bottom: 20px;">
                    <span class="badge badge-<?php echo $material['difficulty_level']; ?>">
                        <?php echo ucfirst($material['difficulty_level']); ?>
                    </span>
                    <span style="margin-left: 10px; color: #666;">📂 <?php echo sanitize($material['category']); ?></span>
                </div>
                <p style="color: #666; font-style: italic; margin-bottom: 30px;">
                    <?php echo sanitize($material['description']); ?>
                </p>
            </div>

            <div class="content-area">
                <?php echo $material['content']; ?>
            </div>

            <!-- Related Quizzes -->
            <?php if ($quiz_result->num_rows > 0): ?>
                <section style="margin-top: 40px;">
                    <h2 style="color: #667eea; margin-bottom: 20px;">📝 Test Your Knowledge</h2>
                    <div class="grid">
                        <?php while ($quiz = $quiz_result->fetch_assoc()): ?>
                            <div class="card">
                                <h3 class="card-title"><?php echo sanitize($quiz['title']); ?></h3>
                                <p class="card-description"><?php echo sanitize($quiz['description']); ?></p>
                                <div class="card-meta">
                                    <span>⏱️ <?php echo $quiz['time_limit']; ?> minutes</span>
                                </div>
                                <a href="quiz.php?id=<?php echo $quiz['id']; ?>" class="btn btn-success" style="margin-top: 15px;">
                                    Take Quiz
                                </a>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </section>
            <?php endif; ?>
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
$quiz_stmt->close();
$conn->close();
?>
