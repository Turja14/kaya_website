<?php
include('userfunction.php');
include('header.php');

if(isset($_GET['category']))
{
    $category_slug = $_GET['category'];
    $category_data = getSlugActive("categories", $category_slug);

    $category = mysqli_fetch_array($category_data);

    if($category)
    {
        $cid = $category['id'];
        $category_name = $category['name']; // Store the category name for the title
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;700&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" 
            integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
            <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
            
            <!-- Favicon -->
            <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">

            <!-- CSS Files -->
            <link rel="stylesheet" href="style.css">
            <link rel="stylesheet" href="product.css">

            <title><?php echo $category_name; ?> - KAYA</title>
        </head>
        <body>
        <div class="py-5">
            <div class="container">
                <div class="row justify-content-center"> <!-- Center the row -->
                    <div class="col-md-6"> <!-- Adjusted column width -->
                        <h1 class="text-center mt-4" style="margin-left:25px; color: black; border-bottom: 3px solid black; font-weight: bold; width: 400px; padding-bottom: 20px;"><?= $category_name; ?></h1> <!-- Adjusted padding -->
                    </div>
                </div>
                <div class="container">
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
               
                <div class="card-body">
                    <div class="row">
                    <?php
                    $products = getProdByCat("$cid");

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
                <!-- <div class="row">
                    <?php
                    $products = getProdByCat("$cid");

                    if(mysqli_num_rows($products) > 0)
                    {
                        foreach($products as $item)
                        {
                            ?>
                            <div class="col-md-4 mb-3">
                                <a href="view_product.php?product=<?= $item['slug']; ?>">
                                <div class="card shadow">
                                    <div class="card-body">
                                        <img src="upload/<?= $item['image']; ?>" alt="Product Image" class="img-fluid">
                                        <h3 class="text-center" style="color: black;"><?= $item['name']; ?></h3>
                                    </div>
                                </div>
                                </a>
                            </div>
                            <?php
                        }
                    }
                    else                    
                    {
                        echo "No data available";
                    }
                    ?>
                </div>
            </div>
        </div> -->
        <?php
    }
    else
    {
        echo "Something went wrong";
    }

}
else
{
    echo "Something went wrong";
}
include('footer.php');
?>
