<?php
/**
 * Index Page
 * 
 * Redirects to the appropriate page based on login status.
 */

require_once '../includes/functions.php';

startSession();

if (isLoggedIn()) {
    redirect('dashboard.php');
} else {
    redirect('login.php');
}
?>
