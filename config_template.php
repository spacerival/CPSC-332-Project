<?php
// config.example.php - Template for database configuration
// INSTRUCTIONS: Copy this to a new file called 'config.php' and add your MySQL password
//               Make sure you pulled the ".gitignore" file with config.php inside it already!

define('DB_HOST', 'localhost');
define('DB_NAME', 'petmatcherDB');
define('DB_USER', 'root');
define('DB_PASS', '');  // input your password here! 

/*
    =============================================
    IMPORTANT(!): Do NOT commit this file with your
                  real password to GitHub.

                  Include the non-template file name,
                  "config.php" in your .gitignore file.
                  You'll know it worked when config.php's text
                  is grayed out under the explorer sidebar 
                  in VScode

                  Each of us will have our own password to 
                  our own local database. So protect it!
    =============================================

*/

?>