<?php
require_once 'config/database.php';
requireLogin();

$message = '';
$message_type = '';

// Handle profile update
if (isset($_POST['update_profile'])) {
    $first_name = sanitizeInput($_POST['first_name'] ?? '');
    $last_name = sanitizeInput($_POST['last_name'] ?? '');
    $email = sanitizeInput($_POST['email'] ?? '');
    
    if (empty($first_name) || empty($last_name) || empty($email)) {
        $message = "All fields are required";
        $message_type = "error";
    } elseif (!validateEmail($email)) {
        $message = "Invalid email format";
        $message_type = "error";
    } else {
        try {
            // Check if email exists for another user
            $check = $pdo->prepare("SELECT id FROM students WHERE email = ? AND id != ?");
            $check->execute([$email, $_SESSION['student_id']]);
            
            if ($check->rowCount() > 0) {
                $message = "Email already used by another student";
                $message_type = "error";
            } else {
                // Update profile
                $update = $pdo->prepare("UPDATE students SET first_name = ?, last_name = ?, email = ? WHERE id = ?");
                if ($update->execute([$first_name, $last_name, $email, $_SESSION['student_id']])) {
                    // Update session
                    $_SESSION['first_name'] = $first_name;
                    $_SESSION['last_name'] = $last_name;
                    $_SESSION['email'] = $email;
                    
                    $message = "Profile updated successfully";
                    $message_type = "success";
                }
            }
        } catch (PDOException $e) {
            error_log("Profile update error: " . $e->getMessage());
            $message = "An error occurred. Please try again.";
            $message_type = "error";
        }
    }
}

// Handle password change
if (isset($_POST['change_password'])) {
    $current = $_POST['current_password'] ?? '';
    $new = $_POST['new_password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';
    
    if (empty($current) || empty($new) || empty($confirm)) {
        $message = "All password fields are required";
        $message_type = "error";
    } elseif ($new != $confirm) {
        $message = "New passwords don't match";
        $message_type = "error";
    } elseif (!validatePassword($new)) {
        $message = "New password must be at least 6 characters";
        $message_type = "error";
    } else {
        try {
            // Verify current password
            $stmt = $pdo->prepare("SELECT password FROM students WHERE id = ?");
            $stmt->execute([$_SESSION['student_id']]);
            $user = $stmt->fetch();
            
            if (password_verify($current, $user['password'])) {
                $hashed = password_hash($new, PASSWORD_DEFAULT);
                $update = $pdo->prepare("UPDATE students SET password = ? WHERE id = ?");
                
                if ($update->execute([$hashed, $_SESSION['student_id']])) {
                    $message = "Password changed successfully";
                    $message_type = "success";
                }
            } else {
                $message = "Current password is incorrect";
                $message_type = "error";
            }
        } catch (PDOException $e) {
            error_log("Password change error: " . $e->getMessage());
            $message = "An error occurred. Please try again.";
            $message_type = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Student Portal</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="dashboard">
        <nav class="dashboard-nav">
            <div class="nav-brand">Student Portal</div>
            <div class="nav-user">
                <span>Welcome, <?php echo htmlspecialchars($_SESSION['first_name']); ?></span>
                <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
            </div>
        </nav>
        
        <div class="dashboard-container">
            <?php if ($message): ?>
                <div class="message <?php echo $message_type; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            
            <div class="welcome-card">
                <h2>Welcome, <?php echo htmlspecialchars($_SESSION['first_name'] . ' ' . $_SESSION['last_name']); ?>!</h2>
                <p>You are now logged in to the student portal.</p>
                <div class="student-info">
                    <strong>Student Number:</strong> 
                    <?php echo htmlspecialchars($_SESSION['student_number']); ?>
                </div>
            </div>
            
            <div class="dashboard-grid">
                <!-- Profile Info Card -->
                <div class="dashboard-card">
                    <h3>Your Information</h3>
                    <div class="info-item">
                        <span class="info-label">Name:</span>
                        <?php echo htmlspecialchars($_SESSION['first_name'] . ' ' . $_SESSION['last_name']); ?>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Email:</span>
                        <?php echo htmlspecialchars($_SESSION['email']); ?>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Student #:</span>
                        <?php echo htmlspecialchars($_SESSION['student_number']); ?>
                    </div>
                </div>
                
                <!-- Update Profile Card -->
                <div class="dashboard-card">
                    <h3>Update Profile</h3>
                    <form method="POST" class="dashboard-form">
                        <div class="form-group">
                            <label for="first_name">First Name:</label>
                            <input type="text" id="first_name" name="first_name" 
                                   value="<?php echo htmlspecialchars($_SESSION['first_name']); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="last_name">Last Name:</label>
                            <input type="text" id="last_name" name="last_name" 
                                   value="<?php echo htmlspecialchars($_SESSION['last_name']); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" 
                                   value="<?php echo htmlspecialchars($_SESSION['email']); ?>" required>
                        </div>
                        
                        <button type="submit" name="update_profile" class="btn btn-primary btn-block">
                            Update Profile
                        </button>
                    </form>
                </div>
                
                <!-- Change Password Card -->
                <div class="dashboard-card">
                    <h3>Change Password</h3>
                    <form method="POST" class="dashboard-form">
                        <div class="form-group">
                            <label for="current_password">Current Password:</label>
                            <input type="password" id="current_password" name="current_password" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="new_password">New Password (min 6 chars):</label>
                            <input type="password" id="new_password" name="new_password" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="confirm_password">Confirm New Password:</label>
                            <input type="password" id="confirm_password" name="confirm_password" required>
                        </div>
                        
                        <button type="submit" name="change_password" class="btn btn-primary btn-block">
                            Change Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script src="js/script.js"></script>
</body>
</html>