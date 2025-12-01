<?php
session_start(); 
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        die("Error: Email and password are required.");
    }
    
    $sql = "SELECT user_id, name, email, password_hash, user_type, phone, address, preferred_animal_type 
            FROM users 
            WHERE email = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['user_type'] = $user['user_type'];
            
            if ($user['user_type'] === 'agency') {
                header("Location: user_profile.php");
            } else {
                header("Location: user_profile.php");
            }
            exit();
            
        } else {
            echo "Error: Invalid email or password.";
        }
    } else {
        echo "Error: Invalid email or password.";
    }
    
    $stmt->close();
    $conn->close();
    
} else {
    die("This page cannot be accessed directly.");
}
?>
