<?php
include('login_register.php');
include('aheader.php');
?>
<div class="container">
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="row">
                <div class="col-lg-7 position-relative z-index-2">
                    <div class="card card-plain mb-4">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="d-flex flex-column h-100">
                                        <h2 class="font-weight-bolder mb-0">Welcome Admin!</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cards in a single line -->
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header p-3 pt-2" style="border-radius: 10px;">
                                    <div class="text-end pt-1" style="height: 80px; font-weight: bold; font-size: 20px;">
                                        <a href="kaya.php">Home</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header p-3 pt-2" style="border-radius: 10px;">
                                    <div class="text-end pt-1" style="height: 80px; font-weight: bold; font-size: 20px;">
                                        <a href="collections.php">Collection</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header p-3 pt-2" style="border-radius: 10px;">
                                    <div class="text-end pt-1" style="height: 80px; font-weight: bold; font-size: 20px;">
                                        <a href="album.php">Album</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header p-3 pt-2" style="border-radius: 10px;">
                                    <div class="text-end pt-1" style="height: 80px; font-weight: bold; font-size: 20px;">
                                        <a href="review.php">Reviews</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Username</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = "SELECT * FROM registerted_user";
                                                $query_run = mysqli_query($con, $query);
                                                if ($query_run) {
                                                    while ($item = mysqli_fetch_assoc($query_run)) {
                                                ?>
                                                        <tr>
                                                            <td><?= htmlspecialchars($item['userID']); ?></td>
                                                            <td><?= htmlspecialchars($item['username']); ?>
                                                            <?php if ($item['order_confirmed']) { ?>
                                                                    <span class="red-dot"></span>
                                                                <?php } ?></td>
                                                            <td><?= htmlspecialchars($item['name']); ?></td>
                                                            <td><?= htmlspecialchars($item['email']); ?></td>
                                                            
                                                            <td>
                                                                <a href="customer-orders.php?username=<?= htmlspecialchars($item['username']); ?>" class="btn btn-primary">View Orders</a>
                                                            </td>
                                                        </tr>
                                                <?php
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='6'>No records found</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of Table -->

                </div>
            </div>
        </div>
    </div>
</div>
<?php
include('afooter.php');
?>

<style>
.red-dot {
    height: 10px;
    width: 10px;
    background-color: red;
    border-radius: 50%;
    display: inline-block;
    margin-left: 5px;
}
</style>
