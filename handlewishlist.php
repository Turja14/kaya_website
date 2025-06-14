<?php
session_start();
include('connection.php');

if (isset($_SESSION['logged_in'])) {
    if (isset($_POST['scope'])) {
        $scope = $_POST['scope'];
        $username = $_SESSION['username'];

        switch ($scope) {
            case "add":
                if (isset($_POST['prod_id'], $_POST['prod_name'], $_POST['prod_image'])) {
                    $prod_id = $_POST['prod_id'];
                    $prod_name = $_POST['prod_name'];
                    $prod_image = $_POST['prod_image'];

                    // Check if product already exists in wishlist
                    $chk_existing_wish = "SELECT * FROM user_wishlist WHERE id='$prod_id' AND username='$username'";
                    $chk_existing_wish_run = mysqli_query($con, $chk_existing_wish);

                    if (mysqli_num_rows($chk_existing_wish_run) > 0) {
                        echo "existing";
                    } else {
                        // Insert into wishlist
                        $insert_query = "INSERT INTO user_wishlist (username, product_name, product_image) 
                                         VALUES ('$username', '$prod_name', '$prod_image')";
                        $insert_query_run = mysqli_query($con, $insert_query);

                        if ($insert_query_run) {
                            echo 201;
                        } else {
                            echo 500;
                        }
                    }
                } else {
                    echo 400; // Bad request, data missing
                }
                break;

                case "delete":
                    $wish_id = $_POST['wish_id'];
                    $chk_existing_cart = "SELECT * FROM user_wishlist WHERE id='$wish_id' AND username='$username'";
                    $chk_existing_cart_run = mysqli_query($con, $chk_existing_cart); 
    
                    if (mysqli_num_rows($chk_existing_cart_run) > 0) {
                        $delete_query = "DELETE FROM user_wishlist WHERE id='$wish_id' AND username='$username'";
                        $delete_query_run = mysqli_query($con, $delete_query);
                        if ($delete_query_run) {
                            echo 200;
                        } else {
                            echo "Something went wrong";
                        }
                    } 
                    else {
                        echo "Something went wrong1";
                    }
                break;
    
            }
        }
    } 
    else {
        echo 401;
    }
?>
