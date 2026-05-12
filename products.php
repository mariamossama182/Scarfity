<?php
session_start();

 include 'includes/db_connect.php';

$type = isset($_GET['type']) ? $_GET['type'] : 'all';



if ($type == "all") {
    $sql = "SELECT * FROM products";
} else {
    $sql = "SELECT * FROM products WHERE type='$type'";
}

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Products - Scarfity</title>


<link rel="stylesheet" href="style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" >

<!---->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css">


</head>
<body>
 <?php include 'includes/header.php'; ?>
    <?php include 'cart.php'; ?>
     
<section class="products-section">
 <h2 class="collection-title">Our Collection💖</h2>


<!-- 🔘 Filter Buttons -->
<div class="text-center mb-4">
    <a href="products.php?type=all" class="btn btn-outline-dark">All</a>
    <a href="products.php?type=plain" class="btn btn-outline-dark">Plain</a>
    <a href="products.php?type=printed" class="btn btn-outline-dark">Printed</a>
</div>


<!-- 🔷 Products -->
<section class="container">
    <div class="row">


    <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card p-3">


                <a href ="images/<?php echo $row['image']; ?>"
                data-fancybox="gallery"
                data-caption = "<?php echo $row['name']; ?> - <?php echo $row['price']; ?> EGP ">


                <img src="images/<?php echo $row['image']; ?>"
                    class="img-fluid rounded"
                    alt="<?php echo $row['name']; ?>"
                    style = "cursor: zoom-in;">
                </a>


                <h5 class="mt-3"><?php echo $row['name']; ?></h5>
                <p><?php echo $row['price']; ?> EGP</p>


                <button onclick="addToCart(
    <?php echo $row['id']; ?>,
    '<?php echo $row['name']; ?>',
    <?php echo $row['price']; ?>,
    '<?php echo $row['image']; ?>'
)">
<i class="fa-solid fa-cart-arrow-down"></i> Add to Cart
                </button>
            </div>
        </div>
<?php } ?>


</div>
</section>
</section>


 <?php include 'includes/footer.php'; ?>
<script src="script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script>
    Fancybox.bind("[data-fancybox]", {});
</script>
<?php mysqli_close($conn); ?>
</body>
</html>