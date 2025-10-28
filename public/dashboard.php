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

// Set page configuration
$pageTitle = 'Dashboard - Learning Platform';
require_once '../includes/header.php';
?>
<div class="container">
    <h1 class="mb-2">Welcome to Your Learning Dashboard</h1>
    <p class="lead text-muted mb-4">Choose a learning material to study or take a quiz to test your knowledge!</p>

    <!-- Learning Materials Section -->
    <section class="mb-5">
        <h2 class="text-primary mb-3">
            <i class="bi bi-book"></i> Learning Materials
        </h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php while ($material = $materials_result->fetch_assoc()): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo sanitize($material['title']); ?></h5>
                            <p class="card-text"><?php echo sanitize($material['description']); ?></p>
                            <div class="mb-3">
                                <span class="badge bg-secondary">
                                    <i class="bi bi-folder"></i> <?php echo sanitize($material['category']); ?>
                                </span>
                                <span class="badge bg-<?php echo $material['difficulty_level'] === 'beginner' ? 'success' : ($material['difficulty_level'] === 'intermediate' ? 'warning' : 'danger'); ?>">
                                    <?php echo ucfirst($material['difficulty_level']); ?>
                                </span>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="material.php?id=<?php echo $material['id']; ?>" class="btn btn-primary w-100">
                                <i class="bi bi-book-half"></i> Study Now
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <!-- Quizzes Section -->
    <section class="mb-5">
        <h2 class="text-primary mb-3">
            <i class="bi bi-pencil-square"></i> Available Quizzes
        </h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php while ($quiz = $quizzes_result->fetch_assoc()): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo sanitize($quiz['title']); ?></h5>
                            <p class="card-text"><?php echo sanitize($quiz['description']); ?></p>
                            <div class="mb-3">
                                <?php if ($quiz['material_title']): ?>
                                    <span class="badge bg-info">
                                        <i class="bi bi-book"></i> Related: <?php echo sanitize($quiz['material_title']); ?>
                                    </span>
                                <?php endif; ?>
                                <span class="badge bg-secondary">
                                    <i class="bi bi-clock"></i> <?php echo $quiz['time_limit']; ?> min
                                </span>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="quiz.php?id=<?php echo $quiz['id']; ?>" class="btn btn-success w-100">
                                <i class="bi bi-pencil-square"></i> Take Quiz
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <!-- Recent Quiz Attempts -->
    <?php if ($attempts_result->num_rows > 0): ?>
        <section class="mb-5">
            <h2 class="text-primary mb-3">
                <i class="bi bi-graph-up"></i> Your Recent Quiz Results
            </h2>
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Quiz</th>
                                    <th class="text-center">Score</th>
                                    <th class="text-center">Percentage</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($attempt = $attempts_result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo sanitize($attempt['quiz_title']); ?></td>
                                        <td class="text-center">
                                            <?php echo $attempt['score']; ?> / <?php echo $attempt['max_score']; ?>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-<?php 
                                                $percentage = calculatePercentage($attempt['score'], $attempt['max_score']);
                                                echo $percentage >= 75 ? 'success' : ($percentage >= 60 ? 'warning' : 'danger');
                                            ?>">
                                                <?php echo $percentage; ?>%
                                            </span>
                                        </td>
                                        <td><?php echo formatDate($attempt['completed_at']); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
</div>
<?php 
require_once '../includes/footer.php';
$stmt->close();
$conn->close();
?>
