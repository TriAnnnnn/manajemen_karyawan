<?php 
require_once 'php/auth.php';

$error = '';
$success = '';

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
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    $errors = validate_signup($username, $email, $password, $confirm_password);
    
    if (empty($errors)) {
        // Check if username or email exists
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        
        if ($stmt->rowCount() > 0) {
            $error = "Username atau email sudah terdaftar!";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt = $pdo->prepare("INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, 'karyawan')");
            if ($stmt->execute([$username, $hashed_password, $email])) {
                $success = "Registrasi berhasil! Silakan login.";
                header('Location: login.php?success=' . urlencode($success));
                exit;
            } else {
                $error = "Terjadi kesalahan saat registrasi. Coba lagi.";
            }
        }
    } else {
        $error = implode("<br>", $errors);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Manajemen Karyawan</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <main class="container">
        <div class="card" style="max-width: 600px; margin: 40px auto;">
            <h1 class="card-title">Daftar Akun Baru</h1>
            
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form id="signupForm" method="POST" action="signup.php">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required minlength="3">
                    <small class="text-muted">Minimal 3 karakter</small>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required minlength="8">
                    <small class="text-muted">Minimal 8 karakter</small>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Konfirmasi Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
                
                <button type="submit" class="btn btn-block">Daftar</button>
            </form>
            
            <div style="text-align: center; margin-top: 20px;">
                <p>Sudah punya akun? <a href="login.php" style="color: var(--primary); font-weight: 500;">Login disini</a></p>
            </div>
        </div>
    </main>
    
    <?php include 'includes/footer.php'; ?>
    <script src="js/script.js"></script>
</body>
</html>