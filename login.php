<?php 
require_once 'php/auth.php';

$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';

if (is_logged_in()) {
    if (is_admin()) {
        header('Location: dashboard_admin.php');
    } else {
        header('Location: dashboard_karyawan.php');
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    if (validate_login($username, $password)) {
        if (is_admin()) {
            header('Location: dashboard_admin.php');
        } else {
            header('Location: dashboard_karyawan.php');
        }
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Manajemen Karyawan</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <main class="container">
        <div class="card" style="max-width: 500px; margin: 40px auto;">
            <h1 class="card-title">Login</h1>
            
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <form id="loginForm" method="POST" action="login.php">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                
                <button type="submit" class="btn btn-block">Login</button>
            </form>
            
            <div style="text-align: center; margin-top: 20px;">
                <p>Belum punya akun? <a href="signup.php" style="color: var(--primary); font-weight: 500;">Daftar disini</a></p>
            </div>
        </div>
    </main>
    
    <?php include 'includes/footer.php'; ?>
    <script src="js/script.js"></script>
</body>
</html>