<?php

include('aheader.php');
include('connection.php');

?>
<div class="container">
    <div class="row mt-4">
        <div class="col-md-12">
            <?php
                if(isset($_GET['id']))
                {
                    $id = $_GET['id'];
                    $product = getByID("products",$id);

                    if(mysqli_num_rows($product) > 0)
                    {
                        $data = mysqli_fetch_array($product);
                        ?>
                            <div class="card">
                                <div class="card-header">
                                    <h4>Edit Product</h4>
                                    <a href="products.php" class="btn btn-primary float-end">Back</a>
                                </div>
                                <div class="card-body">
                                    <form action="code.php" method="POST" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label class="mb-2">Select Category</label>
                                                <select name="category_id" class="form-select">
                                                    <option selected>Select Category</option>
                                                    <?php
                                                        $categories = getAll("categories");

                                                        if(mysqli_num_rows($categories) > 0)
                                                        {
                                                            foreach($categories as $item) {
                                                                ?>
                                                                    <option value="<?= $item['id']; ?>"<?= $data['category_id'] == $item['id']?'selected':''?> ><?= $item['name']; ?></option>
                                                                <?php
                                                            }
                                                        } 
                                                        else {
                                                            echo "No Category Available";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <input type="hidden" name="product_id" value="<?= $data['id']; ?>">
                                            <div class="col-md-6 mb-3">
                                                <label class="mb-0">Name</label>
                                                <input type="text"  name="name" value="<?= $data['name']; ?>" class="form-control mb-2">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="mb-0">Slug</label>
                                                <input type="text" name="slug" value="<?= $data['slug']; ?>" class="form-control mb-2">
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="mb-0">Small Description</label>
                                                <textarea rows="3" name="small_description" class="form-control mb-2"><?= $data['small_description']; ?></textarea>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="mb-0">Description</label>
                                                <textarea rows="3" name="description" class="form-control mb-2"><?= $data['description']; ?></textarea>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="mb-0">Original Price</label>
                                                <input type="text" name="original_price" value="<?= $data['original_price']; ?>" class="form-control mb-2">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="mb-0">Selling Price</label>
                                                <input type="text" name="selling_price" value="<?= $data['selling_price']; ?>" class="form-control mb-2">
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="mb-0">Upload Image</label>
                                                <input type="hidden" name="old_image" value="<?= $data['image']; ?>">
                                                <input type="file" name="image" class="form-control mb-2">
                                                <label class="mb-0">Current Image</label>
                                                <img src="../upload/<?= $data['image']; ?>" alt="Product Image" height="50px" width="50px">
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label class="mb-0">Quantity</label>
                                                    <input type="number" value="<?= $data['qty']; ?>" name="qty" class="form-control mb-2">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="mb-0">Status</label><br>
                                                    <input type="checkbox" <?= $data['status'] == '0'?'':'checked'; ?> name="status">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="mb-0">Trending</label><br>
                                                    <input type="checkbox" <?= $data['status'] == '0'?'':'checked'; ?> name="trending">
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="mb-0">Meta title</label>
                                                <input type="text" name="meta_title" value="<?= $data['meta_title']; ?>" class="form-control mb-2">
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="mb-0">Meta Keywords</label>
                                                <textarea rows="3" name="meta_keywords" class="form-control mb-2"><?= $data['meta_keywords']; ?></textarea>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="mb-0">Meta Description</label>
                                                <textarea rows="3" name="meta_description" class="form-control mb-2"><?= $data['meta_description']; ?></textarea>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <button type="submit" class="btn btn-primary" name="update_product_btn">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <?php
                    }
                    else
                    {
                        echo "Product not found";
                    }
                }
                else
                {
                    echo "Id is missing from url";
                }
            ?>    
        </div>
    </div>
</div>

<?php
include('afooter.php');
?>