<?php
/**
 * Student Dashboard
 * 
 * This is the main page where students can see available learning materials and quizzes.
 */

require_once '../includes/config.php';
require_once '../includes/functions.php';

requireLogin();

$conn = getDBConnection();

// Get learning materials
$materials_query = "SELECT * FROM learning_materials ORDER BY created_at DESC";
$materials_result = $conn->query($materials_query);

// Get quizzes
$quizzes_query = "SELECT q.*, lm.title as material_title 
                  FROM quizzes q 
                  LEFT JOIN learning_materials lm ON q.material_id = lm.id 
                  ORDER BY q.created_at DESC";
$quizzes_result = $conn->query($quizzes_query);

// Get user's recent quiz attempts
$user_id = getCurrentUserId();
$attempts_query = "SELECT qa.*, q.title as quiz_title, qa.completed_at 
                   FROM quiz_attempts qa 
                   JOIN quizzes q ON qa.quiz_id = q.id 
                   WHERE qa.user_id = ? 
                   ORDER BY qa.completed_at DESC 
                   LIMIT 5";
$stmt = executeQuery($conn, $attempts_query, [$user_id], "i");
$attempts_result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Learning Platform</title>
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
            <h1>Welcome to Your Learning Dashboard</h1>
            <p style="margin-bottom: 30px;">Choose a learning material to study or take a quiz to test your knowledge!</p>

            <!-- Learning Materials Section -->
            <section>
                <h2 style="color: #667eea; margin-bottom: 20px;">📚 Learning Materials</h2>
                <div class="grid">
                    <?php while ($material = $materials_result->fetch_assoc()): ?>
                        <div class="card">
                            <h3 class="card-title"><?php echo sanitize($material['title']); ?></h3>
                            <p class="card-description"><?php echo sanitize($material['description']); ?></p>
                            <div class="card-meta">
                                <span>📂 <?php echo sanitize($material['category']); ?></span>
                                <span class="badge badge-<?php echo $material['difficulty_level']; ?>">
                                    <?php echo ucfirst($material['difficulty_level']); ?>
                                </span>
                            </div>
                            <a href="material.php?id=<?php echo $material['id']; ?>" class="btn btn-primary" style="margin-top: 15px;">
                                Study Now
                            </a>
                        </div>
                    <?php endwhile; ?>
                </div>
            </section>

            <!-- Quizzes Section -->
            <section style="margin-top: 50px;">
                <h2 style="color: #667eea; margin-bottom: 20px;">📝 Available Quizzes</h2>
                <div class="grid">
                    <?php while ($quiz = $quizzes_result->fetch_assoc()): ?>
                        <div class="card">
                            <h3 class="card-title"><?php echo sanitize($quiz['title']); ?></h3>
                            <p class="card-description"><?php echo sanitize($quiz['description']); ?></p>
                            <div class="card-meta">
                                <?php if ($quiz['material_title']): ?>
                                    <span>📚 Related: <?php echo sanitize($quiz['material_title']); ?></span>
                                <?php endif; ?>
                                <span>⏱️ <?php echo $quiz['time_limit']; ?> minutes</span>
                            </div>
                            <a href="quiz.php?id=<?php echo $quiz['id']; ?>" class="btn btn-success" style="margin-top: 15px;">
                                Take Quiz
                            </a>
                        </div>
                    <?php endwhile; ?>
                </div>
            </section>

            <!-- Recent Quiz Attempts -->
            <?php if ($attempts_result->num_rows > 0): ?>
                <section style="margin-top: 50px;">
                    <h2 style="color: #667eea; margin-bottom: 20px;">📊 Your Recent Quiz Results</h2>
                    <div class="card">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="border-bottom: 2px solid #e0e0e0;">
                                    <th style="text-align: left; padding: 12px;">Quiz</th>
                                    <th style="text-align: center; padding: 12px;">Score</th>
                                    <th style="text-align: center; padding: 12px;">Percentage</th>
                                    <th style="text-align: left; padding: 12px;">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($attempt = $attempts_result->fetch_assoc()): ?>
                                    <tr style="border-bottom: 1px solid #f0f0f0;">
                                        <td style="padding: 12px;"><?php echo sanitize($attempt['quiz_title']); ?></td>
                                        <td style="text-align: center; padding: 12px;">
                                            <?php echo $attempt['score']; ?> / <?php echo $attempt['max_score']; ?>
                                        </td>
                                        <td style="text-align: center; padding: 12px;">
                                            <strong><?php echo calculatePercentage($attempt['score'], $attempt['max_score']); ?>%</strong>
                                        </td>
                                        <td style="padding: 12px;"><?php echo formatDate($attempt['completed_at']); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
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
$conn->close();
?>
