<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us</title>




  <!-- CSS -->
  <link rel="stylesheet" href="about.css">
  <link rel="stylesheet" href="style.css">




</head>


<body>




  <!-- Header -->
  <?php include("includes/header.php"); ?>
  <?php include 'cart.php'; ?>




  <!-- Banner Section -->
  <section class="about-banner">
    <div class="about-overlay"></div>
    <h1 class="about-title">ABOUT US</h1>
  </section>




  <!-- About Content -->
  <section class="about-container">




  <!-- Video Section -->
<section class="about-video fade-up">
  <h2>About our collection 🎀</h2>


  <video controls>
    <source src="multimedia/plain.mp4" type="video/mp4">
    Your browser does not support the video tag.
  </video>


</section>
   
    <!-- Left -->
    <div class="about-left">
      <h2 class="fade-up">A brand new way✨</h2>








      <div class="fade-up delay">
        <h3>Care instructions ! :</h3>
        <p>
          To keep your favorite SCARFITY Hijab in a perfect condition , <br> we recommend:
        </p>
        <p>- Use pins without a pin.</p>
        <p>- Handwashing with cold water, and avoiding harsh rinsing or dryers.</p>
        <p>Ironing at low temperature.</p>


        <br>




        <p><strong>Shipping:</strong> 7 working days</p>
        <p><strong>Exchange & Return policy:</strong> Available</p>
        <a href="products.php" class="shop-btn">SHOP NOW</a>
      </div>
    </div>




    <!-- Right -->
    <div class="about-right fade-up delay-2">
      <p class="arabic">
        فَاسْتَأْنَفَتْ قُوَّتِي مِنْ وَرَاءِ حِجَابٍ يَكْتُمُ أَسْرَارَ رُوحِي"
      </p>




      <p class="arabic-sub">
        " هو شخصيتي وقوتي ومرآة إصراري، فهو مثل الجوهرة التي تضع بصمتها.
        
      </p>




      
    </div>


  </section>




  <!-- Footer -->
  <?php include("includes/footer.php"); ?>
  <script src="script.js"></script>



</body>
</html>
