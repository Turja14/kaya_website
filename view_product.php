<?php
include('userfunction.php');
include('headerforothers.php');

if(isset($_GET['product']))
{
    $product_slug = $_GET['product'];
    $product_data = getSlugActive("products", $product_slug);
    $product = mysqli_fetch_array($product_data);

    if($product)
    {
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
            <title><?= $product['name']; ?> - Product Details</title>
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
                    margin-left: 1px ;
                    max-width: 250px;
                }
                .btn-container {
                    margin-left: 2px ;
                    display: flex;
                    gap: 10px;
                }
                .original_price{
                    text-decoration: line-through;
                }
                p{
                    text-transform: none;
                }
                .container{
                    margin-top: 80px;
                    margin-bottom: 80px;
                }
                h5{
                    font-weight: bold;
                }
                form{
                    font-size: 12px;
                    font-weight: 600;
                    }
                .size-select{
                    display: flex;
                    align-items: center;
                    margin: 20px;
                }
                .size-select p{
                    width: 70px;
                }
                .size-select input:checked + span{
                    color: blue;
                    font-weight: 800;
                }
                .size-select span{
                    padding: 5px;
                    margin-right : 10px;
                    cursor: pointer;
                }
                .color-select{
                    display: flex;
                    align-items: center;
                    margin: 20px;
                }
                .color-select p{
                    width: 75px;
                }
                .color-select span{
                    display: inline-block;
                    width: 15px;
                    height: 15px;
                    border-radius: 50%;
                    margin-right: 15px;
                    cursor: pointer;
                }
                .color-1{
                    background: red;
                }
                .color-2{
                    background: green;
                }
                .color-3{
                    background: blue;
                }
                .color-select input{
                    display: none;
                }
                .color-select input:checked + span{
                    transform: scale(0.7);
                    box-shadow: 0 0 0 4px white, 0 0 0 6px black;
                }
            </style>
        </head>
        <body>
            <div class="bg-light py-4">
                <div class="container product_data">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="shadow">
                                <img src="upload/<?= $product['image']; ?>" alt="Product image" class="w-100">
                            </div>
                        </div>
                        <div class="col-md-8" style="margin-left: 20px;">
                            <h4 class="fw-bold"><?= $product['name']; ?>
                                <span class="float-end text-danger"><?php if($product['trending']) { echo "Trending"; } ?></span>
                            </h4>
                            <hr>
                            <p><?= $product['small_description']; ?></p>
                            <div class="price-container">
                                <h4><span class="text-success fw-bold"><?= $product['selling_price']; ?>Tk</span></h4>
                                <h4><s class="text-danger original_price"><?= $product['original_price']; ?>Tk</s></h4>
                            </div>

                            <!-- Quantity input -->
                            <div class="row mt-3 mb-3">
                                <div class="col-md-4">
                                    <div class="input-group mb-3">
                                        <button class="btn btn-outline-secondary decrement-btn" type="button">-</button>
                                        <input type="text" class="form-control text-center qty-input" value="1" disabled>
                                        <button class="btn btn-outline-secondary increment-btn" type="button">+</button>
                                    </div>
                                </div>
                            </div>

                            <form action="handlecart.php" method="POST">
                                <?php if($product_slug === 'punjabi'): ?>    
                                    <div class="size-select">
                                        <p>Size</p>
                                        <label for="small">
                                            <input type="radio" name="size" id="small" value="small">
                                            <span>S</span>
                                        </label>
                                        <label for="medium">
                                            <input type="radio" name="size" id="medium" value="medium">
                                            <span>M</span>
                                        </label>
                                        <label for="large">
                                            <input type="radio" name="size" id="large" value="large">
                                            <span>L</span>
                                        </label>
                                        <label for="x-large">
                                            <input type="radio" name="size" id="x-large" value="x-large">
                                            <span>XL</span>
                                        </label>
                                        <label for="xx-large">
                                            <input type="radio" name="size" id="xx-large" value="xx-large">
                                            <span>XXL</span>
                                        </label>
                                        <label for="xxx-large">
                                            <input type="radio" name="size" id="xxx-large" value="xxx-large">
                                            <span>XXXL</span>
                                        </label>
                                    </div>
                                <?php endif; ?>
                                <div class="color-select">
                                    <p>Color :</p>
                                    <label for="red">
                                        <input type="radio" name="color" id="red" value="red">
                                        <span class="color-1"></span>
                                    </label>
                                    <label for="green">
                                        <input type="radio" name="color" id="green" value="green">
                                        <span class="color-2"></span>
                                    </label>
                                    <label for="blue">
                                        <input type="radio" name="color" id="blue" value="blue">
                                        <span class="color-3"></span>
                                    </label>
                                </div>
                                <!--<div class="description">
                                    <p>Any Other Request:</p>
                                    <textarea name="description" id="description" rows="4" style="width:100%;" placeholder="Enter any special requests or instructions..."></textarea>
                                </div> -->
                            </form>

                            <div class="row mb-3 btn-container">
                                <!-- Add to Wishlist button -->
                                <div class="col-md-3">
                                    <button class="btn btn-danger px-4 addtowishlistbtn" value="<?= $product['id']; ?>">Add to Wishlist</button>
                                </div>
                                <!-- Add to Cart button -->
                                <div class="col-md-3">
                                    <button class="btn btn-success px-4 addtocartbtn" value="<?= $product['id']; ?>">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include('footer.php'); ?>
        </body>

        <script src="bootstrap.bundle.min.js"></script>
        <script src="perfect-scrollbar.min.js"></script>
        <script src="smooth-scrollbar.min.js"></script>
        <script src="jquery-3.7.1.min.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <script>
        $(document).ready(function () {
        
    $('.increment-btn').click(function (e) {
        e.preventDefault();
        var qty = $(this).closest('.product_data').find('.qty-input').val();
        var value = parseInt(qty, 10);
        value = isNaN(value) ? 0 : value;
        if(value < 10) {
            value++;
            $(this).closest('.product_data').find('.qty-input').val(value);
        }
    });

    $('.decrement-btn').click(function (e) {
        e.preventDefault();
        var qty = $(this).closest('.product_data').find('.qty-input').val();
        var value = parseInt(qty, 10);
        value = isNaN(value) ? 0 : value;
        if(value > 1) {
            value--;
            $(this).closest('.product_data').find('.qty-input').val(value);
        }
    });

    $('.addtocartbtn').click(function () {
        var prod_id = $(this).val();
        var prod_qty = $('.qty-input').val();
        var color = $("input[name='color']:checked").val();
        var size = $("input[name='size']:checked").val();
        var description = $('#description').val();

        console.log('Sending data:', {
            'prod_id': prod_id,
            'prod_qty': prod_qty,
            'color': color,
            'size': size,
            'description': description,
            'scope': 'add'
        });

        $.ajax({
            method: "POST",
            url: "handlecart.php",
            data: {
                'prod_id': prod_id,
                'prod_qty': prod_qty,
                'color': color,
                'size': size,
                'description': description,
                'scope': 'add'
            },
            success: function(response) {
                console.log('Response:', response);
                if(response == 201) {
                    alert("Product added to cart");
                } else if(response == "existing") {
                    alert("Product already in cart");
                } else if(response == 401) {
                    alert("Please log in to add products to the cart");
                } else if(response == 500) {
                    alert("Something went wrong. Try again later.");
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: ", status, error);
                alert("An unexpected error occurred. Please try again.");
            }
        });
    });
});



            $(document).ready(function () {
                $('.addtowishlistbtn').click(function(e) {  
                    e.preventDefault();
                    
                    // Retrieve product information
                    var prod_id = $(this).val();
                    var prod_name = "<?= $product['name']; ?>";  // Product name injected using PHP
                    var prod_image = "<?= $product['image']; ?>"; // Product image injected using PHP

                    // AJAX request
                    $.ajax({
                        method: "POST",
                        url: "handlewishlist.php",
                        data: {
                            'prod_id': prod_id,
                            'prod_name': prod_name,   // Sending product name
                            'prod_image': prod_image, // Sending product image
                            'scope': 'add'            // Important: You are missing the 'scope' field!
                        },
                        success: function(response) {
                            if(response == 201) {
                                alert("Product added to wishlist");
                            } else if(response == "existing") {
                                alert("Product already in wishlist");
                            } else if(response == 401) {
                                alert("Please log in to continue");
                            } else if(response == 500) {
                                alert("An error occurred. Please try again later.");
                            } else if(response == 404) {
                                alert("Product not found");
                            } else if(response == 400) {
                                alert("Invalid request");
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error: ", status, error);
                            alert("An unexpected error occurred. Please try again.");
                        }
                    });
                });
            });
        </script>
        </html>
        <?php
    }
    else
    {
        echo "Product not found";
    }
}
else
{
    echo "Something went wrong";
}
?>
