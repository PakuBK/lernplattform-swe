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

// Set page configuration
$pageTitle = sanitize($material['title']) . ' - Learning Platform';
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
            <h1 class="text-primary mb-3"><?php echo sanitize($material['title']); ?></h1>
            <div class="mb-3">
                <span class="badge bg-<?php echo $material['difficulty_level'] === 'beginner' ? 'success' : ($material['difficulty_level'] === 'intermediate' ? 'warning' : 'danger'); ?>">
                    <?php echo ucfirst($material['difficulty_level']); ?>
                </span>
                <span class="badge bg-secondary ms-2">
                    <i class="bi bi-folder"></i> <?php echo sanitize($material['category']); ?>
                </span>
            </div>
            <p class="text-muted fst-italic mb-0">
                <?php echo sanitize($material['description']); ?>
            </p>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <?php echo $material['content']; ?>
        </div>
    </div>

    <!-- Related Quizzes -->
    <?php if ($quiz_result->num_rows > 0): ?>
        <section class="mb-4">
            <h2 class="text-primary mb-3">
                <i class="bi bi-pencil-square"></i> Test Your Knowledge
            </h2>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php while ($quiz = $quiz_result->fetch_assoc()): ?>
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo sanitize($quiz['title']); ?></h5>
                                <p class="card-text"><?php echo sanitize($quiz['description']); ?></p>
                                <div class="mb-3">
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
    <?php endif; ?>
</div>
<?php 
require_once '../includes/footer.php';
$stmt->close();
$quiz_stmt->close();
$conn->close();
?>
