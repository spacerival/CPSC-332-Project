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
    <title>PetMatch</title>
    <link rel="stylesheet" href="form.css" />
    <script src="https://kit.fontawesome.com/9e304416f8.js" crossorigin="anonymous"></script>
  </head>
  <body>
    <div class="background-image"></div>
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
    
    <div class="content">
      <h1>Your form has been successfully submitted!</h1>
      <p>Thank you for applying to adopt a pet! Your adoption application
        has been successfully submitted! We'll review your application and 
        contact you soon!</p>
      <button onclick="location.href='frontpage.php'">Return to Home</button>
      <button onclick="location.href='application.php'">Submit Another Application</button>
    </div>
    
  </body>
</html>