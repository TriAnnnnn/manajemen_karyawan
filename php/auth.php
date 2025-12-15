<?php
require_once 'config.php';

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function is_admin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function redirect_if_not_logged_in() {
    if (!is_logged_in()) {
        header('Location: login.php?error=not_logged_in');
        exit;
    }
}

function redirect_if_not_admin() {
    if (!is_admin()) {
        header('Location: dashboard_karyawan.php?error=forbidden');
        exit;
    }
}

function validate_signup($username, $email, $password, $confirm_password) {
    $errors = [];
    
    if (empty($username) || strlen($username) < 3) {
        $errors[] = "Username minimal 3 karakter";
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid";
    }
    
    if (strlen($password) < 8) {
        $errors[] = "Password minimal 8 karakter";
    }
    
    if ($password !== $confirm_password) {
        $errors[] = "Konfirmasi password tidak cocok";
    }
    
    return $errors;
}

function validate_login($username, $password) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    
    if (!$user || !password_verify($password, $user['password'])) {
        return false;
    }
    
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];
    return true;
}
?>