<?php
/**
 * Logout Page
 * 
 * This page logs out the current user and redirects to login page.
 */

require_once '../includes/functions.php';

startSession();

// Destroy all session data
session_destroy();

// Redirect to login page
redirect('login.php');
?>
