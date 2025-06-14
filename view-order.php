<?php
include('userfunction.php');
include('headerforothers.php');
include('authenticate.php');

// Check if the tracking number is set
if (isset($_GET['t'])) {
    $track_no = $_GET['t'];
    $orderData = checktrack($track_no);

    // Verify if the order data exists
    if (mysqli_num_rows($orderData) <= 0) {
        echo "<h4>Something went wrong</h4>";
        die();
    }
} else {
    echo "<h4>Something went wrong</h4>";
    die();
}

$data = mysqli_fetch_array($orderData);

// Fetch payment mode data
$payment_mode = $data['payment_mode']; // Assuming payment_mode is a field in the orders table
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" 
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link id="pagestyle" href="material-dashboard.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="style.css">
    <title>Order Details</title>
    <style>
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
            padding: 1rem;
        }
        .card-header{
            align-self: center;
        }
        .fw-bold{
            padding: 15px 0px;
        }
        #ext{
            padding: 15px;
        }
        .customization-info {
            margin-top: 1rem;
            padding: 1rem;
            border: 1px solid #ddd;
        }
        #print{
            margin: 45px;
            float: right;
        }
        @media print {
            body * {
                visibility: hidden;
            }
            .details-container, .details-container * {
                visibility: visible;
            }
            .details-container {
                position: absolute;
                left: 0;
                top: 0;
            }
        }

    </style>
</head>
<body>
<div class="py-5">
    <div class="container" style="color: black;">
        <div class="card-header">
            <a href="my-orders.php" class="btn btn-warning float-end" style="margin-top: -70px;">Back</a>
        </div>
        <div class="details-container">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <label class="fw-bold">Name</label>
                                <div class="border p-2" style="text-transform: none;">
                                    <?= htmlspecialchars($data['username']); ?>
                                </div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="fw-bold">Email</label>
                                <div class="border p-2" style="text-transform: none;">
                                    <?= htmlspecialchars($data['email']); ?>
                                </div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="fw-bold">Phone</label>
                                <div class="border p-2">
                                    <?= htmlspecialchars($data['phone']); ?>
                                </div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="fw-bold">Tracking No</label>
                                <div class="border p-2">
                                    <?= htmlspecialchars($data['tracking_no']); ?>
                                </div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="fw-bold">Address</label>
                                <div class="border p-2">
                                    <?= htmlspecialchars($data['address']); ?>
                                </div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="fw-bold">Pincode</label>
                                <div class="border p-2">
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
                        <h4>Order Details</h4>
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
                            $stmt = $con->prepare("SELECT o.id as oid, o.tracking_no, o.username, oi.*, oi.qty as orderqty, p.*, c.color, c.size, c.description 
                                                FROM orders o
                                                JOIN order_items oi ON o.id = oi.order_id
                                                JOIN products p ON oi.prod_id = p.id
                                                LEFT JOIN customizations c ON oi.prod_id = c.prod_id AND o.username = c.username
                                                WHERE o.tracking_no = ?");
                            $stmt->bind_param('s', $track_no);
                            if ($stmt->execute()) {
                                $order_query_run = $stmt->get_result();
                                if ($order_query_run->num_rows > 0) {
                                    while ($item = $order_query_run->fetch_assoc()) {
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
                            } else {
                                echo "Error executing query: " . $stmt->error;
                            }
                            ?>
                            </tbody>
                        </table>
                        <hr>
                        <h4>Total Price: <span class="float-end fw-bold"><?= htmlspecialchars($data['total_price']); ?></span></h4>
                        <hr>
                        <label class="fw-bold">Payment Mode</label>
                        <div id="ext" class="border p-3 mb-3"><?php echo $payment_mode; ?></div>
                        <br>
                        <label class="fw-bold">Status</label>
                        <div id="ext" class="border p-3 mb-3">
                            <?php
                            switch($data['status']) {
                                case 0:
                                    echo "Under Process";
                                    break;
                                case 1:
                                    echo "Completed";
                                    break;
                                case 2:
                                    echo "Cancelled";
                                    break;
                                default:
                                    echo "Unknown";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button class="btn btn-secondary float-right" id='print'>Print</button>
    </div>
</div>
<div class="foott">
    <?php include('footer.php'); ?>
</div>

<script>
    document.getElementById('print').addEventListener('click', function() {
        window.print();
    });
</script>

<script src="bootstrap.bundle.min.js"></script>
<script src="perfect-scrollbar.min.js"></script>
<script src="smooth-scrollbar.min.js"></script>
<script src="jquery-3.7.1.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>
</html>