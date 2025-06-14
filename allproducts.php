<?php
include('header.php');
include('myfunctions.php');
?>
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

                    if(mysqli_num_rows($products) > 0) {
                        foreach($products as $item) {
                            $imagePath = 'uploads/' . $item['image'];
                            $imageExists = file_exists($imagePath);
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
                                        <img src="<?= $imagePath; ?>" class="img-fluid" alt="<?= htmlspecialchars($item['name']); ?>">
                                        <p class="card-text">
                                            <?= $item['small_description']; ?><br>
                                            <h5 class="card-title"><?= $item['name']; ?></h5><br>
                                            <strong>Price: </strong> $<?= $item['selling_price']; ?><br>
                                            <strong>Quantity: </strong> <?= $item['qty']; ?><br>
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
