<?php
require 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        die('Please enter both email and password.');
    }

    try {
        // Look up user by email
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            die('No account found with that email.');
        }

        // Check password
        if (!password_verify($password, $user['password_hash'])) {
            die('Incorrect password.');
        }

        // Store user info in session
        $_SESSION['user_id']   = $user['user_id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_type'] = $user['user_type'];

        // Redirect to homepage or wherever you want
        header('Location: frontpage.php');
        exit;
    } catch (PDOException $e) {
        die('Login error: ' . $e->getMessage());
    }
} else {
    header('Location: login_index.php');
    exit;
}
