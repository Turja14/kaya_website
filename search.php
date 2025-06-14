<?php
session_start();

include('header.php');
?>

<div class="container">
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 style="text-align:center">Search Results</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                    <?php
                    if(isset($_GET['query']) && !empty($_GET['query'])) {
                        $searchQuery = mysqli_real_escape_string($con, $_GET['query']);
                        $query = "SELECT * FROM products WHERE name LIKE '%$searchQuery%' OR small_description LIKE '%$searchQuery%'";
                        $result = mysqli_query($con, $query);

                        if(mysqli_num_rows($result) > 0) {
                            while($item = mysqli_fetch_assoc($result)) {
                                $imagePath = 'uploads/' . htmlspecialchars($item['image']);
                                ?>
                                <div class="col-md-4 mb-3">
                                    <div class="card">
                                        <?php $imagePath = 'upload/' . htmlspecialchars($item['image']);
                                            if (file_exists($imagePath)) {
                                                $imageExists = 'Yes';
                                            } else {
                                                $imageExists = 'No';
                                            }
                                        ?>
                                        <div class="card-body">
                                            <img src="<?= file_exists($imagePath) ? $imagePath : 'default.jpg'; ?>" class="img-fluid" alt="<?= htmlspecialchars($item['name']); ?>">
                                            <p class="card-text">
                                                <?= htmlspecialchars($item['small_description']); ?><br>
                                                <h5 class="card-title"><?= htmlspecialchars($item['name']); ?></h5><br>
                                                <strong>Price: </strong> $<?= htmlspecialchars($item['selling_price']); ?><br>
                                                <strong>Quantity: </strong> <?= htmlspecialchars($item['qty']); ?><br>
                                                <strong>Status: </strong> <?= $item['status'] ? 'Active' : 'Inactive'; ?><br>
                                                <strong>Trending: </strong> <?= $item['trending'] ? 'Yes' : 'No'; ?><br>
                                            </p>
                                            <a href="view_product.php?product=<?= $item['slug']; ?>" class="btn btn-primary">View Details</a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo "<div class='col-md-12'><p>No Products Found</p></div>";
                        }
                    } else {
                        echo "<div class='col-md-12'><p>Please enter a search query</p></div>";
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
