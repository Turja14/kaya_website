/** -- search and menu -- */
let navi = document.querySelector('.navi');
        document.querySelector('#menu-btn').onclick = () =>{
        navi.classList.toggle('active');
        searchform.classList.remove('active');
      }
let searchform = document.querySelector('.search-form');
        document.querySelector('#search-btn').onclick = () =>{
        searchform.classList.toggle('active');
        navi.classList.remove('active');  
      }
      window.onscroll = () => {
          navi.classList.remove('active');
          searchform.classList.remove('active');
      }
/** -- working search bar -- */
function search() {
    let filter = document.getElementById('find').value.toUpperCase();
    let productSection = document.getElementById('product-section');
    let items = productSection.querySelectorAll('.product-box');
    let titles = productSection.getElementsByTagName('h2');
    let found = false;

    for (let i = 0; i < titles.length; i++) {
        let a = items[i].getElementsByTagName('h2')[0];
        let value=a.innerHTML || a.innerText || a.textContent;
        if (value.toUpperCase().indexOf(filter) > -1) {
            items[i].style.display = "";
            found = true;
        } else {
            items[i].style.display = "none";
        }
    }
  }

  // login & reg
  document.addEventListener("DOMContentLoaded", function () {
    const userIcon = document.querySelector('.icons .bx-user');
    const loginPopup = document.getElementById('loginPopup');
    const blurredOverlay = document.querySelector('#blurredOverlay');
    const closeButton = document.getElementById('closeLogin');
  
    // Function to toggle the visibility of the login popup and blurred overlay
    function toggleLoginPopup() {
      loginPopup.classList.toggle('active');
      blurredOverlay.classList.toggle('active');
    }
  
    // Event listener for the user icon to toggle the login popup
    userIcon.addEventListener('click', toggleLoginPopup);
  
    // Event listener for the close button to hide the login popup
    closeButton.addEventListener('click', toggleLoginPopup);
  });

 
var x = document.getElementById("login");
var y = document.getElementById("reg");
var z = document.getElementById("bt");

function register(){
  x.style.left = "-400px";
  y.style.left = "415px";
  z.style.left = "110px";
}
function login(){
  x.style.left = "15px";
  y.style.left = "450px";
  z.style.left = "0px";
}

//slideshow
var indexvalue = 0;
      function slideshow() {
      setTimeout(slideshow, 2500);
      var x;
      const img = document.querySelectorAll(".slides img");
      for (x = 0; x < img.length; x++) {
        img[x].style.display = "none";
      }
      indexvalue++;
      if (indexvalue > img.length) {
       indexvalue = 1;
      }
      img[indexvalue - 1].style.display = "block";
      }
      slideshow();

//cart show
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