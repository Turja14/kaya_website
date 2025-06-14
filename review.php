<?php

include('userfunction.php');
include('header.php');

?>

<title>REVIEWS</title>

<body>
<div class="box">
    <div class="rev_conte">
        <div class="heading">
            <h1 style="color: black">REVIEWS</h1>
        </div>
        <div class="rev_box">
            <?php
            // Retrieve reviews from database
           // $sql = "SELECT * FROM reviews ORDER BY created_at DESC";//
            $sql = "SELECT r.*, u.image 
                FROM reviews r 
                INNER JOIN registerted_user u ON r.customer_name = u.username 
                ORDER BY r.created_at DESC";
            
            $result = mysqli_query($con, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $customer_name = $row['customer_name'];
                    $review = $row['review'];
                    $rating = $row['rating'];
                    $created_at = $row['created_at'];
                    $image = $row['image']; // retrieve the image path from the joined table
                    $ImagePath = "upload/" . $image; // construct the full image URL



                    echo "<div class='rev'>";
                    echo "<div class='rev_per'><img src='{$ImagePath}'></div>"; // use the constructed image URL
                    echo "<span><i class='ri-double-quotes-l'></i></span>";
                    echo "<div class='rev_content'>";
                    echo "<p>$review</p>";
                    echo "<h3>- $customer_name</h3>";
                    echo "<div class='stars'>";
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= floor($rating)) {
                            echo "<i class='fas fa-star'></i>"; // filled star
                        } elseif ($i == ceil($rating)) {
                            echo "<i class='fas fa-star-half-alt'></i>"; // half star
                        } else {
                            echo "<i class='far fa-star'></i>"; // empty star
                        }
                    }
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>No reviews yet!</p>";
            }
            ?>
        </div>
    </div>
    <!-- HTML form to add a new review -->
    <?php if ($role_as == 0): ?>
    <div class="add_rev">
        <button id="add-review-btn">Add Your Review</button>
        <div id="review-form">
            
            <form action="add_review.php" method="post">
                <div class="rev_cont">
                    <div class="container">
                        <input type="text" placeholder="drop a review" name="review-input">
                        <button type="submit" name="submit"><i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>
                <div class="rev_cont">
                    <div class="rating">
                        <i class="far fa-star" data-value="1"></i>
                        <i class="far fa-star" data-value="2"></i>
                        <i class="far fa-star" data-value="3"></i>
                        <i class="far fa-star" data-value="4"></i>
                        <i class="far fa-star" data-value="5"></i>
                        <input type="hidden" name="rating" id="rating" value="0">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <?php
    if (isset($_POST['submit'])) {
        if (isset($_SESSION['username'])) {
            $customer_name = $_SESSION['username'];
            $review = $_POST['review-input'];
            $rating = $_POST['rating'];
            if (!empty($review) && $rating > 0) {
                $sql = "INSERT INTO reviews (customer_name, review, rating, created_at) VALUES (?, ?, ?, NOW())";
                $stmt = mysqli_prepare($con, $sql);
                mysqli_stmt_bind_param($stmt, "ssi", $customer_name, $review, $rating);
                // mysqli_stmt_execute($stmt);
                if (mysqli_stmt_execute($stmt)) {
                    echo "Review added successfully!";
                    // Redirect to the same page or a different page
                    header('Location: review.php');
                    exit;
                } else {
                    echo "Error adding review: " . mysqli_error($con);
                }
                
    
                // Close the prepared statement
                mysqli_stmt_close($stmt);
            } else {
                echo "Please fill in both the review and rating fields.";
            }
        } else {
            echo "You must be logged in to add a review.";
        }
    }
    ?>
    <script>
        const addReviewBtn = document.getElementById('add-review-btn');
        const reviewForm = document.getElementById('review-form');
        addReviewBtn.addEventListener('click', () => {
            fetch('check_login.php')
                .then(response => response.text())
                .then(isLoggedIn => {
                    if (isLoggedIn === 'true') {
                        reviewForm.style.display = 'block';
                    } else {
                        alert('You must be logged in to add a review.');
                    }
                });
        });
    </script>
    <script>
        const ratingStars = document.querySelectorAll('.rating i');
        ratingStars.forEach((star, index) => {
            star.addEventListener('click', () => {
                const ratingValue = star.getAttribute('data-value');
                document.getElementById('rating').value = ratingValue;
                ratingStars.forEach((s, i) => {
                    if (i <= index) {
                        s.classList.add('fas');
                        s.classList.remove('far');
                    } else {
                        s.classList.add('far');
                        s.classList.remove('fas');
                    }
                });
            });
        });
    </script>
    <?php
        include 'footer.php';
    ?>
</div>
<script src="overall.js"></script>
</body>
</html>