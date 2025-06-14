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
                        $query = "SELECT * FROM categories WHERE id='$id' ";
                        $result = mysqli_query($con, $query);

                    if(mysqli_num_rows($result) > 0)
                    {
                        $data = mysqli_fetch_array(($result))
                     ?>
                        <div class="card">
                            <div class="card-header">
                                <h4>Edit category</h4>
                                <a href="category.php" class="btn btn-primary float-end">Back</a>
                            </div>
                            <div class="card-body">
                                <form action="code.php" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">
                                     <input type="hidden" name="category_id" value="<?= $data['id'] ?>">   
                                    <label for="">Name</label>
                                    <input type="text" name="name" value="<?= $data['name'] ?>" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                    <label for="">Slug</label>
                                    <input type="text" name="slug" value="<?= $data['slug'] ?>" class="form-control">
                                    </div>
                                    <div class="col-md-12">
                                    <label for="">Description</label>
                                    <textarea rows="3" name="description" class="form-control"><?= $data['description'] ?></textarea>
                                    </div>
                                    <div class="col-md-12">
                                    <label for="">Upload Image</label>
                                    <input type="file" name="image" class="form-control">
                                    <label for="">Current Image</label>
                                    <input type="hidden" name="old_image" value="<?= $data['image'] ?>">

                                    <img src="upload/<?= $data['image'] ?>" height="50px" width="50px" alt="">
                                    </div>
                                    <div class="col-md-12">
                                    <label for="">Meta title</label>
                                    <input type="text" name="meta_title" class="form-control" value="<?= $data['meta_title'] ?>">
                                    </div>
                                    <div class="col-md-12">
                                    <label for="">Meta description</label>
                                    <textarea rows="3" name="meta_description" class="form-control"><?= $data['meta_description'] ?></textarea>
                                    </div>
                                    <div class="col-md-12">
                                    <label for="">Meta keywards</label>
                                    <textarea rows="3" name="meta_keywords" class="form-control"><?= $data['meta_keywords'] ?></textarea>
                                    </div>
                                    <div class="col-md-6">
                                    <label for="">Status</label>
                                    <input type="checkbox" <?= $data['status'] ? "checked":"" ?> name="status" >
                                    </div>
                                    <div class="col-md-6">
                                    <label for="">Popular</label>
                                    <input type="checkbox" <?= $data['popular'] ? "checked":"" ?> name="popular">
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary"  name="update_category_btn">Update</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    <?php
                    }
                    else{
                        echo "Category not found";
                    }
                }
                else
                {
                    echo "Something went wrong";
                }
            ?>
        </div>
    </div>
</div>
<?php
include('afooter.php');
?>
