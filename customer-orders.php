<?php
include('login_register.php');
include('aheader.php');

// Check if username is set in URL
if (isset($_GET['username'])) {
    $username = mysqli_real_escape_string($con, $_GET['username']);

    // Update order_confirmed status to FALSE
    $update_order_confirmed = "UPDATE registerted_user SET order_confirmed = FALSE WHERE username='$username'";
    mysqli_query($con, $update_order_confirmed);

    // Fetch orders for the given username
    $query = "SELECT * FROM orders WHERE username='$username' ORDER BY id DESC";
    $query_run = mysqli_query($con, $query);
    ?>
    <div class="container">
        <div class="row mt-4">
            <div class="col-md-12">
                <h2 class="font-weight-bolder mb-4">Orders for <?= htmlspecialchars($username); ?></h2>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Tracking No</th>
                                <th>Order Amount</th>
                                <th>Order Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($query_run && mysqli_num_rows($query_run) > 0) {
                                while ($order = mysqli_fetch_assoc($query_run)) {
                            ?>
                                    <tr>
                                        <td><?= htmlspecialchars($order['id']); ?></td>
                                        <td><?= htmlspecialchars($order['tracking_no']); ?></td>
                                        <td><?= htmlspecialchars($order['total_price']); ?></td>
                                        <td><?= htmlspecialchars($order['created_at']); ?></td>
                                        <td><a href="view-cus-order.php?t=<?= htmlspecialchars($order['tracking_no']); ?>" class="btn btn-primary">View details</a></td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='5'>No orders found for this user</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php
} else {
    echo "<div class='container'><div class='row mt-4'><div class='col-md-12'><h2 class='font-weight-bolder mb-4'>No username specified</h2></div></div></div>";
}

include('afooter.php');
?>
