<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
         <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="cart ">
  <div class="top_cart">
    <h3>Cart Items : <span class="count_item_cart">0</span></h3>
    <span onclick="open_close_cart()" class="close_cart"><i class="fa-regular fa-circle-xmark"></i></span>
  </div>
  <div class="items_in_cart" id="cart_items">
  </div>

  <div class="bottom_cart">
    <div class="total">
        <p>Total</p>
        <p class="price_cart_total">0 EGP</p>
    </div>
    <div class="button_cart">
        <?php
        $link = isset($_SESSION['user_id']) ? "checkout.php" : "sign_in.php";
        ?>
        <a href="<?php echo $link; ?>" class="btn_cart ">Checkout</a>
        <a href="products.php"  class="btn_cart ">shopmore</a>
    </div>
  </div>
  </div>

</body>
</html>