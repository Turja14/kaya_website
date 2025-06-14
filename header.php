<?php
include('session.php');

// Ensure the session is started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
    $name = $_SESSION['username']; // Assuming you store the user's ID in the session
    
    // Use a prepared statement to prevent SQL injection
    $query = "SELECT image FROM registerted_user WHERE username = ? LIMIT 1";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $profileImage = $user['image'];
    } else {
        $profileImage = null; // Set to null if no image found
    }
    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;700&display=swap" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" 
  integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  
  <link id="pagestyle" href="material-dashboard.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="product.css">
  <link rel="icon" href="favicon.jpg" type="image/x-icon">
</head>
<body>
  <div class="blurred-overlay" id="blurredOverlay"></div>
  <div class="box">
    <div class="conte">
      <header class="header">
        <a href="kaya.php" class="logo"><img src="logo.jpg"></a>
        <nav class="navi">
          <a href="kaya.php">Home</a>
          <a href="about.php">About</a>
          <a href="collections.php">Collections</a>
          <a href="album.php">Album</a>
          <a href="review.php">Reviews</a>
        </nav>
        <div class="icons">
          <form class="search-form" method="GET" action="search.php">
            <input type="text" name="query" id="find" placeholder="search here..." value="<?= isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>" onkeyup="search()" >
            <button type="submit" class="search-btn">
              <i class="fas fa-arrow-right"></i>
            </button>
            <!-- <label for="find" name="search_data_prod" class="fas fa-search"></label> -->
          </form>
          <a href="#" type="submit" onclick="search()"><i class='bx bx-search-alt-2' id='search-btn'></i></a>
          <a href="cart.php"><i class='bx bx-cart'>
              <?php if(isset($_SESSION['quantity']) && ($_SESSION['quantity'] != 0)){
                ?>
                <span class="cart-qty"><?php echo $_SESSION['quantity']; ?> </span>
                <?php } ?>
          </i></a>
          <div class="profile-container">
  <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true): ?>
    <input type="checkbox" id="dropdownToggle" class="dropdown-toggle-checkbox" />
    <label for="dropdownToggle" class="dropdown-toggle">
      <?php if (!empty($profileImage)): ?>
        <img src="upload/<?php echo htmlspecialchars($profileImage); ?>" alt="Profile Image" class="profile-image">
      <?php else: ?>
        <img src="images/pp.jpg" alt="Default Profile Image" class="profile-image">
      <?php endif; ?>
    </label>
    <div class="dropdown-menu">
      <a href="profile.php">Profile</a>
      <a href="logout.php">Logout</a>
    </div>
  <?php else: ?>
    <a href="#"><i class='bx bx-user'></i></a>
  <?php endif; ?>
</div>

          <div class="popup" id="loginPopup">
            <div class="close-button" id="closeLogin">&times;</div>
            <div class="form">
              <div class="button-box">
                <div id="bt"></div>
                <button type="but" class="tog-bt" onclick="login()">Log in</button>
                <button type="but" class="tog-bt" onclick="register()">Register</button>
              </div>
            </div>
            <form action="login_register.php" id="login" class="igrp" method="POST">
              <div class="form1">
                <div class="form-element" id="login">
                  <input type="text" id="email" placeholder="Enter username" style="text-transform: none;" required name="username">
                  <input type="password" id="password" placeholder="Enter password" style="text-transform: none;" required name="password">
                  <input type="checkbox" id="remember me"><span>Remember me</span>
                  <span class="font-element" id="fo"><a href="#" onclick="forgotPass()">Forgot password?</a></span>
                  <button type="submit" name="login">Login</button>
                </div>
             </form>
             <form action="login_register.php" id="reg" class="igrp" method="POST" enctype="multipart/form-data">
                <div class="form-element" id="login1">
                  <input type="text" id="username" placeholder="Enter username" style="text-transform: none;" required name="username">
                  <input type="text" id="name" placeholder="Enter name" style="text-transform: none;" required name="name">
                  <input type="text" id="email" placeholder="Enter email" style="text-transform: none;" required name="email">
                  <input type="password" id="password" placeholder="Enter password" style="text-transform: none;" required name="password">
                  <input type="password" id="password" placeholder="Confirm password" style="text-transform: none;" required name="cpassword">
                  <label for="file-upload" class="file-upload">Upload Image</label>
                      <input type="file" id="file-upload" name="image" class="file-upload-input">
                  <button type="submit" name="register">Sign Up</button>
                </div>
              </form>
            </div>
          </div>
          <a href="#"><i class="fas fa-bars" id="menu-btn"></i></a>
        </div>  
        <?php if ($role_as == 1): ?>
        <a href="index.php" class="btn btn-warning float-end" style="margin-top: 30px;">Admin</a>
      <?php endif; ?>
      </header>

      
    </body>
  </html>