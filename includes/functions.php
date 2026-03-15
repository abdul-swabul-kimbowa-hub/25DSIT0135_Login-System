<?php
/**
 * Sanitize input data
 * @param string $data
 * @return string
 */
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * Generate unique student number
 * @return string
 */
function generateStudentNumber() {
    $year = date('Y');
    $random = rand(1000, 9999);
    return "STU-" . $year . "-" . $random;
}

/**
 * Check if user is logged in
 * @return bool
 */
function isLoggedIn() {
    return isset($_SESSION['student_id']);
}

/**
 * Redirect if not logged in
 */
function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}

/**
 * Display flash message
 * @param string $message
 * @param string $type
 * @return string
 */
function displayMessage($message, $type = 'info') {
    if (empty($message)) return '';
    return "<div class='message {$type}'>{$message}</div>";
}

/**
 * Validate email
 * @param string $email
 * @return bool
 */
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validate password strength
 * @param string $password
 * @return bool
 */
function validatePassword($password) {
    return strlen($password) >= 6;
}
?>