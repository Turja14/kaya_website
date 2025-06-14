<?php
session_start();
include 'header.php';
include 'connection.php'; // Include your database connection file

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit;
}

// Fetch user details from the database
$username = $_SESSION['username'];
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

// Fetch wishlist items
$wishlist_query = "SELECT * FROM user_wishlist WHERE username = '$username'";
$wishlist_result = mysqli_query($con, $wishlist_query);
$wishlists = mysqli_fetch_all($wishlist_result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Profile</title>
  <style>
    .profile-container1 {
      max-width: 1250px;
      margin-top: 20px;
      padding: 20px;
      text-align: center;
    }

    .profile-content {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 20px;
    }

    .profile-image1 {
      width: 150px;
      height: 150px;
      object-fit: cover;
      border-radius: 50%;
    }

    .profile-info1 {
      text-align: center;
      margin-top: 20px;
    }

    .profile-info1 p {
      font-size: 18px;
    }

    .profile-info1 label {
      font-size: 18px;
      font-weight: bold;
    }

    .userinfo {
      color: black;
      font-size: 24px;
      margin-bottom: 20px;
    }

    .edit-button {
      display: inline-block;
      padding: 10px 20px;
      font-size: 16px;
      color: #fff;
      background-color: #007bff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      text-decoration: none;
    }

    .edit-button:hover {
      background-color: #0056b3;
    }

    .heading3 {
      margin-top: 20px;
    }

    .wishlist-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 30px;
    }

    .wishlist-table th, .wishlist-table td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: left;
    }

    .wishlist-table th {
      background-color: #f4f4f4;
    }

    .wishlist-table td {
      font-size: 16px;
    }

    .action-buttons {
      display: flex;
      gap: 10px;
    }

    .action-buttons button, .action-buttons a {
      padding: 5px 10px;
      font-size: 14px;
      cursor: pointer;
      border: none;
      border-radius: 5px;
      text-decoration: none;
      color: #fff;
    }

    .action-buttons .btn-info {
      background-color: #17a2b8;
    }

    .action-buttons .btn-info:hover {
      background-color: #117a8b;
    }

    .action-buttons .btn-danger {
      background-color: #dc3545;
    }

    .action-buttons .btn-danger:hover {
      background-color: #c82333;
    }
  </style>
</head>
<body>
  <div class="profile-container1">
    <h3 class="userinfo">User Information</h3>
    
    <?php if (!empty($profileImage)): ?>
      <img src="upload/<?php echo htmlspecialchars($profileImage); ?>" alt="Profile Image" class="profile-image1">
    <?php else: ?>
      <img src="pp.jpg" alt="Default Profile Image" class="profile-image1">
    <?php endif; ?>
    
    <div class="profile-info1">
      <p><label>Username:</label> <?php echo htmlspecialchars($username); ?></p>
      <p><label>Name:</label> <?php echo htmlspecialchars($name); ?></p>
      <p><label>Email:</label> <?php echo htmlspecialchars($email); ?></p>
    </div>
    <br>
    <a href="edit_profile.php" class="edit-button">Edit Your Profile</a>

    <h3 class="heading3">Your Wishlists</h3>
    <table class="wishlist-table">
      <thead>
        <tr>
          <th>Product Image</th>
          <th>Product Name</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
  <?php if (!empty($wishlists)): ?>
    <?php foreach ($wishlists as $wishlist): ?>
      <tr data-id="<?php echo htmlspecialchars($wishlist['id']); ?>"> <!-- Use Wishlist ID -->
        <td><img src="upload/<?php echo htmlspecialchars($wishlist['product_image']); ?>" alt="Product Image" style="width: 100px; height: 100px; object-fit: cover;"></td>
        <td><?php echo htmlspecialchars($wishlist['product_name']); ?></td>
        <td class="action-buttons">
          <a href="view_product.php?product=<?php echo htmlspecialchars($wishlist['product_name']); ?>" class="btn btn-info">View</a>
          <button class="btn btn-danger remove-wishlist" value="<?= $wishlist['id'] ?>">Remove</button>
        </td>
      </tr>
    <?php endforeach; ?>
  <?php else: ?>
    <tr>
      <td colspan="3">No wishlists found.</td>
    </tr>
  <?php endif; ?>
</tbody>
    </table>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
     $(document).on('click', '.remove-wishlist', function() {
      var wish_id = $(this).attr('value');
            $.ajax({
                method: "POST",
                url: "handlewishlist.php",
                data: {
                    'wish_id': wish_id,
                    'scope': "delete"
                },
                success: function(response) {
                    if (response == 200) {
                        alert("Deleted successfully");
                        window.location.href='profile.php';
                    } else {
                        alert(response);
                    }
                }
            });
        });

    


    
  </script>
</body>
</html>

<?php
include 'footer.php';
?>
