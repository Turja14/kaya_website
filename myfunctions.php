<?php
include('connection.php');

function getAll($table){
    global $con;
    $query = "SELECT * FROM $table";
    return $query_run = mysqli_query($con, $query);
}

function getByID($table, $id){
    global $con;
    $query = "SELECT * FROM $table WHERE id='$id' ";
    return $query_run = mysqli_query($con, $query);
}
function getAllActive($table){
    global $con;
    $query = "SELECT * FROM $table WHERE status='0' ";
    return $query_run = mysqli_query($con, $query);
}

function redirect($url, $message){
    echo "<script>
        alert('$message');
        window.location.href='$url';
    </script>";
    exit;
}

function getOrders() {
    global $con;
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];

        $query = "SELECT * FROM orders WHERE username = '$username' ORDER BY id DESC";
        return mysqli_query($con, $query);

        
    } else {
        return false;
    }
}

?>