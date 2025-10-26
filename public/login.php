<?php
/**
 * Login Page
 * 
 * This page allows students to log in to the learning platform.
 */

require_once '../includes/config.php';
require_once '../includes/functions.php';

startSession();

// Redirect if already logged in
if (isLoggedIn()) {
    redirect('dashboard.php');
}

$error = '';
$success = '';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $error = 'Please enter both username and password.';
    } else {
        $conn = getDBConnection();
        
        // Get user from database
        $stmt = executeQuery($conn, "SELECT id, username, password, full_name FROM users WHERE username = ?", [$username], "s");
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Login successful
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['full_name'] = $user['full_name'];
                
                redirect('dashboard.php');
            } else {
                $error = 'Invalid username or password.';
            }
        } else {
            $error = 'Invalid username or password.';
        }
        
        $stmt->close();
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Learning Platform</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h1 class="login-title">🎓 Learning Platform</h1>
            
            <?php if ($error): ?>
                <?php echo showError($error); ?>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <?php echo showSuccess($success); ?>
            <?php endif; ?>
            
            <form method="POST" action="login.php">
                <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-input" required autofocus>
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-input" required>
                </div>
                
                <button type="submit" class="btn btn-primary btn-full">Login</button>
            </form>
            
            <div class="alert alert-info mt-20">
                <strong>Demo Account:</strong><br>
                Username: <strong>student1</strong><br>
                Password: <strong>student123</strong>
            </div>
        </div>
    </div>
</body>
</html>
