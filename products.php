<?php
include('aheader.php');
?>
<div class="container">
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Products</h4>
                </div>
                <div class="card-body" id="products_table">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $product = getAll("products");
                            if (mysqli_num_rows($product) > 0) {
                                foreach ($product as $item) {
                                    // Debug statement to check file path
                                    $imagePath = 'upload/' . htmlspecialchars($item['image']);
                                    if (file_exists($imagePath)) {
                                        $imageExists = 'Yes';
                                    } else {
                                        $imageExists = 'No';
                                    }
                                    ?>
                                    <tr>
                                        <td><?= $item['id']; ?></td>
                                        <td><?= $item['name']; ?></td>
                                        <td>
                                            <img src="<?= $imagePath; ?>" width="50px" height="50px" alt="<?= htmlspecialchars($item['name']); ?>">
                                            <br>
                                            <!-- Debugging info -->
                                            <small>Path: <?= $imagePath; ?> - Exists: <?= $imageExists; ?></small>
                                        </td>
                                        <td><?= $item['status'] == '0' ? "Visible" : "Hidden"; ?></td>
                                        <td>
                                            <a href="edit-product.php?id=<?= $item['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-danger delete_product_btn" value="<?= $item['id']; ?>">Delete</button>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "<tr><td colspan='5'>No records found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include('afooter.php');
?>