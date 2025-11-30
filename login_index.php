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
    <title>PetMatch: Login/Signup</title>
    <link rel="stylesheet" href="form.css" />
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
      <h1>PetMatch: Login</h1>
      <form action="process_login.php" method="POST">
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" required />
        <br />
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required />
        <br />
        <button type="submit">Login</button>
      </form>
      <p>Don't have an account? <a href="signup.html">Sign up here</a>.</p>
    </div>
  </body>
</html>
