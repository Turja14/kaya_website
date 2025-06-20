<?php
include('aheader.php');
?>

<div class="container">
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Add Album Image</h4>
                </div>
                <div class="card-body">
                    <form action="add_album_code.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            
                            <div class="col-md-12 mb-3">
                                <label class="mb-0">Upload Image</label>
                                <input type="file" name="image" class="form-control mb-2" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="mb-0">Status</label><br>
                                <input type="checkbox" name="status"> Show in Album
                            </div>
                             <div class="col-md-12 mb-3">
                                <button type="submit" name="add_album_btn" class="btn btn-primary">Save</button>
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
