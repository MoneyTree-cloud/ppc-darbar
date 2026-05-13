<?php
/**
 * Real Estate Chatbot Admin - Login Page
 */

// Include configuration
require_once '../config/config.php';
require_once '../api/auth.php';

// Redirect if already logged in
if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

// Process login form
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);
    
    if (empty($username) || empty($password)) {
        $error = 'Please enter both username and password.';
    } else {
        $user = authenticateUser($username, $password);
        
        if ($user) {
            // Set session data
            $_SESSION['user'] = $user;
            
            // Set longer session lifetime if remember me is checked
            if ($remember) {
                ini_set('session.cookie_lifetime', 30 * 24 * 60 * 60); // 30 days
                session_regenerate_id();
            }
            
            // Redirect to dashboard
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Invalid username or password.';
        }
    }
}

// Create CSRF token
$csrfToken = createCsrfToken();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Real Estate Chatbot Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-logo">
                <h1><?php echo APP_NAME; ?> Admin</h1>
            </div>
            
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form class="login-form" method="POST" action="login.php">
                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" class="form-control" required autofocus>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                
                <div class="checkbox">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Remember me</label>
                </div>
                
                <button type="submit" class="login-btn">Log In</button>
            </form>
            
            <div class="forgot-password">
                <a href="javascript:alert('Please contact your administrator to reset your password.')">Forgot password?</a>
            </div>
        </div>
    </div>
    
    <script>
        // Basic form validation
        document.querySelector('.login-form').addEventListener('submit', function(e) {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();
            
            if (username === '' || password === '') {
                e.preventDefault();
                alert('Please enter both username and password.');
            }
        });
    </script>
</body>
</html>
