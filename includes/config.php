<?php
/**
 * Database Configuration
 * 
 * This file contains database connection settings.
 * For novice programmers: Change these values to match your local setup.
 */

// Database credentials
define('DB_HOST', 'localhost');      // Database server (usually 'localhost')
define('DB_USER', 'root');           // Database username
define('DB_PASS', '');               // Database password
define('DB_NAME', 'lernplattform');  // Database name

// Create database connection
function getDBConnection() {
    try {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        // Set charset to UTF-8 to support special characters
        $conn->set_charset("utf8mb4");
        
        return $conn;
    } catch (Exception $e) {
        die("Database connection error: " . $e->getMessage());
    }
}

/**
 * Execute a prepared statement safely
 * This helps prevent SQL injection attacks
 */
function executeQuery($conn, $sql, $params = [], $types = "") {
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    return $stmt;
}
?>
