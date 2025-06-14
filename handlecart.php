<?php
session_start();
include('connection.php');

if (isset($_SESSION['logged_in'])) {
    if (isset($_POST['scope'])) {
        $scope = $_POST['scope'];
        $username = $_SESSION['username'];

        switch ($scope) {
            case "add":
                $prod_id = $_POST['prod_id'];
                $prod_qty = $_POST['prod_qty'];

                $size = isset($_POST['size']) ? $_POST['size'] : null;  // Capture size from form
                $color = isset($_POST['color']) ? $_POST['color'] : null;  // Capture color from form

                $chk_existing_cart = "SELECT * FROM carts 
                                    WHERE prod_id='$prod_id' AND username='$username' 
                                    AND size='$size' AND color='$color'";

                $chk_existing_cart_run = mysqli_query($con, $chk_existing_cart);

                if (mysqli_num_rows($chk_existing_cart_run) > 0) {
                    echo "existing";
                } 
                else {
                    $insert_query = "INSERT INTO carts (username, prod_id, prod_qty, size, color) 
                    VALUES ('$username', '$prod_id', '$prod_qty', '$size', '$color')";

                    $insert_query_run = mysqli_query($con, $insert_query);
                    if ($insert_query_run) {
                        echo 201;
                    } else {
                        echo 500;
                    }
                }
                break;

            case "update":
                $prod_id = $_POST['prod_id'];
                $prod_qty = $_POST['prod_qty'];
                
                $size = isset($_POST['size']) ? $_POST['size'] : null;  // Capture size from form
                $color = isset($_POST['color']) ? $_POST['color'] : null;  // Capture color from form

                $chk_existing_cart = "SELECT * FROM carts 
                                    WHERE prod_id='$prod_id' AND username='$username' 
                                    AND size='$size' AND color='$color'";
                $chk_existing_cart_run = mysqli_query($con, $chk_existing_cart);

                if (mysqli_num_rows($chk_existing_cart_run) > 0) {
                    $update_query = "UPDATE carts SET prod_qty='$prod_qty'
                                    WHERE prod_id='$prod_id' AND username='$username' 
                                    AND size='$size' AND color='$color'";
                    $update_query_run = mysqli_query($con, $update_query);
                    if ($update_query_run) {
                        echo 200;
                    } else {
                        echo 500;
                    }
                } 
                else {
                    echo "Something went wrong";
                }
                break;

            default:
                echo 500;
            break;

            case "delete":
                $cart_id = $_POST['cart_id'];
                $chk_existing_cart = "SELECT * FROM carts WHERE id='$cart_id' AND username='$username'";
                $chk_existing_cart_run = mysqli_query($con, $chk_existing_cart); 

                if (mysqli_num_rows($chk_existing_cart_run) > 0) {
                    $delete_query = "DELETE FROM carts WHERE id='$cart_id' AND username='$username'";
                    $delete_query_run = mysqli_query($con, $delete_query);
                    if ($delete_query_run) {
                        echo 200;
                    } else {
                        echo "Something went wrong";
                    }
                } 
                else {
                    echo "Something went wrong";
                }
            break;

        }
    }
} 
else {
    echo 401;
}
?>
