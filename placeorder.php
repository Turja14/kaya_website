<?php
require 'userfunction.php';
include('connection.php');


if(isset($_SESSION['logged_in'])) {
    if(isset($_POST['placeorderbtn'])) {
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $phone = mysqli_real_escape_string($con, $_POST['phone']);
        $pincode = mysqli_real_escape_string($con, $_POST['pincode']);
        $address = mysqli_real_escape_string($con, $_POST['address']);
        $payment_id = isset($_POST['payment_id']) ? mysqli_real_escape_string($con, $_POST['payment_id']) : null;
        
        $payment_mode = mysqli_real_escape_string($con, $_POST['payment_mode']);
        // $payment_id = mysqli_real_escape_string($con, $_POST['payment_id']);

        if($name == "" || $email == "" || $phone == "" || $pincode == "" || $address == "" || $payment_mode == "") {
            echo "<script>
            alert('All fields are mandatory');
            window.location.href='checkout.php';
            </script>";
            return;
        }

        $cartItems = getCartItems();
        $totalPrice = 0;
        foreach ($cartItems as $citem) { 
            $totalPrice += $citem['selling_price'] * $citem['prod_qty'];
        }

        $tracking_no = "kaya".rand(1111,9999).substr($phone, 2);
        $username = $_SESSION['username'];

        $insert_query = "INSERT INTO orders(tracking_no, username, email, phone, address, pincode, total_price, payment_mode, payment_id) VALUES ('$tracking_no', '$username', '$email', '$phone', '$address', '$pincode', '$totalPrice', '$payment_mode', '$payment_id')";
        $insert_query_run = mysqli_query($con, $insert_query);

        if($insert_query_run) {
            $order_id = mysqli_insert_id($con);
            foreach ($cartItems as $citem) {
                $prod_id = $citem['prod_id'];
                $prod_qty = $citem['prod_qty'];
                $price = $citem['selling_price'];

                $insert_items_query = "INSERT INTO order_items (order_id, prod_id, qty, price) VALUES ('$order_id', '$prod_id', '$prod_qty', '$price')";
                $insert_items_query_run = mysqli_query($con, $insert_items_query);

                $product_query = "SELECT * FROM products WHERE id='$prod_id' LIMIT 1";
                $product_query_run = mysqli_query($con, $product_query);
                $productData = mysqli_fetch_array($product_query_run);
                $current_qty = $productData['qty'];

                $new_qty = $current_qty - $prod_qty;
                $update_qty = "UPDATE products SET qty='$new_qty' WHERE id='$prod_id' ";
                $update_qty_run = mysqli_query($con, $update_qty);
            }

            $deleteCartQuery = "DELETE FROM carts WHERE username='$username'";
            $deleteCartQuery_run = mysqli_query($con, $deleteCartQuery);

            // Update the order_confirmed status for the user
            $update_user_query = "UPDATE registerted_user SET order_confirmed = TRUE WHERE username = '$username'";
            $update_user_query_run = mysqli_query($con, $update_user_query);

            $_SESSION['message'] = "Order placed successfully";
            header('Location: my-orders.php');
            die();
        } else {
            echo "<script>
            alert('Order placement failed. Please try again.');
            window.location.href='checkout.php';
            </script>";
        }
    }
} else {
    header('Location: kaya.php');
}
?>
