# Project - Pet Adoption Website
PetMatch is a website connecting pets in need of a forever home with potential new owners. The website was created for our Files and Database course, with a focus on our use of SQL and PHP.

## Features
- Create an account that is immediately saved into a MySQL database.
- Login with a pre-existing account.
- Browse a catalogue of pets that dynamically changes depending on if a pet had been recently adopted.
- See how the website changes based on if the account is from a potential pet owner or an animal shelter.
  - Those looking for a new pet can submit an application for one from the catalogue
  - Animal shelters can approve or deny applications


## What is required to run?
1. Have MySQL installed
2. Have PHP installed
3. VSCode
4. Install the extension "PHP Intelephense" to run the code and see the website


## How to run
1. First, you'll need to set up configurations. Go to config_template.php and follow instructions on how to set up.
2. Set up the database locally by going into MySQL and copy and paste the contents of the "database.sql" file.
3. Once that is done, go to VSCode and to the "frontpage.php" file. Go to the blue PHP logo in the upper right hand corner of the window to "serve project", allowing you to see the website.
4. When you're done navigating the website, make sure to close the PHP Server. Go back to frontpage.php and right click anywhere in the file. Then in the dropdown, click "PHP Server: Stop Server".