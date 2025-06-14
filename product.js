document.addEventListener('DOMContentLoaded', function() {
    const cartIcon = document.querySelector('#cart-icon');
    const cart = document.querySelector('.cart');
    const cartClose = document.querySelector('#close');

    cartIcon.addEventListener('click', () => {
        cart.classList.add('active');
    });

    cartClose.addEventListener('click', () => {
        cart.classList.remove('active'); 
    });
    ready();
});

// Function to handle actions when the DOM is ready
function ready() {
    // Select all remove cart buttons and attach event listeners
    var removeCartButtons = document.getElementsByClassName('cart-remove');
    for (var i = 0; i < removeCartButtons.length; i++) {
        var button = removeCartButtons[i];
        button.addEventListener('click', removeCartItem);
    }

    // Select all quantity input fields and attach event listeners
    var quantityInputs = document.getElementsByClassName('cart-quantity');
    for (var i = 0; i < quantityInputs.length; i++) {
        var input = quantityInputs[i];
        input.addEventListener('change', quantityChanged);
    }

    // Select all add to cart buttons and attach event listeners
    var addCart = document.getElementsByClassName('bx-shopping-bag');
    for (var i = 0; i < addCart.length; i++) {
        var button = addCart[i];
        button.addEventListener('click', addCartClicked);
    }

    // Attach event listener to the Buy Now button
    document.querySelector('.btn-buy').addEventListener('click', buyButtonClicked);
}

// Function to handle the Buy Now button click event


// Function to handle the removal of cart items
function removeCartItem(event) {
    var buttonClicked = event.target;
    buttonClicked.parentElement.remove();
    updatetotal();
}

// Function to handle quantity changes
function quantityChanged(event) {
    var input = event.target;
    if (isNaN(input.value) || input.value <= 0) {
        input.value = 1;
    }
    updatetotal();
}

// Function to handle adding a product to the cart
function addCartClicked(event) {
    var button = event.target;
    var shopProducts = button.parentElement;
    var title = shopProducts.querySelector('.product-title').innerText;
    var price = shopProducts.querySelector('.price').innerText;
    var productImg = shopProducts.querySelector('.product-img').src;
    addProductToCart(title, price, productImg);
    updatetotal();
}


// Function to add a product to the cart
function addProductToCart(title, price, productImg) {
    var cartShopBox = document.createElement('div');
    cartShopBox.classList.add('cart-box');
    var cartItems = document.querySelector('.cart-content');
    var cartItemsNames = cartItems.querySelectorAll('.cart-product-title');
    for (var i = 0; i < cartItemsNames.length; i++) {
        if (cartItemsNames[i].innerText === title) {
            alert('You have already added this item to cart');
            return;
        }
    }

    var cartBoxContent = `
        <img src="${productImg}" alt="" class="cart-img">
        <div class="detail-box">
            <div class="cart-product-title">${title}</div>
            <div class="cart-price">${price}</div>
            <input type="number" value="1" class="cart-quantity">
        </div>
        <i class="bx bxs-trash-alt cart-remove"></i>
    `;

    cartShopBox.innerHTML = cartBoxContent;
    cartItems.appendChild(cartShopBox);
    cartShopBox.querySelector('.cart-remove').addEventListener('click', removeCartItem);
    cartShopBox.querySelector('.cart-quantity').addEventListener('change', quantityChanged);
}

// Function to update the total price
function updatetotal() {
    var cartContent = document.querySelector('.cart-content');
    var cartBoxes = cartContent.querySelectorAll('.cart-box');
    var total = 0;
    for (var i = 0; i < cartBoxes.length; i++) {
        var cartBox = cartBoxes[i];
        var priceElement = cartBox.querySelector('.cart-price');
        var quantityElement = cartBox.querySelector('.cart-quantity');
        var price = parseFloat(priceElement.innerText.replace('Tk', '').trim());
        var quantity = quantityElement.value;
        total += price * quantity;
    }
    total = Math.round(total * 100) / 100;
    document.querySelector('.total-price').innerText = total + 'Tk';
}

// Function to filter cards based on category
function filterCards(e) {
    const filterName = e.target.dataset.name;
    const filterableCards = document.querySelectorAll('.filterable-cards .product-box');
    
    // Remove class 'active' from previously active button
    const activeButton = document.querySelector('.filter-buttons1 .active');
    if (activeButton) {
        activeButton.classList.remove('active');
    }

    // Add class 'active' to the clicked button
    e.target.classList.add('active');

    // Show all cards if "All" button is clicked
    if (filterName === 'all') {
        filterableCards.forEach(card => {
            card.style.display = 'inline-block';
        });
    } else {
        // Filter cards based on the data-name attribute
        filterableCards.forEach(card => {
            if (card.dataset.name === filterName) {
                card.style.display = 'inline-block';
            } else {
                card.style.display = 'none';
            }
        });
    }
}

// Select all filter buttons and attach event listeners
const filterButtons = document.querySelectorAll('.filter-buttons1 button');
filterButtons.forEach(button => {
    button.addEventListener('click', filterCards);
});

// Wait for the DOM content to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    const userIcon = document.querySelector('#user-icon');
    const loginPopup = document.querySelector('#loginPopup');
    const closeLogin = document.querySelector('#closeLogin');
    const blurredOverlay = document.querySelector('#blurredOverlay');

    userIcon.addEventListener('click', () => {
        loginPopup.classList.add('active');
        document.body.classList.add('popup-active'); // Add the class to body
    });

    closeLogin.addEventListener('click', () => {
        loginPopup.classList.remove('active');
        document.body.classList.remove('popup-active'); // Remove the class from body
    });
});

document.addEventListener("DOMContentLoaded", function() {
    const loadMoreButton = document.getElementById("load-more");
    const filterableCards = document.querySelector(".filterable-cards");
    const batchSize = 3; // Number of photos to load per batch
    let currentIndex = 0; // Index of the last photo shown
    let originalPhotos = document.querySelectorAll(".product-box");
    let filteredPhotos = originalPhotos; // Initialize filtered photos with original state
  
    // Function to show the next batch of photos
    function showNextBatch() {
      const endIndex = currentIndex + batchSize;
      for (let i = currentIndex; i < endIndex && i < filteredPhotos.length; i++) {
        filteredPhotos[i].style.display = "block";
        currentIndex++;
      }
  
      // Hide the "Load More" button if there are no more photos to show
      if (currentIndex >= filteredPhotos.length) {
        loadMoreButton.style.display = "none";
      } else {
        loadMoreButton.style.display = "block"; // Ensure the button is visible when there are more photos to load
      }
    }
  
    // Initially show the first batch of photos
    showNextBatch();
  
    loadMoreButton.addEventListener("click", function() {
      // Show the next batch of photos
      showNextBatch();
    });
  
    // Function to filter photos based on the selected category
    function filterPhotos(category) {
      currentIndex = 0; // Reset the current index when applying a filter
      if (category === "all") {
        filteredPhotos = originalPhotos;
      } else {
        filteredPhotos = document.querySelectorAll(`.product-box[data-name="${category}"]`);
      }
  
      // Hide all photos
      originalPhotos.forEach(photo => {
        photo.style.display = "none";
      });
  
      // Show the next batch of photos after filtering
      showNextBatch();
    }
  
    // Event listener for filter buttons
    const filterButtons = document.querySelectorAll(".filter-buttons1 button");
    filterButtons.forEach(button => {
      button.addEventListener("click", function() {
        const category = this.dataset.name;
        filterPhotos(category);
      });
    });
  });
 
