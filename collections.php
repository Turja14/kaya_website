<?php
include('userfunction.php');
include('header.php');
?>
<title>COLLECTIONS</title>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="text-center mt-4" style="color: black; border-bottom: 3px solid black; font-weight: bold; width: 500px; padding-bottom: 20px;">OUR COLLECTIONS</h1>
            </div>
        </div>
        <div class="row">
            <?php
            $categories = getAllActive2("categories");
            if (mysqli_num_rows($categories) > 0) {
                foreach ($categories as $item) {
                    ?>
                    <div class="filter-buttons1">
                        <a href="page_products.php?category=<?= htmlspecialchars($item['slug']); ?>">
                            <div class="card shadow">
                                <div class="card-body">
                                    <h3 class="text-center" style="color: black;"><?= htmlspecialchars($item['name']); ?></h3>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php
                }
            } else {
                echo "No data available";
            }
            ?>
        </div>
    </div>
</div>

<div class="container">
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 style="text-align:center">All Products</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php
                        $products = getAll("products");

                        if (mysqli_num_rows($products) > 0) {
                            foreach ($products as $item) {
                                $imagePath = 'upload/' . htmlspecialchars($item['image']);
                                ?>
                                <div class="col-md-4 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <img src="<?= htmlspecialchars($imagePath); ?>" class="img-fluid" alt="<?= htmlspecialchars($item['name']); ?>">
                                            <p class="card-text">
                                                <h5 class="card-title"><?= htmlspecialchars($item['name']); ?></h5><br>
                                                <strong>Price: </strong> $<?= htmlspecialchars($item['selling_price']); ?><br>
                                                <strong>Quantity: </strong> <?= htmlspecialchars($item['qty']); ?><br>
                                                <strong>Status: </strong> <?= $item['status'] ? 'Active' : 'Inactive'; ?><br>
                                                <strong>Trending: </strong> <?= $item['trending'] ? 'Yes' : 'No'; ?><br>
                                            </p>
                                            <a href="view_product.php?product=<?= htmlspecialchars($item['slug']); ?>" class="btn btn-primary">View Details</a>
                                            <!-- Add to Cart button -->
                                            <button class="btn btn-success" onclick="addToCart(<?= htmlspecialchars($item['id']); ?>)">Add to Cart</button>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo "<div class='col-md-12'><p>No Products Available</p></div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('footer.php');
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>

<script>
function addToCart(prod_id) {
    var color = $('#color').val();  // Get selected color
    var size = $('#size').val();    // Get selected size
    var description = $('#description').val();  // Get additional description

    $.ajax({
        method: "POST",
        url: "handlecart.php",
        data: {
            'prod_id': prod_id,
            'prod_qty': 1,  // Default quantity to 1
            'color': color,
            'size': size,
            'description': description,
            'scope': 'add'
        },
        success: function(response) {
            if (response == 201) {
                alert("Product added to cart");
            } else if (response == "existing") {
                alert("Product already in cart");
            } else if (response == 401) {
                alert("Please log in to add products to the cart");
            } else if (response == 500) {
                alert("Something went wrong. Try again later.");
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error: ", status, error);
            alert("An unexpected error occurred. Please try again.");
        }
    });
}

</script>
