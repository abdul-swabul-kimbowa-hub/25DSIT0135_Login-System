<?php
require_once 'config/database.php';

// Redirect to dashboard if already logged in
if (isset($_SESSION['student_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal - Home</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <div class="hero-section">
            <h1>Welcome to Student Portal</h1>
            <p>A secure platform for student management and authentication</p>
            
            <div class="cta-buttons">
                <a href="login.php" class="btn btn-primary">Login</a>
                <a href="signup.php" class="btn btn-secondary">Sign Up</a>
            </div>
        </div>
        
        <div class="features">
            <div class="feature-card">
                <h3>Secure Authentication</h3>
                <p>Password hashing and secure session management</p>
            </div>
            <div class="feature-card">
                <h3>Student Dashboard</h3>
                <p>Manage your profile and account settings</p>
            </div>
            <div class="feature-card">
                <h3>Profile Management</h3>
                <p>Update your information and change password</p>
            </div>
        </div>
    </div>
    
    <footer>
        <p>&copy; 2024 Student Portal. All rights reserved.</p>
    </footer>
</body>
</html>