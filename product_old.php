<?php
include 'header.php';
?>
    <body>
        <div class="blurred-overlay1" id="blurredOverlay1"></div>
            <section class="shop_container">
                <div class="heading"><h1 class="section-title">PRODUCTS</h1></div>
                <div class="container1">
                    <div class="filter-buttons1">
                        <button class="active" data-name="all">All</button>
                        <button data-name="punjabi">Punjabi</button>
                        <button data-name="canvas">Canvas</button>
                        <button data-name="Jewe">Jewe</button>
                        <button data-name="sunglass">Sunglass</button> 
                    </div>
                    <div class="filterable-cards">
                        <div class="shop-content">
                            <div class="product-box" data-name="punjabi">
                                <img src="punjabi/1.jpg" alt="" class="product-img">
                                <h2 class="product-title">Punjabi 1</h2>
                                <span class="price">450tk</span>
                                <i class='bx bx-shopping-bag'></i>
                            </div>
                            <div class="product-box" data-name="punjabi">
                                <img src="punjabi/2.1.jpg" alt="" class="product-img">
                                <h2 class="product-title">Punjabi 2</h2>
                                <span class="price">450tk</span>
                                <i class='bx bx-shopping-bag'></i>
                            </div>
                            <div class="product-box" data-name="canvas">
                                <img src="canva/1.jpg" alt="" class="product-img">
                                <h2 class="product-title">Canvas 1</h2>
                                <span class="price">350tk</span>
                                <i class='bx bx-shopping-bag'></i>
                            </div>
                            <div class="product-box" data-name="Jewe">
                                <img src="jewe/1.jpg" alt="" class="product-img">
                                <h2 class="product-title">Jewe 1</h2>
                                <span class="price">450tk</span>
                                <i class='bx bx-shopping-bag'></i>
                            </div>
                            <div class="product-box" data-name="canvas">
                                <img src="canva/2.jpg" alt="" class="product-img">
                                <h2 class="product-title">Canvas 2</h2>
                                <span class="price">350tk</span>
                                <i class='bx bx-shopping-bag'></i>
                            </div>
                            <div class="product-box" data-name="sunglass">
                                <img src="sung/1.jpg" alt="" class="product-img">
                                <h2 class="product-title">sunglass 1</h2>
                                <span class="price">450tk</span>
                                <i class='bx bx-shopping-bag'></i>
                            </div>
                            <div class="product-box" data-name="Jewe">
                                <img src="jewe/4.jpg" alt="" class="product-img">
                                <h2 class="product-title">Jewe 3</h2>
                                <span class="price">450tk</span>
                                <i class='bx bx-shopping-bag'></i>
                            </div>
                            <div class="product-box" data-name="Jewe">
                                <img src="jewe/5.jpg" alt="" class="product-img">
                                <h2 class="product-title">Jewe 4</h2>
                                <span class="price">450tk</span>
                                <i class='bx bx-shopping-bag'></i>
                            </div>
                            <div class="product-box" data-name="canvas">
                                <img src="canva/3.jpg" alt="" class="product-img">
                                <h2 class="product-title">Canvas 3</h2>
                                <span class="price">450tk</span>
                                <i class='bx bx-shopping-bag'></i>
                            </div>
                            <div class="product-box" data-name="sunglass">
                               <img src="sung/3.jpg" alt="" class="product-img">
                               <h2 class="product-title">sunglass 2</h2>
                               <span class="price">450tk</span>
                               <i class='bx bx-shopping-bag'></i>
                            </div>
                            <div class="product-box" data-name="Jewe">
                                <img src="jewe/9.jpg" alt="" class="product-img">
                                <h2 class="product-title">Jewe 5</h2>
                                <span class="price">450tk</span>
                                <i class='bx bx-shopping-bag'></i>
                            </div>
                        </div>
                    </div>
                <div id="load-more"> load more </div>
            </div>
        </section>
    </div>
    <?php
      include 'footer.php';
    ?>
</div>
       <script>
        document.addEventListener("DOMContentLoaded", function () {
        // Wait for the DOM to be fully loaded

        // Select the cart icon, cart element, and close button
        const cartIcon = document.querySelector('#cart-icon');
        const cart = document.querySelector('.cart');
        const cartClose = document.querySelector('#close');
        const checkoutBtn = document.querySelector('.btn-buy');
        const checkoutBox = document.querySelector('.checkout-box');
        const closeButton = document.querySelector('#close1');
        const blurredOverlay1 = document.querySelector('#blurredOverlay1');
        const cartContent = document.querySelector('.cart-content');
        const checkoutForm = document.getElementById('checkout-form');

        // Add event listener to the cart icon to open the cart
        cartIcon.addEventListener('click', () => {
            cart.classList.add('active');
        });

        // Add event listener to the close button to close the cart
        cartClose.addEventListener('click', () => {
            cart.classList.remove('active'); // Remove the 'active' class to close the cart
        });

        // Show the checkout box when the checkout button is clicked
        checkoutBtn.addEventListener('click', function () {
            checkoutBox.style.display = 'block';
            checkoutBox.style.top = '50%';
            blurredOverlay1.classList.add('active');
        });

        // Hide the checkout box when the close button is clicked
        closeButton.addEventListener('click', function () {
            checkoutBox.style.display = 'none';
            blurredOverlay1.classList.remove('active');
        });

        // Hide the checkout box when the cart close button is clicked
        cartClose.addEventListener('click', () => {
            checkoutBox.style.display = 'none';
            blurredOverlay1.classList.remove('active');
            
        });

        // Handle the checkout button click event
        document.getElementById('checkout-btn').addEventListener('click', function () {
            var name = document.getElementById('name').value;
            var address = document.getElementById('address').value;
            var city = document.getElementById('city').value;
            var phone = document.getElementById('phone').value;
            var paymentMethod = document.getElementById('payment-method').value;
            var transactionId = document.getElementById('transaction-id').value;

            // Check if any of the fields are empty
            if (!name || !address || !city || !phone || !paymentMethod || !transactionId) {
                // Display alert if any field is empty
                alert('Please fill in all fields.');
                return; // Stop further execution
            }

            // Proceed with the checkout process if all fields are filled
            else {
                alert('Your order is placed');

                // Reset the form

                // Clear the cart content
                while (cartContent.firstChild) {
                    cartContent.removeChild(cartContent.firstChild);
                }

                // Reset the total price to 0
                document.querySelector('.total-price').textContent = '0Tk';

                // Hide the checkout box
                checkoutBox.style.display = 'none';

                
            }
        });
    });
</script>
<script src="product.js"></script>
<script src="overall.js"></script>
</body>
</html>