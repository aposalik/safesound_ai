<?php
session_start();
require_once 'config/database.php';

if ($_POST['action'] === 'login') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($email && $password) {
        $stmt = $pdo->prepare("SELECT id, first_name, last_name, password FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
            $_SESSION['user_email'] = $email;
            header('Location: index.php?page=dashboard');
            exit;
        } else {
            header('Location: ?page=login&error=invalid');
            exit;
        }
    }
}

if ($_POST['action'] === 'signup') {
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    if ($password !== $confirm_password) {
        header('Location: ?page=signup&error=password_mismatch');
        exit;
    }
    
    if ($first_name && $last_name && $email && $password) {
        // Check if email exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->fetch()) {
            header('Location: ?page=signup&error=email_exists');
            exit;
        }
        
        // Create user
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, phone, password) VALUES (?, ?, ?, ?, ?)");
        
        if ($stmt->execute([$first_name, $last_name, $email, $phone, $hashed_password])) {
            $user_id = $pdo->lastInsertId();
            
            // Create default settings
            $stmt = $pdo->prepare("INSERT INTO user_settings (user_id, alert_email) VALUES (?, ?)");
            $stmt->execute([$user_id, $email]);
            
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_name'] = $first_name . ' ' . $last_name;
            $_SESSION['user_email'] = $email;
            header('Location: index.php?page=dashboard');
            exit;
        }
    }
    
    header('Location: ?page=signup&error=invalid');
    exit;
}

header('Location: ?page=home');
exit;
?>