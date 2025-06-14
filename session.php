<?php
include('connection.php');

$role_as = 0; // Default to non-admin

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $query = "SELECT role_as FROM registerted_user WHERE username = '$username'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $role_as = $row['role_as'];
    } else {
        echo "";
    }
} else {
    echo "";
}


?>
