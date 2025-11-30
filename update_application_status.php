<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'agency') {
    die("Error: Unauthorized access.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $inquiry_id = isset($_POST['inquiry_id']) ? (int)$_POST['inquiry_id'] : 0;
    $new_status = $_POST['new_status'] ?? '';
    $approved = isset($_POST['approved']) ? (int)$_POST['approved'] : null;
    $agency_id = $_SESSION['user_id'];
    
    if ($inquiry_id <= 0 || !in_array($new_status, ['new', 'in_progress', 'closed'])) {
        die("Error: Invalid request.");
    }
    
    $sql = "SELECT i.inquiry_id, p.pet_id, p.agency_id
            FROM inquiries i
            JOIN pets p ON i.pet_id = p.pet_id
            WHERE i.inquiry_id = ? AND p.agency_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $inquiry_id, $agency_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        die("Error: You don't have permission to update this application.");
    }
    
    $stmt->close();
    
    $sql = "UPDATE inquiries SET status = ? WHERE inquiry_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_status, $inquiry_id);
    
    if ($stmt->execute()) {
        if ($new_status === 'closed' && $approved === 1) {
            $get_pet_sql = "SELECT pet_id FROM inquiries WHERE inquiry_id = ?";
            $get_stmt = $conn->prepare($get_pet_sql);
            $get_stmt->bind_param("i", $inquiry_id);
            $get_stmt->execute();
            $pet_result = $get_stmt->get_result();
            $pet_data = $pet_result->fetch_assoc();
            $pet_id = $pet_data['pet_id'];
            $get_stmt->close();
            
            $update_pet_sql = "UPDATE pets SET status = 'adopted' WHERE pet_id = ?";
            $update_stmt = $conn->prepare($update_pet_sql);
            $update_stmt->bind_param("i", $pet_id);
            $update_stmt->execute();
            $update_stmt->close();
        }
        
        $stmt->close();
        $conn->close();
        
        header("Location: user_profile.php?success=1");
        exit();
    } else {
        echo "Error updating application: " . $stmt->error;
        $stmt->close();
        $conn->close();
    }
    
} else {
    die("This page cannot be accessed directly.");
}
?>