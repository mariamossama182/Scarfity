<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Scarfity - Hijabs">
    <meta name="keywords" content="hijab, scarf, fashion">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Scarfity</title>


    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!---bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">


    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="check.css">
</head>

<body>


<?php include 'includes/header.php'; ?>
   <?php include 'cart.php'; ?>

 
    <section class="hero">
        <div class="hero-content">
        <h1 class="welcome">Welcome to Scarfity</h1>
        <p class="slogan">Elegant Hijabs for Every Style ✨</p>
        <p class="description">Discover our collection of premium hijabs and scarves, crafted with love and attention to detail</p>
        <a href="products.php" class="shop-btn">Shop Now</a>
        </div>
    </section>



<!---Slider-->
<!-- <div class="container">
            <div id="cont" class="carousel slide mx-auto my-3" style="max-width: 700px;"
              data-bs-ride="carousel"
              data-bs-interval="3000"
              data-bs-pause="false">

                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#cont" data-bs-slide-to="0" class="active"></button>
                    <button type="button" data-bs-target="#cont" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#cont" data-bs-slide-to="2"></button>
                    <button type="button" data-bs-target="#cont" data-bs-slide-to="3"></button>
                </div>

                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="images/pic2.jpg" class="w-100">
                    </div>
                    <div class="carousel-item">
                        <img src="images/pic4.jpg" class="w-100">
                    </div>
                    <div class="carousel-item">
                        <img src="images/pic3.jpg" class="w-100">
                    </div>
                    <div class="carousel-item">
                        <img src="images/pic1.jpg" class="w-100">
                    </div>
                </div>
                <a href="#cont" class="carousel-control-next" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </a>
                <a href="#cont" class="carousel-control-prev" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </a>
            </div>
        </div>
  -->
         <!-- video-->
        <div class="brand-video">
  <video autoplay muted loop playsinline>
    <source src="multimedia\scarfity_video.mp4" type="video/mp4">
  </video>


  <div class="video-text">
    <h2>Feel the Elegance</h2>
    <p>Discover the beauty of Scarfity ✨</p>
  </div>
</div>



        <div id="ourstory">
            <h3>Our Story</h3>
            <p class="pstory">Scarfity was born from a passion for creating beautiful, high-quality hijabs and scarves
                that empower women
                to express their unique style with confidence and grace.</p>
            <p class="pstory">Each piece in our collection is carefully selected and crafted using premium fabrics that
                are both
                comfortable and elegant. We believe that modesty and fashion can beautifully coexist.</p>
            <p class="pstory">From everyday essentials to special occasion pieces, Scarfity is here to be your trusted
                companion in your
                modest fashion journey.</p>


<a href="about.php" class="shop-btn">Read More</a>
        </div>

        </div>
    </section>
   
    <?php include 'includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<script src="script.js"></script>
</body>
</html>

