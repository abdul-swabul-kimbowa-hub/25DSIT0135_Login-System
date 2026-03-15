<?php
require_once 'config/database.php';

// Redirect if already logged in
if (isLoggedIn()) {
    header("Location: dashboard.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = sanitizeInput($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($login) || empty($password)) {
        $error = "Please enter both email/student number and password";
    } else {
        try {
            // Check if user exists (by email or student number)
            $stmt = $pdo->prepare("SELECT * FROM students WHERE email = ? OR student_number = ?");
            $stmt->execute([$login, $login]);
            $user = $stmt->fetch();
            
            if ($user && password_verify($password, $user['password'])) {
                // Regenerate session ID for security
                session_regenerate_id(true);
                
                // Set session variables
                $_SESSION['student_id'] = $user['id'];
                $_SESSION['student_number'] = $user['student_number'];
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['last_name'] = $user['last_name'];
                $_SESSION['email'] = $user['email'];
                
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Invalid credentials. Please try again.";
            }
        } catch (PDOException $e) {
            error_log("Login error: " . $e->getMessage());
            $error = "An error occurred. Please try again later.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Student Portal</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="auth-container">
        <h1>Student Login</h1>
        
        <?php echo displayMessage($error, 'error'); ?>
        
        <form method="POST" action="" class="auth-form">
            <div class="form-group">
                <label for="login">Email or Student Number:</label>
                <input type="text" id="login" name="login" required 
                       value="<?php echo htmlspecialchars($_POST['login'] ?? ''); ?>">
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>
        
        <div class="auth-links">
            <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
            <p><a href="index.php">← Back to Home</a></p>
        </div>
    </div>
    
    <script src="js/script.js"></script>
</body>
</html>