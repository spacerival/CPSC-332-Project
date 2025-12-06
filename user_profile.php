<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login_index.php");
    exit();
}

$is_logged_in = isset($_SESSION['user_id']);
$user_name = $is_logged_in ? $_SESSION['name'] : '';

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['name'];
$user_email = $_SESSION['email'];
$user_type = $_SESSION['user_type'];

$sql = "SELECT name, email, phone, address, preferred_animal_type, created_at
        FROM users
        WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

$applications = [];
if ($user_type === 'adopter') {
    $sql = "SELECT i.inquiry_id, i.created_at, i.status, i.adoption_reason,
                   p.name as pet_name, p.animal_type, p.breed
            FROM inquiries i
            JOIN pets p on i.pet_id = p.pet_id
            WHERE i.adopter_id = ?
            ORDER BY i.created_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while($row = $result->fetch_assoc()) {
        $applications[] = $row;
    }
    $stmt->close();
} elseif ($user_type === 'agency') {
  $sql = "SELECT i.inquiry_id, i.created_at, i.status, i.adoption_reason,
                   i.first_name, i.last_name, i.email, i.phone_number, i.address,
                   i.home_type, i.rent_or_own, i.landlord_permission,
                   i.has_pet_experience, i.owned_dog, i.owned_cat, i.owned_bird, 
                   i.owned_reptile, i.owned_rodent, i.owned_other,
                   i.has_current_pets, i.current_pets_description,
                   i.household_num, i.has_children, i.children_description,
                   i.hours_pet_alone, i.adopter_id,
                   p.name as pet_name, p.animal_type, p.breed, p.pet_id
            FROM inquiries i
            JOIN pets p ON i.pet_id = p.pet_id
            WHERE p.agency_id = ?
            ORDER BY i.created_at DESC";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $applications[] = $row;
    }
    $stmt->close();
}

