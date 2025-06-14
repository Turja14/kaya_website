<?php
session_start();
include('connection.php');

function getAllActive($table){
    global $con;
    $query = "SELECT * FROM $table WHERE status='0'";
    return mysqli_query($con, $query);
}

function getSlugActive($table, $slug){
    global $con;
    $query = "SELECT * FROM $table WHERE slug='$slug' AND status='0' LIMIT 1";
    return $query_run = mysqli_query($con, $query);
}
function getProdByCat($category_id)
{
    global $con;
    $query = "SELECT * FROM products WHERE category_id='$category_id' AND status='0' ";
    return $query_run = mysqli_query($con, $query);

}
function getIDActive($table, $id){
    global $con;
    $query = "SELECT * FROM $table WHERE id='$id' AND status='0' ";
    return $query_run = mysqli_query($con, $query);
}

function getAllActive2($table){
    global $con;
    $query = "SELECT * FROM $table WHERE status='0' ";
    return $query_run = mysqli_query($con, $query);
}
function getAll($table){
    global $con;
    $query = "SELECT * FROM $table";
    return $query_run = mysqli_query($con, $query);
}

function getCartItems() {
    global $con;

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];

        // Updated query with DISTINCT to avoid duplicates
        $query = "
            SELECT DISTINCT c.id AS cid, c.prod_id, c.prod_qty, c.color, c.size, p.id AS pid, p.name, p.image, p.selling_price, cs.description
            FROM carts c
            INNER JOIN products p ON c.prod_id = p.id
            LEFT JOIN customizations cs ON c.prod_id = cs.prod_id AND cs.username = c.username
            WHERE c.username = ?
            ORDER BY c.id DESC
        ";

        if ($stmt = mysqli_prepare($con, $query)) {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result) {
                return mysqli_fetch_all($result, MYSQLI_ASSOC);
            } else {
                return false;  // Query execution error
            }
        } else {
            return false;  // Prepare statement error
        }
    } else {
        return false;  // Username not set
    }
}



function getOrders()
{
    global $con;

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];

        $query = "SELECT * FROM orders WHERE username = '$username' 
                  ORDER BY id DESC ";

        return $query_run = mysqli_query($con, $query);
    } else {
        return false;
    }
}



function redirect($url, $message){
    echo "<script>
        alert('$message');
        window.location.href='$url';
    </script>";
    exit;
}

function checktrack($tracking_no)
{
    global $con;
    $username = $_SESSION['username'];

    $query = "SELECT * FROM orders WHERE tracking_no= '$tracking_no' AND username = '$username' ";
    return mysqli_query($con, $query);

}

?>