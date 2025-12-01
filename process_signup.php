<?php
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: signup.php');
    exit;
}

// form values from signup
$fullName = trim($_POST['name'] ?? '');
$email    = trim($_POST['email'] ?? '');
$phone    = trim($_POST['phone'] ?? '');
$address  = trim($_POST['address'] ?? '');
$password = $_POST['password'] ?? '';
$pet      = trim($_POST['pet'] ?? '');  // optional preference

if ($fullName === '' || $email === '' || $password === '') {
    die('Error: Name, email, and password are required.');
}

// has password
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

// check duplicate email
$sqlCheck = "SELECT COUNT(*) AS cnt FROM users WHERE email = ?";
$stmt = $conn->prepare($sqlCheck);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();

if ($row['cnt'] > 0) {
    die('Error: An account with this email already exists.');
}

// insert to database
$sqlInsert = "
    INSERT INTO users (
        name,
        email,
        password_hash,
        user_type,
        phone,
        address,
        preferred_animal_type
    ) VALUES (
        ?, ?, ?, 'adopter', ?, ?, ?
    )
";

$stmt = $conn->prepare($sqlInsert);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$preferred = ($pet !== '') ? $pet : null;

$stmt->bind_param(
    "ssssss",
    $fullName,
    $email,
    $passwordHash,
    $phone,
    $address,
    $preferred
);

if ($stmt->execute()) {
    $stmt->close();
    $conn->close();
    header('Location: login_index.php');
    exit;
} else {
    $error = $stmt->error;
    $stmt->close();
    $conn->close();
    die("Error creating account: " . $error);
}