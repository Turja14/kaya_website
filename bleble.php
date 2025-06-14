work on the customize button. pressing the button , it should be checked if the user is logged in. if not then show a meassage , if yes then open a form, where the user can choose color, size if required and add other destription along with add to cart option at the end. mention if i need to add any column in my database table cart or order... remember to add responsiveness.


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
            </style>
        </head>
        <body>
            <div class="bg-light py-4">
                <div class="container product_data">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="shadow">
                                <img src="upload/<?= $product['image']; ?>" alt="Product image" class="w-100">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h4 class="fw-bold"><?= $product['name']; ?>
                                <span class="float-end text-danger"><?php if($product['trending']) { echo "Trending"; } ?></span>
                            </h4>
                            <hr>
                            <p><?= $product['small_description']; ?></p>
                            <div class="price-container">
                                <h4><span class="text-success fw-bold"><?= $product['selling_price']; ?>Tk</span></h4>
                                <h4><s class="text-danger original_price"><?= $product['original_price']; ?>Tk</s></h4>                            </div>
                            <div class="row mt-3 mb-3 ml-0">
                                <div class="col-md-4">
                                        <div class="input-group mb-3" style="width: 130px;">
                                                <button class="input-group-text decrement-btn" style="margin-right: 130px; width: 20px; height: 30px;"><p style="margin-top: 10px; margin-left: 7px; font-weight: bold; font-size: 17px;">-</p></button>
                                                <input type="text" class="form-control text-center qty-input  bg-white" value="1" disabled>
                                                <button class="input-group-text increment-btn" style="width: 20px; height: 30px;"><p style="margin-top: 10px; margin-left: 7px; font-weight: bold; font-size: 17px;">+</p></button>
                                                </div>
                                </div>
                            </div>
                            <div class="row mb-3 btn-container">
                                <div class="col-md-6">
                                    <button class="btn btn-primary px-4 addtocartbtn" value="<?= $product['id']; ?>">Add to Cart</button>
                                </div>
                                <div class="col-md-6">
                                    <button class="btn btn-danger px-4">Add to Wishlist</button>
                                </div>
                            </div>
                            <div class="product-description">
                                <h5 fw-bold>Product Description:</h5>
                                <p><?= $product['description']; ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-danger px-4">Customize</button>
                            <?php
                            // Check if the user is logged in
                            if (isset($_SESSION['userID'])) {
                                // User is logged in, show the customization form
                                ?>
                                <div class="customize-form">
                                    <h5>Customize Your Product</h5>
                                    <form>
                                        <?php if ($product['has_color']) { ?>
                                            <label for="color">Color:</label>
                                            <select id="color" name="color">
                                                <?php foreach ($product['colors'] as $color) { ?>
                                                    <option value="<?php echo $color['id']; ?>"><?php echo $color['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        <?php } ?>
                                        <?php if ($product['has_size']) { ?>
                                            <label for="size">Size:</label>
                                            <select id="size" name="size">
                                                <?php foreach ($product['sizes'] as $size) { ?>
                                                    <option value="<?php echo $size['id']; ?>"><?php echo $size['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        <?php } ?>
                                        <label for="description">Additional Description:</label>
                                        <textarea id="description" name="description"></textarea>
                                        <button class="btn btn-primary" type="submit">Add to Cart</button>
                                    </form>
                                </div>
                                <?php
                            } else {
                                // User is not logged in, show a message
                                echo "Please log in to customize your product.";
                            }
                            ?>
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
                        if(value < 10)
                        {
                            value++;
                            
                            $(this).closest('.product_data').find('.qty-input').val(value);
                        }
                    });
                });

                $(document).ready(function () {
                    $('.decrement-btn').click(function (e) {
                        e.preventDefault();
                        var qty = $(this).closest('.product_data').find('.qty-input').val();
                        var value = parseInt(qty, 10);
                        value = isNaN(value) ? 0 : value;
                        if(value > 1)
                        {
                            value--;
                            
                            $(this).closest('.product_data').find('.qty-input').val(value);
                        }
                    });
                });

        $('.addtocartbtn').click(function(e) {  
                    e.preventDefault();
                    
                    var qty = $(this).closest('.product_data').find('.qty-input').val();
                    var prod_id = $(this).val();

                    $.ajax({
                    method: "POST",
                    url: "handlecart.php",
                    data: {
                        'prod_id': prod_id,
                        'prod_qty': qty,
                        'scope': "add"
                    },
                    success: function(response) {
                if(response == 201) {
                    alert("Product added to cart");
                } else if(response == "existing") {
                    alert("Already added");
                } else if(response == 401) {
                    alert("Login to continue");
                } else if(response == 500) {
                    alert("Something went wrong");
                }
            }
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
