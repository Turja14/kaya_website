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
        .foott{
            margin-top: 80px;
        }
    </style>
</head>
<body>
<div class="py-5">
    <div class="container" style="color: black;">
        <div class="">
            <div class="row">
                <div class="col-md-12">
                    <table class="table">
                        <thead style="border-bottom: 2px solid black;">
                            <tr>
                                <th>ID</th>
                                <th>Tracking No</th>
                                <th>Price</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $orders = getOrders();

                                if(mysqli_num_rows($orders) > 0)
                                {
                                    foreach ($orders as $item)
                                    {
                                        ?>
                                         <tr>
                                            <td> <?= $item['id']; ?> </td>
                                            <td> <?= $item['tracking_no']; ?> </td>
                                            <td> <?= $item['total_price']; ?> </td>
                                            <td> <?= $item['created_at']; ?> </td>
                                            <td> <a href="view-order.php?t=<?= $item['tracking_no']; ?>" class="btn btn-primary">View details </td>
                                        </tr>


                                        <?php

                                    }

                                }
                                else
                                {
                                    ?>
                                        <tr>
                                            <td colspan="5"> No orders yet </td>
                                            
                                        </tr>



                                     <?php
                                }


                            ?>
                           
                        </tbody>
                    </table>
                   
                </div>
            </div>
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
    $(document).ready(function () {
        $('.increment-btn').click(function (e) {
            e.preventDefault();
            var $input = $(this).closest('.product_data').find('.qty-input');
            var value = parseInt($input.val(), 10);
            value = isNaN(value) ? 0 : value;
            if (value < 10) {
                value++;
                $input.val(value);
            }
        });

        $('.decrement-btn').click(function (e) {
            e.preventDefault();
            var $input = $(this).closest('.product_data').find('.qty-input');
            var value = parseInt($input.val(), 10);
            value = isNaN(value) ? 0 : value;
            if (value > 1) {
                value--;
                $input.val(value);
            }
        });

        $(document).on('click','.updateQty', function(){

            var qty = $(this).closest('.product_data').find('.qty-input').val();
            var prod_id = $(this).closest('.product_data').find('.prodId').val();
            $.ajax({
                method: "POST",
                url: "handlecart.php",
                data: {
                    'prod_id': prod_id,
                    'prod_qty': qty,
                    'scope': "update"
            },
            success: function(response) {
            }

            });
        });

        $(document).on('click','.deleteItem', function(){
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
