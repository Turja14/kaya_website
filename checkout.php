<?php
include('userfunction.php');
include('headerforothers.php');
include('authenticate.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" 
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link id="pagestyle" href="material-dashboard.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="style.css">
    <title>Cart</title>
    <style>
        .product-description {
            margin-top: 1rem;
        }
        .price-container {
            display: flex;
            justify-content: start;
            align-items: center;
            gap: 10rem;
        }
        .quantity-input {
            width: 100%;
            margin-left: 1px;
            max-width: 250px;
        }
        .btn-container {
            margin-left: 2px;
            display: flex;
        }
        .original_price {
            text-decoration: line-through;
        }
        p, #roww input {
            text-transform: none;
        }
        .container {
            margin-top: 80px;
            margin-bottom: 80px;
        }
        h5 {
            font-weight: bold;
        }
        .foott {
            margin-top: 80px;
        }
        .payment-images {
            display: none; /* Hide the image box initially */
            margin-top: 10px;
        }
        .payment-images img {
            width: 100px; /* Adjust the width as needed */
            height: auto; /* Maintain aspect ratio */
            margin-right: 10px; /* Space between images */
        }
    </style>
</head>
<body>
<div class="py-5">
    <div style="margin: 40px; min-width: 1240px;" class="container">
        <div class="card-body">
            <form id="checkout-form" action="placeorder.php" method="POST">
                <div class="row">
                    <div style="margin-right: 20px; max-width: 500px;" class="col-md-5">
                        <h5>Basic details</h5>
                        <hr>
                        <div class="row" id="roww">
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold" style="color: black;">Name</label>
                                <input type="text" name="name" placeholder="Enter full name" class="form-control"  style="border: solid 0.01px black; padding: 10px;">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold" style="color: black;">E-mail</label>
                                <input type="email" name="email" placeholder="Enter email" class="form-control" style="border: solid 0.01px black; padding: 10px;">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold" style="color: black;">Phone</label>
                                <input type="text" name="phone" placeholder="Enter phone number" class="form-control" style="border: solid 0.01px black; padding: 10px;">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold" style="color: black;">Pin code</label>
                                <input type="text" name="pincode" placeholder="Enter pin code" class="form-control" style="border: solid 0.01px black; padding: 10px;">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="fw-bold" style="color: black;">Address</label>
                                <textarea name="address" class="form-control" rows="5" style="border: solid 0.01px black; padding: 10px;"></textarea>
                            </div>
                        </div>
                    </div>
                    <div style="margin-left: 20px; max-width: 700px;" class="col-md-7">
                        <h5>Order Details</h5>
                        <hr>
                        <div style="display: flex;"><h5 class="col-md-4">Product</h5><h5 class="col-md-1">Price</h5><h5 class="col-md-1">Qty</h5><h5 class="col-md-1">Color</h5><h5 class="col-md-1">Size</h5><h5 class="col-md-4">Description</h5></div>
                        <?php 
                        $items = getCartItems();  
                        $totalPrice = 0;
                        foreach ($items as $citem) { 
                        ?>
                            <div class="mb-1" style="border: solid 0.01px black; border-radius: 2px; padding: 12px 10px;">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <img src="upload/<?= htmlspecialchars($citem['image']) ?>" alt="Image" width="60px">
                                    </div>
                                    <div class="col-md-2">
                                        <label style="color: black; margin-left: 20px;"><?= htmlspecialchars($citem['name']) ?></label>
                                    </div>
                                    <div class="col-md-1">
                                        <label style="color: black;"><?= htmlspecialchars($citem['selling_price']) ?></label>
                                    </div>
                                    <div class="col-md-1">
                                        <label style="color: black;"><?= htmlspecialchars($citem['prod_qty']) ?></label>
                                    </div>
                                    <div class="col-md-1">
                                        <label style="color: black;"><?= htmlspecialchars($citem['color']) ?></label>
                                    </div>
                                    <div class="col-md-1">
                                        <label style="color: black;"><?= htmlspecialchars($citem['size']) ?></label>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="product-description"><?= htmlspecialchars($citem['description']) ?></p>
                                    </div>
                                </div>
                            </div><hr>  
                        <?php 
                            $totalPrice += $citem['selling_price'] * $citem['prod_qty'];
                        }
                        ?>
                        <hr>
                        <h5 style="margin: 10px 60px;">Total Price: <span class="float-end fw-bold"><?= htmlspecialchars($totalPrice) ?></span></h5>
                        <div style="margin: 10px 40px;">
                            <label class="fw-bold">Payment Mode</label>
                            <div class="form-check">
                                <input type="radio" id="cod" name="payment_mode" value="COD" class="form-check-input" onclick="toggleImages()">
                                <label for="cod" class="form-check-label">COD</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" id="online_payment" name="payment_mode" value="Online Payment" class="form-check-input" onclick="toggleImages()">
                                <label for="online_payment" class="form-check-label">Online Payment</label>
                            </div>
                            
                            <!-- Box to show images -->
                            <div id="payment_images" class="payment-images">
                                <img src="bkash.png" alt="Payment Option 1" style="margin: 30px;">
                                <img src="nogod.png" alt="Payment Option 2" style="margin: 30px;">
                                <img src="rocket.png" alt="Payment Option 3" style="margin: 30px;">
                                <img src="upay.png" alt="Payment Option 4" style="margin: 30px;">
                                <img src="visa.png" alt="Payment Option 5" style="margin: 30px;">
                            </div>
                        </div>
                        <button type="submit" name="placeorderbtn" class="btn btn-primary w-100">Confirm</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="foott">
    <?php include('footer.php'); ?>
</div>
<script src="bootstrap.bundle.min.js"></script>
<script src="perfect-scrollbar.min.js"></script>
<script src="smooth-scrollbar.min.js"></script>
<script src="jquery-3.7.1.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
        function toggleImages() {
            var onlinePaymentRadio = document.getElementById('online_payment');
            var paymentImages = document.getElementById('payment_images');

            if (onlinePaymentRadio.checked) {
                paymentImages.style.display = 'block'; // Show the images
            } else {
                paymentImages.style.display = 'none'; // Hide the images
            }
        }
    </script>

</body>
</html>
