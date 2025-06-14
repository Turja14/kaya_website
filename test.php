<?php
session_start();
include 'header.php';

?>
<title>KAYA</title>
  <body>
    <div class="blurred-overlay1" id="blurredOverlay1"></div>
    <div class="wrapper">
      <div class="content">
        <div class="slides">
          <img src="transit/lighter.jpg">
          <img src="transit/debi.jpg">
          <img src="transit/dul.jpg">
          <img src="transit/somudroghotok.jpg">
        </div>
      </div>
      <div class="intro">
        <h1 class="text" style="font-family: 'Roboto' , sans-serif; color: black">Welcome to KAYA!</h1>
        <p>Discover the beauty of artisanal craftsmanship with our exquisite handmade products. Each piece is meticulously crafted with passion andprecision, ensuring a unique blend of quality and creativity. From intricate jewelry to charming home decor, our collection reflects the artistry ofskilled artisans. Explore the extraordinary and bring a touch of handcrafted elegance into your life. Embrace the authenticity of handmade treasuresthat tell stories and create lasting memories. Indulge in the art of handmade luxury – where every purchase is a celebration of craftsmanship andindividuality.</p>
      </div>
    </div>
    <section id="product1" class="section-p1">
      <h2 style="color: black; font-weight: bold">Popular Products</h2>
      <div class="card-container">
        <!-- <button class="arrow prev"><i class="ri-arrow-left-s-line"></i></button>
        <button class="arrow next"><i class="ri-arrow-right-s-line"></i></button> -->
        <div class="card-wrapper">
          <?php // PHP code goes here 
          // Connect to the database
            
            // Check connection
            if (!$con) {
                die("Connection failed: " . mysqli_connect_error());
            }
            
            // Retrieve trending products
            $trending_products_query = "SELECT * FROM products WHERE trending = 1";
            $trending_products_result = mysqli_query($con, $trending_products_query);
            
            // Check if there are any trending products
            if (mysqli_num_rows($trending_products_result) > 0) {
                // Display trending products
                while ($product = mysqli_fetch_assoc($trending_products_result)) {
                    // Generate HTML for each product card
                    $image = $product['image']; // retrieve the image path from the joined table
                    $ImagePath = "upload/" . $image; // construct the full image URL
                    $product_card_html = "
                      <div class='card-item'>
                        <img src='{$ImagePath}'>
                        <div class='card-info'>
                          <a href='#' class='card-title'>{$product['name']}</a>
                          <h4>Price : {$product['selling_price']}Tk </h4>
                          <p class='card-description'>{$product['description']}</p>
                        </div>
                        <a href='#'><i class='fas fa-shopping-cart'></i></a>
                      </div>
                    ";
                    echo $product_card_html;
                }
            } else {
                echo "No trending products found.";
            }
            
          ?>
        </div>
      </div>
    </section>
    
    <div class="hom-rev-conta">
      <div class="heading" style="font-weight: bold;">Reviews</div>
      <div class="rev-box">
        <?php
          // Retrieve reviews from database
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
            
                // Truncate review text to 50 words
                $word_count = 30;
                $words = explode(" ", $review);
                $truncated_review = implode(" ", array_slice($words, 0, $word_count));
            
                echo "<div class='rev'>";
                echo "<div class='rev_per'><img src='{$ImagePath}'></div>"; // use the constructed image URL
                echo "<span><i class='ri-double-quotes-l'></i></span>";
                echo "<div class='rev_content'>";
                echo "<p>" . $truncated_review . "</p>";
            
                // Add "read more..." link if review text is longer than 50 words
                if (count($words) > $word_count) {
                    echo "<a href='review.php'>Read more...</a>";
                }
            
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
          } 
          else {
              echo "<p>No reviews yet!</p>";
          }
          // Add "Add yours +" link
      echo "<div class='rev' style='display: flex; align-items:center; margin-left: 20px;'>";
      echo "<a href='" . (isset($_SESSION['username']) ? 'review.php' : 'javascript:alert("Please log in to add a review!")') . "'<div class='rev_plus'><p></p><i class='fas fa-plus'></i><p>Add Yours</p></div></a>";
      echo "</div>";
        ?>
        </div>
    </div>
    <?php
      include 'footer.php';
    ?>
    <script>
      const cardWrapper = document.querySelector('.card-wrapper')
      const widthToScroll = cardWrapper.children[0].offsetWidth
      const arrowPrev = document.querySelector('.arrow.prev')
      const arrowNext = document.querySelector('.arrow.next')
      const cardBounding = cardWrapper.getBoundingClientRect()
      const cardImageAndLink = cardWrapper.querySelectorAll('img, a')
      let currScroll = 0
      let initPos = 0
      let clicked = false
          
      cardImageAndLink.forEach(item=> {
        item.setAttribute('draggable', false)
      })

      arrowPrev.onclick = function() {
        cardWrapper.scrollLeft -= widthToScroll
      }

      arrowNext.onclick = function() {
        cardWrapper.scrollLeft += widthToScroll
      }

      cardWrapper.onmousedown = function(e) {
        cardWrapper.classList.add('grab')
        initPos = e.clientX - cardBounding.left
        currScroll = cardWrapper.scrollLeft
        clicked = true
      }

      cardWrapper.onmousemove = function(e) {
        if(clicked) {
          const xPos = e.clientX - cardBounding.left
          cardWrapper.scrollLeft = currScroll + -(xPos - initPos)
        }
      }

      cardWrapper.onmouseup = mouseUpAndLeave
      cardWrapper.onmouseleave = mouseUpAndLeave

      function mouseUpAndLeave() {
        cardWrapper.classList.remove('grab')
        clicked = false
      }
    </script>
  </body>