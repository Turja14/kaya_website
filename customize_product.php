<?php
session_start();
include('connection.php');

// Check if the user is logged in
if (isset($_SESSION['logged_in'])) {
    
    // Handle POST request for customizing and adding to cart
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $prod_id = isset($_POST['prod_id']) ? $_POST['prod_id'] : '';
        $color = isset($_POST['color']) ? $_POST['color'] : '';
        $size = isset($_POST['size']) ? $_POST['size'] : '';
        $description = isset($_POST['description']) ? $_POST['description'] : '';
        $prod_qty = isset($_POST['prod_qty']) ? $_POST['prod_qty'] : 1;  // Quantity
        $username = $_SESSION['username'];

        // Optionally validate inputs here
        if (empty($prod_id) || !is_numeric($prod_id)) {
            echo "Invalid product ID.";
            exit;
        }

        // Start a database transaction to ensure both operations succeed
        mysqli_begin_transaction($con);

        try {
            // Save customization details to the customizations table
            $stmt = $con->prepare("INSERT INTO customizations (username, prod_id, color, size, description) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sisss", $username, $prod_id, $color, $size, $description);
            $stmt->execute();

            // Save the product with customization to the cart
            $stmt = $con->prepare("INSERT INTO carts (username, prod_id, prod_qty, color, size, description) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("siisss", $username, $prod_id, $prod_qty, $color, $size, $description);
            $stmt->execute();

            // Commit transaction if both operations succeed
            mysqli_commit($con);
            echo "Customization and cart addition successful!";
        } catch (Exception $e) {
            // Rollback if any operation fails
            mysqli_rollback($con);
            echo "Failed to customize and add to cart.";
        }
    } 
    // Handle GET request to display the customization form
    else if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['prod_id'])) {
        $prod_id = $_GET['prod_id'];

        // Retrieve product details from the database if needed
        $stmt = $con->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $prod_id);
        $stmt->execute();
        $product = $stmt->get_result()->fetch_assoc();

        if ($product) {
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Customize <?= htmlspecialchars($product['name']); ?></title>
            </head>
            <body>
                <h2>Customize <?= htmlspecialchars($product['name']); ?></h2>
                <form action="customize_product.php" method="POST">
                    <input type="hidden" name="prod_id" value="<?= htmlspecialchars($prod_id); ?>">
                    <label for="color">Color:</label>
                    <input type="text" name="color" id="color" required><br>

                    <label for="size">Size:</label>
                    <input type="text" name="size" id="size" required><br>

                    <label for="description">Description:</label>
                    <textarea name="description" id="description" required></textarea><br>

                    <label for="prod_qty">Quantity:</label>
                    <input type="number" name="prod_qty" id="prod_qty" value="1" min="1" required><br>

                    <button type="submit">Add to Cart</button>
                </form>
            </body>
            </html>
            <?php
        } else {
            echo "Invalid product ID.";
        }
    } else {
        echo "Invalid request.";
    }
} else {
    echo "Please log in to customize products.";
}
?>
