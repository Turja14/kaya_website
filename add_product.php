<?php

include('aheader.php');

?>
<div class="container">
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Add Products</h4>
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
                                                    <option value="<?= $item['id']; ?>"><?= $item['name']; ?></option>
                                                <?php
                                            }
                                        } 
                                        else {
                                            echo "No Category Available";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="mb-0">Name</label>
                                <input type="text" name="name" class="form-control mb-2">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="mb-0">Slug</label>
                                <input type="text" name="slug" class="form-control mb-2">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="mb-0">Small Description</label>
                                <textarea rows="3" name="small_description" class="form-control mb-2"></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="mb-0">Description</label>
                                <textarea rows="3" name="description" class="form-control mb-2"></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="mb-0">Original Price</label>
                                <input type="text" name="original_price" class="form-control mb-2">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="mb-0">Selling Price</label>
                                <input type="text" name="selling_price" class="form-control mb-2">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="mb-0">Upload Image</label>
                                <input type="file" name="image" class="form-control mb-2">
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="mb-0">Quantity</label>
                                    <input type="number" name="qty" class="form-control mb-2">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="mb-0">Status</label><br>
                                    <input type="checkbox" name="status">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="mb-0">Trending</label><br>
                                    <input type="checkbox" name="trending">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="mb-0">Meta title</label>
                                <input type="text" name="meta_title" class="form-control mb-2">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="mb-0">Meta keywords</label>
                                <textarea rows="3" name="meta_keywords" class="form-control mb-2"></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="mb-0">Meta description</label>
                                <textarea rows="3" name="meta_description" class="form-control mb-2"></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <button type="submit" class="btn btn-primary" name="add_product_btn">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include('afooter.php');
?>