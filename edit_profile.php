<?php
session_start();
include 'header.php';
include 'connection.php';

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit;
}

// Fetch user details from the database
$username = $_SESSION['username']; // Assuming you store the username in the session
$query = "SELECT * FROM registerted_user WHERE username = '$username' LIMIT 1";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    $profileImage = $user['image'];
    $name = $user['name'];
    $email = $user['email'];
} else {
    $profileImage = null;
    $name = '';
    $email = '';
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newName = $_POST['name'];
    $newEmail = $_POST['email'];
    $newPassword = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Initialize the updated image file name
    $newProfileImage = $profileImage; // Default to the old image if no new image is uploaded

    // Handle file upload
    if (!empty($_FILES['profile_image']['name'])) {
        $uploadDirectory = 'upload/';
        $fileName = basename($_FILES['profile_image']['name']);
        $fileTmpName = $_FILES['profile_image']['tmp_name'];
        $filePath = $uploadDirectory . $fileName;

        // Move uploaded file to the target directory
        if (move_uploaded_file($fileTmpName, $filePath)) {
            // Delete old profile image if it exists and is not the default
            if ($profileImage && $profileImage !== 'images/pp.jpg') {
                unlink($uploadDirectory . $profileImage);
            }
            $newProfileImage = $fileName;
        } else {
            $message = "Error uploading file.";
        }
    }

    // Prepare update query
    $updateQuery = "UPDATE registerted_user SET name = '$newName', email = '$newEmail', image = '$newProfileImage'";

    // Update password if provided and matching
    if (!empty($newPassword) && $newPassword === $confirmPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateQuery .= ", password = '$hashedPassword'";
    }

    $updateQuery .= " WHERE username = '$username'";
    $updateResult = mysqli_query($con, $updateQuery);

    if ($updateResult) {
        $message = "Profile updated successfully!";
    } else {
        $message = "Error updating profile: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Edit Profile</title>
  <style>
    .edit-profile-container {
      max-width: 800px;
      margin: 20px auto;
      padding: 20px;
      text-align: center;
    }

    .edit-profile-form {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .edit-profile-form label {
      font-weight: bold;
      margin-top: 10px;
      display: block;
      width: 100%;
      text-align: left;
    }

    .edit-profile-form input[type="text"],
    .edit-profile-form input[type="email"],
    .edit-profile-form input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ddd;
      border-radius: 5px;
      text-transform: none; /* Ensure text is not transformed */
    }

    .edit-profile-form button {
      padding: 10px 20px;
      font-size: 16px;
      color: #fff;
      background-color: #007bff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      margin-top: 20px;
    }

    .edit-profile-form button:hover {
      background-color: #0056b3;
    }

    .message {
      margin-bottom: 20px;
      font-size: 16px;
      color: #007bff;
    }

    .back-button {
      display: inline-block;
      padding: 10px 20px;
      font-size: 16px;
      color: #fff;
      background-color: #6c757d;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      text-decoration: none;
      margin-top: 10px;
    }

    .back-button:hover {
      background-color: #5a6268;
    }

    .profile-image2 {
      width: 150px;
      height: 150px;
      object-fit: cover;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <div class="edit-profile-container">
    <h2>Edit Profile</h2>
    
    <?php if (isset($message)): ?>
      <div class="message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    
    <form class="edit-profile-form" method="POST" enctype="multipart/form-data">
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" style="text-transform: none;" required>

      <label for="name">Name:</label>
      <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" style="text-transform: none;" required>
      
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" style="text-transform: none;" required>
      
      <label for="profile-image">Profile Picture:</label>
      <?php if ($profileImage && $profileImage !== 'default.jpg'): ?>
        <img src="upload/<?php echo htmlspecialchars($profileImage); ?>" alt="Profile Image" class="profile-image2">
      <?php endif; ?>
      <input type="file" id="profile-image2" name="profile_image">
      
      <label for="password">Password:</label>
      <input type="password" id="password" name="password">
      
      <label for="confirm_password">Confirm Password:</label>
      <input type="password" id="confirm_password" name="confirm_password">
      
      <button type="submit">Update</button>
    </form>
    
    <a href="profile.php" class="back-button">Back</a>
  </div>
</body>
</html>

<?php
include 'footer.php';
?>