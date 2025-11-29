<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetMatch: Find Your Perfect Pet</title>
    <link rel="stylesheet" href="searchpage.css">
    <script src="https://kit.fontawesome.com/9e304416f8.js" crossorigin="anonymous"></script>
</head>
<body>
    <!-- Background image container -->
    <div class="background-image"></div>

    <!-- Navigation bar -->
    <div class="navbar">
        <a href="frontpage.php">PetMatch <i class="fa-solid fa-paw"></i></a>
        <a href="login_index.php">Login</a>
        <a href="signup.php">Sign Up</a>
        <a href="application.php">Application</a>
        <a href="searchpage.php">Adopt</a>
    </div>

    <!-- Main content container -->
    <div class="content">
        <h1>Find Your Perfect Pet</h1>
        
        <!-- Search Section -->
        <div class="search-container">
            <input type="text" class="search-input" placeholder="Search by name, breed, or type..." id="searchInput">
            <i class="fas fa-search search-icon"></i>
        </div>

        <!-- Filter Buttons -->
        <div class="filter-buttons">
            <button class="filter-btn active" data-filter="all">All Pets</button>
            <button class="filter-btn" data-filter="dog">Dogs</button>
            <button class="filter-btn" data-filter="cat">Cats</button>
            <button class="filter-btn" data-filter="rabbit">Rabbits</button>
            <button class="filter-btn" data-filter="bird">Birds</button>
        </div>

        <!-- Pets Grid -->
        <div class="pets-grid" id="petsGrid">
            
        </div>

        <p>Can't find what you're looking for? <a href="application.php">Submit an application</a> for specific requests.</p>
    </div>

    <script>
       
        const pets = [
            <?php
            
            $servername = "localhost";
            $username = "root"; 
            $password = "";
            $dbname = "petmatcherDB";

            
            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT pet_id, name, animal_type, breed, age, status, description, city, state 
                    FROM pets WHERE status = 'available'";
            $result = $conn->query($sql);

            $petsData = array();
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {

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

            
            echo json_encode($petsData);
            
            
            $conn->close();

           
            function getPlaceholderImage($animalType) {
                $images = array(
                    'dog' => 'https://images.unsplash.com/photo-1552053831-71594a27632d?w=300&h=200&fit=crop',
                    'cat' => 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=300&h=200&fit=crop',
                    'rabbit' => 'https://images.unsplash.com/photo-1585110396000-c9ffd4e4b308?w=300&h=200&fit=crop',
                    'bird' => 'https://images.unsplash.com/photo-1552728089-57bdde30beb3?w=300&h=200&fit=crop'
                );
                
                return isset($images[$animalType]) ? $images[$animalType] : 'https://images.unsplash.com/photo-1543466835-00a7907e9de1?w=300&h=200&fit=crop';
            }
            ?>
        ];
    </script>

    <script src="searchpage.js"></script>
</body>
</html>