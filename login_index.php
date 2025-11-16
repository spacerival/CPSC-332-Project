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
      <a href="frontpage.html">PetMatch <i class="fa-solid fa-paw"></i></a>
      <a class="active" href="login_index.html">Login</a>
      <a href="signup.html">Sign Up</a>
      <a href="application.html">Application</a>
    </div>

    <!-- Main content container -->
    <div class="content">
      <h1>PetMatch: Login</h1>
      <form>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required />
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
