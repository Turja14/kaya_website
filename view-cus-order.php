<?php
include('login_register.php');
include('aheader.php');
include('authenticate.php');

// Function to check tracking number
function checktrack($track_no) {
    global $con; // Use the global database connection
    $query = "SELECT * FROM orders WHERE tracking_no='$track_no'";
    return mysqli_query($con, $query);
}

// Check if tracking number is set in URL
if (isset($_GET['t'])) {
    $track_no = $_GET['t'];
    $orderData = checktrack($track_no);

    if (mysqli_num_rows($orderData) <= 0) {
        echo "<h4>Something went wrong</h4>";
        die();
    }
} else {
    echo "<h4>Something went wrong</h4>";
    die();
}

$data = mysqli_fetch_array($orderData);

// Retrieve order items along with customization details
$order_query = "
    SELECT o.id as oid, o.tracking_no, o.username, oi.*, oi.qty as orderqty, p.*, c.color, c.size, c.description
    FROM orders o
    JOIN order_items oi ON o.id = oi.order_id
    JOIN products p ON oi.prod_id = p.id
    LEFT JOIN customizations c ON oi.prod_id = c.prod_id AND o.username = c.username
    WHERE o.tracking_no = '$track_no'
";
$order_query_run = mysqli_query($con, $order_query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Details</title>
    <style>
        .product-description {
            margin-top: 1rem;
        }
        .price-container {
            display: flex;
            justify-content: start;
            align-items: center;
            gap: 10rem;
        }
        .quantity-input {
            width: 100%;
            margin-left: 1px;
            max-width: 250px;
        }
        .btn-container {
            margin-left: 2px;
            display: flex;
        }
        .original_price {
            text-decoration: line-through;
        }
        p {
            text-transform: none;
        }
        .container {
            margin-top: 80px;
            margin-bottom: 80px;
        }
        h5 {
            font-weight: bold;
        }
        .foott {
            margin-top: 80px;
        }
        .details-container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }
        .card {
            flex: 1;
        }
        .customization-info {
            margin-top: 1rem;
            padding: 1rem;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
<div class="py-5">
    <div class="container" style="color: black;">
        <div class="card-header">
            <a href="customer-orders.php?username=<?= urlencode($data['username']); ?>" class="btn btn-warning float-end" style="margin-top: -65px;">Back</a>
        </div>
        <div class="details-container">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Details
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <label class="fw-bold">Name</label>
                                <div class="border p-1" style="text-transform: none;">
                                    <?= htmlspecialchars($data['username']); ?>
                                </div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="fw-bold">Email</label>
                                <div class="border p-1" style="text-transform: none;">
                                    <?= htmlspecialchars($data['email']); ?>
                                </div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="fw-bold">Phone</label>
                                <div class="border p-1">
                                    <?= htmlspecialchars($data['phone']); ?>
                                </div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="fw-bold">Tracking No</label>
                                <div class="border p-1">
                                    <?= htmlspecialchars($data['tracking_no']); ?>
                                </div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="fw-bold">Address</label>
                                <div class="border p-1">
                                    <?= htmlspecialchars($data['address']); ?>
                                </div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="fw-bold">Pincode</label>
                                <div class="border p-1">
                                    <?= htmlspecialchars($data['pincode']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Order Details
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Color</th>
                                    <th>Size</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (mysqli_num_rows($order_query_run) > 0) {
                                foreach ($order_query_run as $item) {
                                    ?>
                                    <tr>
                                        <td style="align-items: center;">
                                            <img src="upload/<?= htmlspecialchars($item['image']); ?>" alt="<?= htmlspecialchars($item['name']); ?>" width="50">
                                            <?= htmlspecialchars($item['name']); ?>
                                        </td>
                                        <td><?= htmlspecialchars($item['price']); ?></td>
                                        <td><?= htmlspecialchars($item['orderqty']); ?></td>
                                        <td><?= htmlspecialchars($item['color']); ?></td>
                                        <td><?= htmlspecialchars($item['size']); ?></td>
                                        <td><?= htmlspecialchars($item['description']); ?></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="6">No items found in this order.</td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                        <hr>
                        <h4>Total Price: <span class="float-end fw-bold"><?= htmlspecialchars($data['total_price']) ?></span></h4>
                        <hr>
                        <label class="fw-bold">Payment Mode</label>
                        <div class="border p-1 mb-3">
                            <?= htmlspecialchars($data['payment_mode']) ?>
                        </div>
                        <label class="fw-bold">Status</label>
                        <div class="border p-1 mb-3">
                            <?php
                            if ($data['status'] == 0) {
                                echo "Under Process";
                            } elseif ($data['status'] == 1) {
                                echo "Completed";
                            } elseif ($data['status'] == 2) {
                                echo "Cancelled";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="bootstrap.bundle.min.js"></script>
<script src="perfect-scrollbar.min.js"></script>
<script src="smooth-scrollbar.min.js"></script>
<script src="jquery-3.7.1.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>
</html>
