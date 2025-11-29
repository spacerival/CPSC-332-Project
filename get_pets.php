<?php
header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username = "root"; // Change if needed
$password = ""; // Change if needed
$dbname = "petmatcherDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Fetch pets from database
$sql = "SELECT pet_id, name, animal_type, breed, age, status, description, city, state 
        FROM pets WHERE status = 'available'";
$result = $conn->query($sql);

$petsData = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Generate a placeholder image based on animal type
        $imageUrl = getPlaceholderImage($row['animal_type']);
        
        $pet = array(
            'id' => $row['pet_id'],
            'name' => $row['name'],
            'type' => $row['animal_type'],
            'breed' => $row['breed'] ? $row['breed'] : 'Mixed Breed',
            'age' => $row['age'] ? $row['age'] . ' years' : 'Age not specified',
            'location' => $row['city'] . ', ' . $row['state'],
            'image' => $imageUrl,
            'description' => $row['description'] ? $row['description'] : 'No description available.'
        );
        $petsData[] = $pet;
    }
}

// Function to get placeholder image based on animal type
function getPlaceholderImage($animalType) {
    $images = array(
        'dog' => 'https://images.unsplash.com/photo-1552053831-71594a27632d?w=300&h=200&fit=crop',
        'cat' => 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=300&h=200&fit=crop',
        'rabbit' => 'https://images.unsplash.com/photo-1585110396000-c9ffd4e4b308?w=300&h=200&fit=crop',
        'bird' => 'https://images.unsplash.com/photo-1552728089-57bdde30beb3?w=300&h=200&fit=crop'
    );
    
    return isset($images[$animalType]) ? $images[$animalType] : 'https://images.unsplash.com/photo-1543466835-00a7907e9de1?w=300&h=200&fit=crop';
}

echo json_encode($petsData);

// Close connection
$conn->close();
?>