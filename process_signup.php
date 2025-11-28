<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['firstname'] ?? '');
    $lastName  = trim($_POST['lastname'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $username  = trim($_POST['username'] ??'');
    $phone     = trim($_POST['phone'] ?? '');
    $address   = trim($_POST['address'] ?? '');
    $password  = $_POST['password'] ?? '';

    // Very basic validation
    if ($firstName === '' || $lastName === '' || $username === '' || $email === '' || $password === '') {
        die('Missing required fields.');
    }

    $fullName = $firstName . ' ' . $lastName;

    // Hash password for storage
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Check for duplicate email
        $check = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $check->execute([$email]);
        if ($check->fetchColumn() > 0) {
            die('An account with this email already exists.');
        }

        // Insert new adopter (city/state from address could be parsed later if you want)
        $stmt = $pdo->prepare("
            INSERT INTO users (name, username, email, password_hash, user_type, phone, city, state, preferred_animal_type)
            VALUES (?, ?, ?, 'adopter', ?, NULL, NULL, NULL)
        ");

        $stmt->execute([$fullName, $username, $email, $passwordHash, $phone]);

        // Redirect to login on success
        header('Location: login_index.php');
        exit;
    } catch (PDOException $e) {
        die('Error creating account: ' . $e->getMessage());
    }
} else {
    header('Location: signup.php');
    exit;
}
