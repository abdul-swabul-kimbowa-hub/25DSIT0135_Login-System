<?php
require_once 'config/database.php';

// Redirect if already logged in
if (isLoggedIn()) {
    header("Location: dashboard.php");
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = sanitizeInput($_POST['first_name'] ?? '');
    $last_name = sanitizeInput($_POST['last_name'] ?? '');
    $email = sanitizeInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Validation
    if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
        $error = "All fields are required";
    } elseif (!validateEmail($email)) {
        $error = "Invalid email format";
    } elseif ($password != $confirm_password) {
        $error = "Passwords don't match";
    } elseif (!validatePassword($password)) {
        $error = "Password must be at least 6 characters";
    } else {
        try {
            // Check if email exists
            $check = $pdo->prepare("SELECT id FROM students WHERE email = ?");
            $check->execute([$email]);
            
            if ($check->rowCount() > 0) {
                $error = "Email already registered";
            } else {
                // Generate unique student number
                do {
                    $student_number = generateStudentNumber();
                    $check_num = $pdo->prepare("SELECT id FROM students WHERE student_number = ?");
                    $check_num->execute([$student_number]);
                } while ($check_num->rowCount() > 0);
                
                // Hash password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                // Insert student
                $insert = $pdo->prepare("INSERT INTO students (student_number, first_name, last_name, email, password) VALUES (?, ?, ?, ?, ?)");
                
                if ($insert->execute([$student_number, $first_name, $last_name, $email, $hashed_password])) {
                    $success = "Registration successful! Your student number is: <strong>$student_number</strong><br>
                               You can now <a href='login.php'>login here</a>.";
                } else {
                    $error = "Registration failed. Please try again.";
                }
            }
        } catch (PDOException $e) {
            error_log("Signup error: " . $e->getMessage());
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
    <title>Sign Up - Student Portal</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="auth-container">
        <h1>Student Sign Up</h1>
        
        <?php echo displayMessage($error, 'error'); ?>
        <?php echo displayMessage($success, 'success'); ?>
        
        <form method="POST" action="" class="auth-form" id="signupForm">
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" required 
                       value="<?php echo htmlspecialchars($_POST['first_name'] ?? ''); ?>">
            </div>
            
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" required 
                       value="<?php echo htmlspecialchars($_POST['last_name'] ?? ''); ?>">
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required 
                       value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
            </div>
            
            <div class="form-group">
                <label for="password">Password (min 6 characters):</label>
                <input type="password" id="password" name="password" required>
                <small class="password-hint">Use at least 6 characters</small>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
        </form>
        
        <div class="auth-links">
            <p>Already have an account? <a href="login.php">Login here</a></p>
            <p><a href="index.php">← Back to Home</a></p>
        </div>
    </div>
    
    <script src="js/script.js"></script>
</body>
</html>