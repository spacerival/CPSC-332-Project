<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$is_logged_in = isset($_SESSION['user_id']);
$user_name = $is_logged_in ? $_SESSION['name'] : '';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PetMatch: Sign Up</title>
    <link rel="stylesheet" href="signup.css" />
    <script src="https://kit.fontawesome.com/9e304416f8.js" crossorigin="anonymous"></script>
  </head>
  <body>
    <!-- Background image container -->
    <div class="background-image"></div>

    <!-- Navigation bar -->
    <div class="navbar">
      <a class="active" href="frontpage.php">PetMatch <i class="fa-solid fa-paw"></i></a>
      <a href="application.php">Application</a>
      <a href="searchpage.php">Adopt</a>
      <?php if (!$is_logged_in): ?>
        <a href="login_index.php">Login</a>
        <a href="signup.php">Sign Up</a>
      <?php else: ?>
        <a href="user_profile.php"><i class="fa-solid fa-circle-user"> 
          </i><?php echo htmlspecialchars($user_name); ?></a>
        <a href="logout.php">Logout</a>
      <?php endif; ?>
    </div>

    <!-- Main content container -->
    <div class="content">
      <h1>PetMatch: Profile Creation</h1>
      <form form action="process_signup.php" method="POST">
        <label for="name">First and Last Name:</label>
        <input type="text" id="name" name="name" required />
        <br />
        <!-- TO DO: Add a confirm password line. (having the user input the password twice to confirm) -->
        <!-- TO DO (optional, when have time): Make sure user inputs strong password -->
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required/>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required />
        <br />
        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" required />
        <br />
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required />
        <br />
        <label for="pet">Pet Interested In:</label>
        <input type="text" id="pet" name="pet" required />
        <br />
        <button type="submit">Submit Application</button>
      </form>
      <p>Already have an account? <a href="login_index.html">Login here</a>.</p>
    </div>
  </body>
</html>
