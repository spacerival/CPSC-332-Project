<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form values
    $fullName = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $phone    = trim($_POST['phone'] ?? '');
    $address  = trim($_POST['address'] ?? '');
    $password = $_POST['password'] ?? '';
    $pet      = trim($_POST['pet'] ?? '');

    // Basic validation
    if ($fullName === '' || $email === '' || $password === '') {
        die('Missing required fields.');
    }

    // Hash password for storage
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Check for duplicate email
        $check = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $check->execute([':email' => $email]);
        if ($check->fetchColumn() > 0) {
            die('An account with this email already exists.');
        }

        // Insert new adopter
        $sql = "
            INSERT INTO users (
                name,
                email,
                password_hash,
                user_type,
                phone,
                address,
                preferred_animal_type
            ) VALUES (
                :name,
                :email,
                :password_hash,
                'adopter',
                :phone,
                :address,
                :preferred_animal_type
            )
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':name'                => $fullName,
            ':email'               => $email,
            ':password_hash'       => $passwordHash,
            ':phone'               => $phone,
            ':address'             => $address,
            ':preferred_animal_type' => ($pet !== '' ? $pet : null)
        ]);

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
