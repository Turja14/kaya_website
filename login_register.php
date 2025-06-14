<?php

require('connection.php');
session_start();

// For login
if (isset($_POST['login'])) {
    $query = "SELECT * FROM registerted_user WHERE username='$_POST[username]'";
    $result = mysqli_query($con, $query);
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $result_fetch = mysqli_fetch_assoc($result);
            $role_as = $result_fetch['role_as'];

            if (password_verify($_POST['password'], $result_fetch['password'])) {
                // If matched
                $_SESSION['logged_in'] = true;
                $_SESSION['username'] = $result_fetch['username'];
                $_SESSION['role_as'] = $role_as;
                $_SESSION['image'] = $result_fetch['image'];
                if ($role_as == 1) {
                    header("location: index.php");
                } else {
                    header("location: kaya.php");
                }
            } else {
                // Password not matched
                echo "<script>alert('Incorrect password');
                window.location.href='kaya.php';
                </script>";
            }
        } else {
            echo "<script>alert('Username not registered');
            window.location.href='kaya.php';
            </script>";
        }
    } else {
        echo "<script>alert('Can't run query');
        window.location.href='kaya.php';
        </script>";
    }
}

// For registration
if (isset($_POST['register'])) {
    // Check if all required fields are set
    if (empty($_POST['username']) || empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['cpassword'])) {
        echo "<script>alert('Please fill in all required fields.'); window.location.href='kaya.php';</script>";
        exit;
    }

    // Validate if passwords match
    if ($_POST['password'] != $_POST['cpassword']) {
        echo "<script>alert('Passwords do not match.'); window.location.href='kaya.php';</script>";
        exit;
    }

    // Check if the username or email already exists
    $user_exist_query = "SELECT * FROM registerted_user WHERE username='$_POST[username]' OR email='$_POST[email]'";
    $result = mysqli_query($con, $user_exist_query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $result_fetch = mysqli_fetch_assoc($result);
            if ($result_fetch['username'] == $_POST['username']) {
                echo "<script>alert('Username already taken.');</script>";
            } else if ($result_fetch['email'] == $_POST['email']) {
                echo "<script>alert('Email already taken.');</script>";
            }
        } else {
            // Handle file upload
            if (!empty($_FILES['image']['name'])) {
                $image = $_FILES['image']['name'];
                $path = "upload";
                $image_ext = pathinfo($image, PATHINFO_EXTENSION);
                $filename = time() . '.' . $image_ext;

                if (!move_uploaded_file($_FILES['image']['tmp_name'], $path.'/'.$filename)) {
                    echo "<script>alert('Image upload failed.'); window.location.href='kaya.php';</script>";
                    exit;
                }
            } else {
                // If no image was uploaded, set filename to NULL or a default image
                $filename = null;  // or 'default.jpg' if you want to use a default image
            }

            // Hash password
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

            // Insert into the database
            $query = "INSERT INTO registerted_user (username, name, email, password, image) VALUES ('$_POST[username]', '$_POST[name]', '$_POST[email]', '$password', '$filename')";
            if (mysqli_query($con, $query)) {
                echo "<script>alert('Registration successful'); window.location.href='kaya.php';</script>";
            } else {
                echo "<script>alert('Database query failed.'); window.location.href='kaya.php';</script>";
            }
        }
    } else {
        echo "<script>alert('Database query failed.'); window.location.href='kaya.php';</script>";
    }
}
?>
