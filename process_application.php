<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    die("Error: You must be logged in to submit an application. <a href='login.php'>Login here</a>");
}

$pet_id = NULL;
$adopter_id = $_SESSION['user_id'];
$agency_id = NULL;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ID Stuff
    $pet_id = isset($_POST['pet_id']) && !empty($_POST['pet_id']) ? (int)$_POST['pet_id'] : NULL;
    $agency_id = $_POST['agency_id'] ?? NULL;

    // Basic Info
    $first_name = validate_input($_POST['first_name'] ?? '');
    $last_name = validate_input($_POST['last_name'] ?? '');
    $address = validate_input($_POST['address'] ?? '');
    $phone_number = validate_input($_POST['phone_number'] ?? '');
    $email = validate_input($_POST['email'] ?? '');

    // Housing Info
    $home_type = $_POST['home_type'] ?? '';
    $rent_or_own = $_POST['rent_or_own'] ?? '';
    $landlord_permission = $_POST['landlord_permission'] ?? '';

    // Pet Experience Info
    $has_pet_experience = isset($_POST['has_pet_experience']) ? (int)$_POST['has_pet_experience'] : 0;
    $owned_dog = isset($_POST['owned_dog']) ? 1 : 0;
    $owned_cat = isset($_POST['owned_cat']) ? 1 : 0;
    $owned_bird = isset($_POST['owned_bird']) ? 1 : 0;
    $owned_reptile = isset($_POST['owned_reptile']) ? 1 : 0;
    $owned_rodent = isset($_POST['owned_rodent']) ? 1 : 0;
    $owned_other = isset($_POST['owned_other']) ? 1 : 0;

    $has_current_pets = isset($_POST['has_current_pets']) ? (int)$_POST['has_current_pets'] : 0;
    $current_pets_description = validate_input($_POST['current_pets_description'] ?? '');
    
    // Household Info
    $household_num = isset($_POST['household_num']) ? (int)$_POST['household_num'] : 0;
    $has_children = isset($_POST['has_children']) ? (int)$_POST['has_children'] : 0;
    $children_description = validate_input($_POST['children_description'] ?? '');

    // Adoption Info
    $adoption_reason = validate_input($_POST['adoption_reason'] ?? '');
    $hours_pet_alone = $_POST['hours_pet_alone'] ?? '';
    
    // Prepare the SQL with placeholders (?)
    $sql = "INSERT INTO inquiries (
        pet_id, adopter_id, agency_id,
        first_name, last_name, address, phone_number, email,
        home_type, rent_or_own, landlord_permission,
        has_pet_experience, owned_dog, owned_cat, owned_bird, owned_reptile, owned_rodent, owned_other,
        has_current_pets, current_pets_description,
        household_num, has_children, children_description,
        adoption_reason, hours_pet_alone
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiissssssssiiiiiiiisiisss",
        $pet_id, $adopter_id, $agency_id,
        $first_name, $last_name, $address, $phone_number, $email,
        $home_type, $rent_or_own, $landlord_permission,
        $has_pet_experience, $owned_dog, $owned_cat, $owned_bird, $owned_reptile, $owned_rodent, $owned_other,
        $has_current_pets, $current_pets_description,
        $household_num, $has_children, $children_description,
        $adoption_reason, $hours_pet_alone
    );

    if($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: application_success.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
        $stmt->close();
        $conn->close();
    }

} else {
    die("This page cannot be accessed directly.");
}

function validate_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>