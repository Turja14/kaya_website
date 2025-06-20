<?php

include('connection.php');
include('myfunctions.php');




if (isset($_POST['add_album_btn'])) {
    $status = isset($_POST['status']) ? '0' : '1'; // Default to 1 if not set
    $image = $_FILES['image']['name'];

    if ($image) {
        $path = "upload";
        $image_ext = pathinfo($image, PATHINFO_EXTENSION);
        $filename = time() . '.' . $image_ext;

        $query = "INSERT INTO album_images (image_path, status) VALUES ('$filename', '$status')";
        $query_run = mysqli_query($con, $query);

        if ($query_run) {
            move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $filename);
            redirect("album.php", "Album image added successfully");
        } else {
            redirect("add_album.php", "Something went wrong: " . mysqli_error($con));
        }
    } else {
        redirect("add_album.php", "Please upload an image");
    }
}
?>