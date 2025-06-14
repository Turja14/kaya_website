<?php
ob_start(); // Start output buffering

include('header.php');

// Start session if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    echo "Error: You must be logged in to submit a review.";
    ob_end_flush(); // Flush and send output
    exit;
}

if (isset($_POST['submit'])) {
    // Validate form fields
    if (!empty($_POST['review-input']) && !empty($_POST['rating'])) {
        $review = trim($_POST['review-input']);
        $rating = (int) $_POST['rating'];
        $customer_name = $_SESSION['username'];

        // Validate the rating
        if ($rating < 1 || $rating > 5) {
            echo "Error: Invalid rating value. Please provide a rating between 1 and 5.";
            ob_end_flush(); // Flush and send output
            exit;
        }

        // Validate the review length
        if (strlen($review) < 5) {
            echo "Error: Review is too short. Please provide a more detailed review.";
            ob_end_flush(); // Flush and send output
            exit;
        }

        // Prepare SQL query to insert the review
        $sql = "INSERT INTO reviews (customer_name, review, rating, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $customer_name, $review, $rating);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // Redirect to the reviews page after successful submission
            header('Location: review.php');
            ob_end_flush(); // Flush and send output
            exit;
        } else {
            // Handle SQL error
            echo "Error: Could not submit your review. Please try again later.";
            error_log("MySQL error: " . mysqli_error($con)); // Log error for debugging
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Error: All fields are required.";
        ob_end_flush(); // Flush and send output
        exit;
    }
}

ob_end_flush(); // Flush and send output
?>
