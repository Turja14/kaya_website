<?php

include('connection.php');
include('myfunctions.php');

if(isset($_POST['add_category_btn'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $slug = mysqli_real_escape_string($con, $_POST['slug']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $meta_title = mysqli_real_escape_string($con, $_POST['meta_title']);
    $meta_description = mysqli_real_escape_string($con, $_POST['meta_description']);
    $meta_keywords = mysqli_real_escape_string($con, $_POST['meta_keywords']);
    $status = isset($_POST['status']) ? '1' : '0';
    $popular = isset($_POST['popular']) ? '1' : '0';
    $image = $_FILES['image']['name'];

    $path = "upload";
    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time() . '.' . $image_ext;

    $cate_query = "INSERT INTO categories (name,slug,description,meta_title,meta_description,meta_keywords,status,popular,image) 
                   VALUES ('$name', '$slug', '$description', '$meta_title', '$meta_description', '$meta_keywords', '$status', '$popular', '$filename')";
    
    $cate_query_run = mysqli_query($con, $cate_query);

    if($cate_query_run) {
        move_uploaded_file($_FILES['image']['tmp_name'], $path.'/'.$filename);
        echo "<script>alert('Category added successfully'); window.location.href='category.php';</script>";
    } else {
        echo "<script>alert('Something went wrong: " . mysqli_error($con) . "'); window.location.href='add_category.php';</script>";
    }
}

else if(isset($_POST['update_category_btn'])) {
    $category_id = mysqli_real_escape_string($con, $_POST['category_id']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $slug = mysqli_real_escape_string($con, $_POST['slug']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $meta_title = mysqli_real_escape_string($con, $_POST['meta_title']);
    $meta_description = mysqli_real_escape_string($con, $_POST['meta_description']);
    $meta_keywords = mysqli_real_escape_string($con, $_POST['meta_keywords']);
    $status = isset($_POST['status']) ? '1':'0';
    $popular =isset($_POST['popular']) ? '1':'0';

    $path = "upload";
    $new_image = $_FILES['image']['name'];
    $old_image = $_POST['old_image'];

    if($new_image != "")
    {
        $update_filename = $new_image;
    }
    else
    {
        $update_filename = $old_image;

    }

    $update_query = "UPDATE categories SET name='$name', slug= '$slug', description= '$description', meta_title= '$meta_title', meta_description= '$meta_description', meta_keywords= '$meta_keywords',status= '$status', popular= '$popular', image='$update_filename' WHERE id='$category_id' ";

    $update_query_run = mysqli_query($con, $update_query);

    if($update_query_run)
    {
        if($_FILES['image']['name'] != "")
        {
            move_uploaded_file($_FILES['image']['tmp_name'], $path.'/'.$new_image);
            if(file_exists("upload/".$old_image))
            {
                unlink("upload/".$old_image);
            }
        }
        redirect("category.php?id=$category_id", "Category updated successfully");
    }
    else{
        redirect("edit-category.php?id=$category_id", "Something went wrong");

    }
}

else if (isset($_POST['delete_category_btn'])) {
    $category_id = mysqli_real_escape_string($con, $_POST['category_id']);
    
    // SQL query to specify the columns to select
    $category_query = "SELECT image FROM categories WHERE id= '$category_id'";
    $category_query_run = mysqli_query($con, $category_query);
    
    if ($category_query_run) {
        $category_data = mysqli_fetch_array($category_query_run);
        $image = $category_data['image'];
        
        $delete_query = "DELETE FROM categories WHERE id= '$category_id'";
        $delete_query_run = mysqli_query($con, $delete_query);

        if ($delete_query_run) {
            if (file_exists("upload/" . $image)) {
                unlink("upload/" . $image);
            }
            echo 200;
        } else {
            echo 500;
        }
    } else {
        echo 500; // Failed to run the SELECT query
    }
}


else if(isset($_POST['add_product_btn'])) {
    $category_id = mysqli_real_escape_string($con, $_POST['category_id']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $slug = mysqli_real_escape_string($con, $_POST['slug']);
    $small_description = mysqli_real_escape_string($con, $_POST['small_description']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $original_price = mysqli_real_escape_string($con, $_POST['original_price']);
    $selling_price = mysqli_real_escape_string($con, $_POST['selling_price']);
    $qty = mysqli_real_escape_string($con, $_POST['qty']);
    $status = isset($_POST['status']) ? '1' : '0';
    $trending = isset($_POST['trending']) ? '1' : '0';
    $meta_title = mysqli_real_escape_string($con, $_POST['meta_title']);
    $meta_keywords = mysqli_real_escape_string($con, $_POST['meta_keywords']);
    $meta_description = mysqli_real_escape_string($con, $_POST['meta_description']);
    $image = $_FILES['image']['name'];

    $path = "upload";
    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time() . '.' . $image_ext;

    if($name != "" && $slug != "" && $description != "") {
        $product_query = "INSERT INTO products (category_id, name, slug, small_description, description, original_price, selling_price, image, qty, status, trending, meta_title, meta_keywords, meta_description) 
                          VALUES ('$category_id', '$name', '$slug', '$small_description', '$description', '$original_price', '$selling_price', '$filename', '$qty', '$status', '$trending', '$meta_title', '$meta_keywords', '$meta_description')";

        $product_query_run = mysqli_query($con, $product_query);
    
        if($product_query_run) {
            move_uploaded_file($_FILES['image']['tmp_name'], $path.'/'.$filename);
            echo "<script>alert('Product added successfully'); window.location.href='products.php';</script>";
        } 
        else {
            echo "<script>alert('Something went wrong: " . mysqli_error($con) . "'); window.location.href='add_product.php';</script>";
        }
    }
    else {
        echo "<script>alert('Please fill in all required fields'); window.location.href='add_product.php';</script>";
    }
}

else if(isset($_POST['update_product_btn'])){
    $product_id = mysqli_real_escape_string($con, $_POST['product_id']);
    $category_id = mysqli_real_escape_string($con, $_POST['category_id']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $slug = mysqli_real_escape_string($con, $_POST['slug']);
    $small_description = mysqli_real_escape_string($con, $_POST['small_description']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $original_price = mysqli_real_escape_string($con, $_POST['original_price']);
    $selling_price = mysqli_real_escape_string($con, $_POST['selling_price']);
    $qty = mysqli_real_escape_string($con, $_POST['qty']);
    $status = isset($_POST['status']) ? '1' : '0';
    $trending = isset($_POST['trending']) ? '1' : '0';
    $meta_title = mysqli_real_escape_string($con, $_POST['meta_title']);
    $meta_keywords = mysqli_real_escape_string($con, $_POST['meta_keywords']);
    $meta_description = mysqli_real_escape_string($con, $_POST['meta_description']);

    $path = "upload";
    $new_image = $_FILES['image']['name'];
    $old_image = $_POST['old_image'];

    if($new_image != "")
    {
        $update_filename = $new_image;
    }
    else
    {
        $update_filename = $old_image;

    }

    $update_product_query = "UPDATE products SET name='$name', slug= '$slug', small_description= '$small_description', description= '$description', original_price= '$original_price', selling_price= '$selling_price', meta_title= '$meta_title', meta_description= '$meta_description', meta_keywords= '$meta_keywords',status= '$status', trending= '$trending', image='$update_filename' WHERE id='$product_id' ";

    $update_product_query_run = mysqli_query($con, $update_product_query);
    if($update_product_query_run)
    {
        if($_FILES['image']['name'] != "")
        {
            move_uploaded_file($_FILES['image']['tmp_name'], $path.'/'.$new_image);
            if(file_exists("upload/".$old_image))
            {
                unlink("upload/".$old_image);
            }
        }
        redirect("products.php?id=$product_id", "Product updated successfully");
    }
    else{
        redirect("edit-product.php?id=$product_id", "Something went wrong");

    }
}

else if(isset($_POST['delete_product_btn'])){
    $product_id = mysqli_real_escape_string($con, $_POST['product_id']);

    // SQL SELECT query
    $product_query = "SELECT image FROM products WHERE id='$product_id'";
    $product_query_run = mysqli_query($con, $product_query);

    if ($product_query_run && mysqli_num_rows($product_query_run) > 0) {
        $product_data = mysqli_fetch_array($product_query_run);
        $image = $product_data['image'];

        $delete_query = "DELETE FROM products WHERE id='$product_id'";
        $delete_query_run = mysqli_query($con, $delete_query);

        if ($delete_query_run) {
            if (file_exists("upload/".$image)) {
                unlink("upload/".$image);
            }
            echo 200;
        } else {
            echo 500;
        }
    } else {
        echo 500; // Failed to find the product
    }
}


else{
    header('location:../index.php');
}

?>
