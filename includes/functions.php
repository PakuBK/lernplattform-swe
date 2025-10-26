<?php
/**
 * Helper Functions
 * 
 * This file contains useful functions used throughout the application.
 * For novice programmers: These are reusable code snippets.
 */

/**
 * Start a session if not already started
 */
function startSession() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

/**
 * Check if user is logged in
 */
function isLoggedIn() {
    startSession();
    return isset($_SESSION['user_id']);
}

/**
 * Get current user ID
 */
function getCurrentUserId() {
    startSession();
    return $_SESSION['user_id'] ?? null;
}

/**
 * Get current username
 */
function getCurrentUsername() {
    startSession();
    return $_SESSION['username'] ?? null;
}

/**
 * Redirect to another page
 */
function redirect($url) {
    header("Location: $url");
    exit();
}

/**
 * Sanitize user input to prevent XSS attacks
 */
function sanitize($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

/**
 * Display error message
 */
function showError($message) {
    return '<div class="alert alert-error">' . sanitize($message) . '</div>';
}

/**
 * Display success message
 */
function showSuccess($message) {
    return '<div class="alert alert-success">' . sanitize($message) . '</div>';
}

/**
 * Require user to be logged in
 */
function requireLogin() {
    if (!isLoggedIn()) {
        redirect('/public/login.php');
    }
}

/**
 * Format date for display
 */
function formatDate($date) {
    return date('F j, Y', strtotime($date));
}

/**
 * Calculate percentage
 */
function calculatePercentage($score, $maxScore) {
    if ($maxScore == 0) return 0;
    return round(($score / $maxScore) * 100, 1);
}
?>
