<?php
require 'config.php';
?>
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
            <!-- Pet cards will be populated by JavaScript -->
        </div>

        <p>Can't find what you're looking for? <a href="application.php">Submit an application</a> for specific requests.</p>
    </div>

    <script src="searchpage.js"></script>
</body>
</html>