$conn->close();
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
    <div class="navbar">
      <a href="frontpage.php">PetMatch <i class="fa-solid fa-paw"></i></a>
      <a href="application.php">Application</a>
      <a href="searchpage.php">Adopt</a>
      <?php if (!$is_logged_in): ?>
        <a href="login_index.php">Login</a>
        <a href="signup.php">Sign Up</a>
      <?php else: ?>
        <a class="active" href="user_profile.php"><i class="fa-solid fa-circle-user"> 
          </i><?php echo htmlspecialchars($user_name); ?></a>
        <a href="logout.php">Logout</a>
      <?php endif; ?>
    </div>

    <div class="format">
        <h1>Hi there, <?php echo htmlspecialchars($user_name); ?>!</h1>

        <!-- User Info -->
        <table>
          <tr>
            <td><b>Name:</b> <?php echo htmlspecialchars($user['name']); ?></td>
          </tr>
          <tr>
            <td><b>Email:</b> <?php echo htmlspecialchars($user['email']); ?> </td>
          </tr>
          <tr>
            <td><b>Phone Number:</b> <?php echo htmlspecialchars($user['phone']); ?></td> 
          </tr>
          <tr>
            <td><b>Address:</b> <?php echo htmlspecialchars($user['address']); ?></td>
          </tr>
          <?php if($user_type === 'adopter'): ?>
            <tr>
              <td><b>Preferred Animal:</b> <?php echo htmlspecialchars($user['preferred_animal_type']); ?> </td>   
            </tr>
          <?php endif; ?>
          <tr>
            <td><b>PetMatch Member Since:</b> <?php echo date('F j, Y', strtotime($user['created_at'])); ?></td>
          </tr>
        </table>
        <br><br>
        
        <!-- User Applications -->
        <?php if ($user_type === 'adopter'): ?>
          <h2>Your Applications</h2>
            <?php if (count($applications) > 0): ?>
            <?php foreach ($applications as $app): ?>
            <h3><?php echo htmlspecialchars($app['pet_name']); ?> 
                (<?php echo htmlspecialchars($app['animal_type']); ?>)</h3>
                <p><b>Breed:</b> <?php echo htmlspecialchars($app['breed']); ?></p>
                <p><b>Applied:</b> <?php echo date('F j, Y', strtotime($app['created_at'])); ?></p>
                <p><b>Status:</b> 
                    <span class="status <?php echo $app['status']; ?>">
                        <?php echo strtoupper(str_replace('_', ' ', $app['status'])); ?>
                    </span>
                </p>
                <p><b>Why I want to adopt:</b><br>
                <?php echo htmlspecialchars(substr($app['adoption_reason'], 0, 150)); ?>
                <?php echo strlen($app['adoption_reason']) > 150 ? '...' : ''; ?>
            </p>
            <?php endforeach; ?>
        <?php else: ?>
            <p>You haven't submitted any applications yet.</p>
            <button class="small_button" onclick="location.href='application.php'">Click here to submit your first application!</button>
        <?php endif; ?>


        <!-- Agency View -->
        <?php elseif ($user_type === 'agency'): ?>
          <h2>Pending Adoption Applications</h2>
          
          <?php if (count($applications) > 0): ?>
            <?php foreach($applications as $app): ?>
              <h3>Application for: <?php echo htmlspecialchars($app['pet_name']); ?> 
                  (<?php echo htmlspecialchars($app['animal_type']); ?> - <?php echo htmlspecialchars($app['breed']); ?>)</h3>
              <h4>Applicant Info:</h4>
              <p><b>Name:</b> <?php echo htmlspecialchars($app['first_name'] . ' ' . $app['last_name']); ?></p>
              <?php if ($app['adopter_id'] !== NULL): ?>
                <em>(Registered User)</em>
              <?php else: ?>
                <em>(Guest Application)</em>
              <?php endif; ?>
              <p><b>Email:</b> <?php echo htmlspecialchars($app['email']); ?></p>
              <p><b>Phone:</b> <?php echo htmlspecialchars($app['phone_number']); ?></p>
              <p><b>Applied:</b> <?php echo date('F j, Y g:i A', strtotime($app['created_at'])); ?></p>
              <br>

              <h4><i class="fa-solid fa-house"></i> Housing Information</h4>
              <p><b>Home Type:</b> <?php echo htmlspecialchars(ucfirst($app['home_type'] ?? 'Not specified')); ?></p>
              <p><b>Rent or Own:</b> <?php echo htmlspecialchars(ucfirst($app['rent_or_own'] ?? 'Not specified')); ?></p>
              <p><b>Landlord Permission:</b> 
                <?php 
                $permission = $app['landlord_permission'] ?? '';
                if ($permission === 'landlord-allowed') echo 'Yes';
                elseif ($permission === 'landlord-unallowed') echo 'No';
                elseif ($permission === 'landlord-inapplicable') echo 'Not Applicable (Homeowner)';
                else echo 'Not specified';
                ?>
              </p>
              <br>

              <h4><i class="fa-solid fa-cat"></i><i class="fa-solid fa-dog"></i> Pet Experience</h4>
              <p><b>Has owned pets before:</b> <?php echo $app['has_pet_experience'] ? 'Yes' : 'No'; ?></p>
              <?php if ($app['has_pet_experience']): ?>
                <p><b>Previously owned:</b>
                  <?php
                  $owned_types = [];
                  if ($app['owned_dog']) $owned_types[] = 'Dog';
                  if ($app['owned_cat']) $owned_types[] = 'Cat';
                  if ($app['owned_bird']) $owned_types[] = 'Bird';
                  if ($app['owned_reptile']) $owned_types[] = 'Reptile';
                  if ($app['owned_rodent']) $owned_types[] = 'Rodent';
                  if ($app['owned_other']) $owned_types[] = 'Other';
                            
                  echo count($owned_types) > 0 ? htmlspecialchars(implode(', ', $owned_types)) : 'None specified';
                  ?>
                </p>
              <?php endif; ?>
              <p><b>Currently has pets:</b> <?php echo $app['has_current_pets'] ? 'Yes' : 'No'; ?></p>
              <?php if ($app['has_current_pets'] && !empty($app['current_pets_description'])): ?>
                <p><b>Current pets description:</b><br>
                <?php echo nl2br(htmlspecialchars($app['current_pets_description'])); ?></p>
              <?php endif; ?>
              <br>

              <h4><i class="fa-solid fa-people-roof"></i> Household Information</h4>
              <p><b>Number of people in household:</b> <?php echo (int)$app['household_num']; ?></p>
              <p><b>Has children:</b> <?php echo $app['has_children'] ? 'Yes' : 'No'; ?></p>
              <?php if ($app['has_children'] && !empty($app['children_description'])): ?>
                <p><b>Children details:</b><br>
                <?php echo nl2br(htmlspecialchars($app['children_description'])); ?></p>
              <?php endif; ?>
              <br>

              <h4><i class="fa-solid fa-clipboard-question"></i> Adoption Details</h4>
              <p><strong>Hours pet will be alone daily:</strong> 
              <?php 
              $hours = $app['hours_pet_alone'] ?? '';
              if ($hours === 'alone-02') echo '0-2 hours';
              elseif ($hours === 'alone-35') echo '3-5 hours';
              elseif ($hours === 'alone-68') echo '6-8 hours';
              elseif ($hours === 'alone-9+') echo '9+ hours';
              else echo 'Not specified';
              ?>
              </p>
              <p><b>Why they want to adopt:</b><br>
                  <?php echo nl2br(htmlspecialchars($app['adoption_reason'])); ?>
              </p>
              <br>
              <p><b>Current Status:</b> 
                  <span class="status-badge <?php echo $app['status']; ?>">
                      <?php echo strtoupper(str_replace('_', ' ', $app['status'])); ?>
                  </span>
              </p>
              
                    
              <?php if ($app['status'] === 'new' || $app['status'] === 'in_progress'): ?>
              <form method="POST" action="update_application_status.php" style="display: inline;">
                <input type="hidden" name="inquiry_id" value="<?php echo $app['inquiry_id']; ?>">
                <input type="hidden" name="new_status" value="in_progress">
                <button type="submit" class="small_button in_progress">Mark as In Progress</button>
              </form>
              <br>
                        
              <form method="POST" action="update_application_status.php" style="display: inline;">
                <input type="hidden" name="inquiry_id" value="<?php echo $app['inquiry_id']; ?>">
                <input type="hidden" name="new_status" value="closed">
                <input type="hidden" name="approved" value="1">
                <button type="submit" class="small_button approve">Approve Application</button>
              </form>
              <br>
                        
              <form method="POST" action="update_application_status.php" style="display: inline;">
                <input type="hidden" name="inquiry_id" value="<?php echo $app['inquiry_id']; ?>">
                <input type="hidden" name="new_status" value="closed">
                <input type="hidden" name="approved" value="0">
                <button type="submit" class="small_button deny">Deny Application</button>
              </form>
              <br>
              <?php else: ?>
                <p><em>This application has been processed.</em></p><br>
              <?php endif; ?>
            <br><br>
            <?php endforeach; ?>
            <?php else: ?>
              <p>No applications have been submitted yet.</p>
            <?php endif; ?>
      <?php endif; ?>
    </div>
  </body>
</html>