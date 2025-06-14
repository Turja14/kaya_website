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
        p {
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
    </style>
</head>
<body>
<div class="py-5">
    <div class="container">
        <div class="card card-body shadow">
            <div class="row">
                <div class="col-md-12">
                    <div id="mycart">
                        <?php 
                        $items = getCartItems();  

                        if ($items && count($items) > 0) {
                        ?>
                        <div class="card shadow-sm mb-4">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <h4>PRODUCT</h4>
                                </div>
                                <div class="col-md-1">
                                    <h4>Color</h4>
                                </div>
                                <div class="col-md-1">
                                    <h4>Size</h4>
                                </div>
                                <div class="col-md-2">
                                    <h4>Description</h4>
                                </div>
                                <div class="col-md-1">
                                    <h4>Price</h4>
                                </div>
                                <div class="col-md-2">
                                    <h4>Quantity</h4>
                                </div>
                                <div class="col-md-1">
                                    <h4>Remove</h4>
                                </div>
                            </div>
                        </div>
                        <?php
                            foreach ($items as $citem) { ?>
                                <div class="card product_data shadow-sm mb-3">
                                    <div class="row align-items-center">
                                        <div class="col-md-2">
                                            <img src="upload/<?= htmlspecialchars($citem['image']) ?>" alt="Image" width="100px">
                                        </div>
                                        <div class="col-md-2">
                                            <h4><?= htmlspecialchars($citem['name']) ?></h4>
                                        </div>
                                        <div class="col-md-1">
                                            <h4><?= htmlspecialchars($citem['color']) ?></h4>
                                        </div>
                                        <div class="col-md-1">
                                            <h4><?= htmlspecialchars($citem['size']) ?></h4>
                                        </div>
                                        <div class="col-md-2">
                                            <h4><?= htmlspecialchars($citem['description']) ?></h4>
                                        </div>
                                        <div class="col-md-1">
                                            <h4><?= htmlspecialchars($citem['selling_price']) ?> Tk</h4>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="input-group mb-3" style="width:130px">
                                                <input type="text" class="form-control text-center qty-input bg-white" value="<?= htmlspecialchars($citem['prod_qty']) ?>" style="font-size: 15px; font-weight: 400; margin-left: -40px;" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="btn btn-danger btn-sm deleteItem" value="<?= htmlspecialchars($citem['cid']) ?>" style="margin-left: 10px;">Remove</div>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                        ?>
                    </div>
                    <div class="float-end">
                        <a href="checkout.php" class="btn btn-primary">Proceed to checkout</a>
                    </div>
                    <?php
                    } else {
                    ?>
                        <div class="card card-body shadow text-center">
                            <h4 class="py-3">Your Cart is Empty</h4>
                        </div>
                    <?php
                    }
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="foott">
    <?php include('footer.php'); ?>
</div>
<script src="jquery-3.7.1.min.js"></script>
<script src="bootstrap.bundle.min.js"></script>
<script src="perfect-scrollbar.min.js"></script>
<script src="smooth-scrollbar.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    $(document).on('click','.updateQty', function () {
        var qty = $(this).closest('.product_data').find('.input-qty').val();
        var prod_id = $(this).val();
        $.ajax({
            method: "POST",
            url: "handlecart.php",
            data: {
                'prod_id': prod_id,
                'prod_qty': qty,
                'scope': "update"
            },
            success: function(response) {
                alert(response);
            }
        })
            
    })
    $(document).ready(function () {
        $('.increment-btn').click(function (e) {
            e.preventDefault();
            var $input = $(this).closest('.product_data').find('.input-qty');
            var value = parseInt($input.val(), 10);
            value = isNaN(value) ? 0 : value;
            if (value < 10) {
                value++;
                $input.val(value);
            }
        });

        $('.decrement-btn').click(function (e) {
            e.preventDefault();
            var $input = $(this).closest('.product_data').find('.input-qty');
            var value = parseInt($input.val(), 10);
            value = isNaN(value) ? 0 : value;
            if (value > 1) {
                value--;
                $input.val(value);
            }
        });

        $(document).on('click', '.updateQty', function() {
            var qty = $(this).closest('.product_data').find('.input-qty').val();
            var prod_id = $(this).closest('.product_data').find('.deleteItem').attr('value');
            $.ajax({
                method: "POST",
                url: "handlecart.php",
                data: {
                    'prod_id': prod_id,
                    'prod_qty': qty,
                    'scope': "update"
                },
                success: function(response) {
                    // Handle the response if necessary
                }
            });
        });

        $(document).on('click', '.deleteItem', function() {
            var cart_id = $(this).attr('value');
            $.ajax({
                method: "POST",
                url: "handlecart.php",
                data: {
                    'cart_id': cart_id,
                    'scope': "delete"
                },
                success: function(response) {
                    if (response == 200) {
                        alert("Deleted successfully");
                        $('#mycart').load(location.href + " #mycart");
                    } else {
                        alert(response);
                    }
                }
            });
        });

    });
</script>

</body>
</html>
