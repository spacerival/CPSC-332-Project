<?php
require 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PetMatch: Application</title>
    <link rel="stylesheet" href="form.css" />
    <script src="https://kit.fontawesome.com/9e304416f8.js" crossorigin="anonymous"></script>
  </head>
  <body>
    <div class="navbar">
      <a href="frontpage.php">PetMatch <i class="fa-solid fa-paw"></i></a>
      <a href="login_index.php">Login</a>
      <a href="signup.php">Sign Up</a>
      <a class="active" href="application.php">Application</a>
      <a href="searchpage.php">Adopt</a>
    </div>

    <div class="format">
      <h1>PetMatch Application</h1><br>
      <form action="process_application.php" method="POST">
        <label for="first_name">First Name</label>
        <input type="text" id="first_name" name="first_name"
          placeholder="Type here..." required>
        <label for="last_name">Last Name</label>
        <input type="text" id="last_name" name="last_name"
          placeholder="Type here..." required>
        <br><br>

        <label for="address">Address (Street Number + Name, City, Zipcode, Country) </label>
        <input type="text" id="address" name="address" size="75"
          placeholder="Type here..." required><br>
        <br>

        <label for="phone_number">Phone Number</label>
        <input type="tel" id="phone_number" name="phone_number" 
            pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" maxlength="10"
            placeholder="Type here..." required><br><br>
        <label for="email">Email</label>
        <input type="text" id="email" name="email" placeholder="Type here..." required>
        <br><br>
      

        <h2>Housing Information</h2>
        <p class="question"><b>What type of home do you currently live in?</b></p>
        <input type="radio" id="house" name="home_type" value="house" required>
        <label for="house">House</label><br>
        <input type="radio" id="apartment" name="home_type" value="apartment">
        <label  for="apartment">Apartment</label><br>
        <input type="radio" id="rv-trailer" name="home_type" value="rv-trailer">
        <label for="rv-trailer">RV/Trailer</label>
        
        <p class="question"><b>Do you rent or own?</b></p>
        <input type="radio" id="renter" name="rent_or_own" value="renter" required>
        <label for="renter">Yes, I do rent</label><br>
        <input type="radio" id="homeowner" name="rent_or_own" value="homeowner">
        <labelfor="homeowner">No, I own my home</label>

        <p class="question"><b>If you're <em>renting</em>, do you have permission from your landlord to keep pets?</b></p>
        <input type="radio" id="landlord-allowed" name="landlord_permission" value="landlord-allowed" required>
        <label for="landlord-allowed">Yes</label><br>
        <input type="radio" id="landlord-unallowed" name="landlord_permission" value="landlord-unallowed">
        <label for="landlord_unallowed">No</label><br>
        <input type="radio" id="landlord-inapplicable" name="landlord_permission" value="landlord-inapplicable">
        <label for="landlord_inapplicable">Inapplicable</label>


        <h2>Pet Experience</h2>
        <p class="question"><b>Have you owned a pet before?</b></p>
        <input type="radio" id="has_pet_experience" name="has_pet_experience" value="1" required>
        <label for="has_pet_experience">Yes, I have owned a pet before</label><br>
        <input type="radio" id="no_pet_experience" name="has_pet_experience" value="0">
        <label for="no_pet_experience">No, this is my first time</label>
      

        <p class="question"><b>If you <em>have</em> owned a pet before, what kinds? 
          <i>Please select all that apply.</i></b></p>
        <input type="checkbox" id="owned_dog" name="owned_dog" value="1">
        <label for="owned_dog">Dog</label><br>
        <input type="checkbox" id="owned_cat" name="owned_cat" value="1">
        <label for="owned_cat">Cat</label><br>
        <input type="checkbox" id="owned_bird" name="owned_bird" value="1">
        <label for="owned_bird">Bird</label><br>
        <input type="checkbox" id="owned_reptile" name="owned_reptile" value="1">
        <label for="owned_reptile">Reptile</label><br>
        <input type="checkbox" id="owned_rodent" name="owned_rodent" value="1">
        <label for="owned_rodent">Rodent</label><br>
        <input type="checkbox" id="owned_other" name="owned_other" value="1">
        <label for="owned_other">Other</label>

        <p class="question"><b>Do you currently have other pets?</b></p>
        <input type="radio" id="current_pet_owner" name="has_current_pets" value="1" required>
        <label for="has_pet_experience">Yes, I do</label><br>
        <input type="radio" id="not_pet_owner" name="has_current_pets" value="0">
        <label for="no_pet_experience">No, I don't</label>

        <p class="question"><b>If you <em>do</em> currently own pets, please describe them</b></p>
        <textarea id="current_pets_description" name="current_pets_description" rows="7" cols="75"></textarea>
        
        <h2>Household Information</h2>
        <label for="household_num">How many people currently live in your household?</label>
        <input type="number" id="household_num" name="household_num" placeholder="Type here..." required>

        <p class="question"><b>Do you have children?</b></p>
        <input type="radio" id="has_children" name="has_children" value="1" required>
        <label for="has_children">Yes, I do</label><br>
        <input type="radio" id="no_children" name="has_children" value="0">
        <label for="no_children">No, I don't</label>

        <!--Placeholder. Perhaps later have one input field ask how many children and 'x' amount of fields will
        pop up depending on the inputed value asking for the ages of each-->
        <p class="question"><b>If you <em>do</em> have children, please state how many and how old each of them are</b></p>
        <textarea id="children_description" name="children_description" rows="7" cols="75"></textarea>

        <h2>Adoption Questions</h2>
        <p class="question"><b>Which pet are you interested in adopting?</b></p>
        <input type="text" name="pet_id" placeholder="*later implement dropdown here*" size="25" required><br>
        <p><b>Why do you want to adopt this pet?</b></p>
        <textarea id="adoption_reason" name="adoption_reason" rows="7" cols="75" required></textarea>
        <br>
        <label for="hours_pet_alone">How many hours a day will the pet be alone?</label>
        <select name="hours_pet_alone" id="hours_pet_alone" required>
          <option value="">--- Select # of Hours ---</option>
          <option value="alone-02">0 - 2 hours</option>
          <option value="alone-35">3 - 5 hours</option>
          <option value="alone-68">6 - 8 hours</option>
          <option value="alone-9+">9+ hours</option>
        </select><br>
        <button type="submit">Submit Application</button>
      </form>
    </div>
    
  </body>
</html>

<!--
    Application Form:
    The following fields will be auto-filled if user already has an account:
      First Name + Last Name 
      Address
      Phone Number
      Email

    Home Type (Selection)
      House, Apartment, RV/Trailer, Other (input own type)
      Rent or own?
        If Renting, do you have landlord permission for pets? (Y/N)

    Pet Experience
      Have you owned a pet before(Y/N)
        If yes, what types? (checkbox of common types)
      Do you currently have other pets? (Y/N)
        If yes, describe them (text area)
      
      Household Info
        Number of people in household
        Do you have children? (Y/N)
          If so, how many? (#) How old are each of them? (#)

      Adoption Questions
        Which pet are you interested in adopting? (dropdown from database, not implemented yet)
        Why do you want to adopt this pet? (text area)
        How many hours a day will the pet be alone? (dropdown: 0-2, 3-5, 6-8, 8+)

      Admin End
        Application Date (auto-input)
        Application Status (pending, approved, rejected)


    -->