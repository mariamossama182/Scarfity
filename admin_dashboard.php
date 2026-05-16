<?php
session_start();
include'includes/db_connect.php';

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: sign_in.php");
    exit();
}


if(isset($_POST['add_product'])){
    $name = $_POST['name'];
    $price = $_POST['price'];

    $img = time() . "_" .  $_FILES['image_file']['name'];
    $tmp_name = $_FILES['image_file']['tmp_name'];
    move_uploaded_file($tmp_name, "images/".$img);

   $stmt = $conn->prepare("INSERT INTO products (name, price, image) values ( ?, ?, ?)");
   $stmt->bind_param("sds", $name, $price, $img);
   $stmt->execute();
   $stmt->close();

    header("Location: admin_dashboard.php?page=products");
    exit();
}

if(isset($_POST['update-product'])){
    $id = $_POST['product-id'];
    $name = $_POST['name'];
    $price = $_POST['price'];

    if(!empty($_FILES['image_file']['name'])){
        $img = time() . "_" .  $_FILES['image_file']['name'];
        $tmp_name = $_FILES['image_file']['tmp_name'];
        move_uploaded_file($tmp_name, "images/".$img);

        $stmt = $conn->prepare("UPDATE products SET name=?, price=?, image=? WHERE id=?");
        $stmt ->bind_param( "sdsi", $name, $price, $img, $id);
    }

    else{
        $stmt = $conn->prepare("UPDATE products SET name=?, price=? WHERE id=?");
        $stmt ->bind_param( "sdi", $name, $price, $id);
    }

    $stmt->execute();
    $stmt->close();

    header("Location: admin_dashboard.php?page=products");
    exit();
}



if (isset($_GET['delete-product'])) {
    $id = $_GET['delete-product'];
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: admin_dashboard.php?page=products");
    exit();
}


if (isset($_GET['delete-customer'])) {
    $id = $_GET['delete-customer'];
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ? AND is_admin = 0");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: admin_dashboard.php?page=customers");
    exit();
}

$p_count = $conn->query("SELECT COUNT(*) as t FROM products")->fetch_assoc()['t'];
$u_count = $conn->query("SELECT COUNT(*) as t FROM users WHERE is_admin = 0")->fetch_assoc()['t'];

$income_res = $conn->query("SELECT SUM(total_price) AS total_income FROM orders");
$total_income = $income_res->fetch_assoc()['total_income'];

$page = isset($_GET['page']) ? $_GET['page'] : 'main' ;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard.css">
    <title>Admin Dashboard</title>
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="menu-btn" onclick="toggleSidebar()">
    ☰
   
</div>
            <h2>Scarfity</h2>
        </div>

        <ul class="sidebar-menu">
            <div class="back-to-home">
                        <i><a href="index.php">Home</a></i>
                </div>
            <li><a href="admin_dashboard.php?page=main">Dashboard</a></li>
            <li><a href="admin_dashboard.php?page=products"> Products List </a></li>
            <li><a href="admin_dashboard.php?page=add-product">Add Product</a></li>
            <li><a href="admin_dashboard.php?page=customers">Manage Customers</a></li>
            <li><a href="admin_dashboard.php?page=orders">Orders List</a></li>
        </ul>
    </aside>


    <main class="main-content">
        <div class="content-area">
            <?php if ($page == 'main'):?>

            <h1>Dashboard Overview</h1>

            <div class="stats-grid">
                <div class="cart-dash">
                     <h3>Total Products</h3>
                    <p>  <?php echo $p_count; ?> </p>
                </div>

                <div class="cart-dash">
                     <h3>Total Customers</h3>
                    <p>  <?php echo $u_count; ?> </p>
                </div>
            </div>


            <div class="cart-dash earnings-card">
                 <h3>Total Income</h3>
                   <p><?php echo number_format($total_income ?? 0, 2); ?> EGP</p>

                </div>

                <?php elseif($page == 'products'): ?>
                    <h1> All Products</h1>

                    <table class="admin-table">
                        <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                        <?php
                        $res = $conn->query("SELECT * FROM products");
                        while ($row = $res->fetch_assoc()): ?>
                        <tr>
                            <td><img src="images/<?php echo $row['image']; ?>" width="40"  alt=""></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['price']; ?> EGP</td>
                            <td>
                                 <a href="admin_dashboard.php?page=edit-product&id=<?php echo $row['id'];?>" class="btn-edit">Edit</a>
                                <a href="admin_dashboard.php?page=products&delete-product=<?php echo $row['id']; ?>" onclick="return confirm('Delete this product?')" class="btn-delete">Delete</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </table>


                    <?php elseif ($page == 'add-product'): ?>
                        <h1>Add New Scarf</h1>
                        <div class="form-container">
                        <form action="admin_dashboard.php" method="POST" enctype="multipart/form-data">
                       
                        <div class="input-group">    
                        <label for="">Name:</label><br>
                        <input type="text" name="name" required>
                        </div>

                        <div class="input-group">  
                        <label for="">Price (EGY)</label><br>
                        <input type="number" name="price" min="0" step="0.5" required><br><br>
                        </div>


                        <div class="input-group">    
                        <label for="">Image:</label><br>
                        <input type="file" name="image_file" accept="image/*" required><br><br>
                        </div>

                        <button type="submit" name="add_product" class="add-product-button">Add Product</button>
                        </form>
                        </div>


                        <?php elseif ($page == 'customers'): ?>
                              <h1> Our Customers</h1>

                            <table class="admin-table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        <?php
                        $res = $conn->query("SELECT * FROM users WHERE is_admin = 0");
                        while ($row = $res->fetch_assoc()): ?>
                        <tr>
                            <td>#<?php echo $row['id']; ?></td>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td>
                                <a href="admin_dashboard.php?delete-customer=<?php echo $row['id']; ?>" onclick="return confirm('Remove this customer ?')" class="btn-delete">Remove</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>


                    <?php elseif ($page == 'orders'): ?>
                        <h1>Recent Orders</h1>
                        <table class="admin-table">
                         <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Phone</th>
                            <th>Governorate</th>
                            <th>Total price</th>
                            <th>Items</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                        <?php
                        $res = $conn->query("SELECT *, CONCAT(user_name,' ',second_name) AS full_name FROM orders ORDER BY id DESC ");
                        while ($row = $res->fetch_assoc()):
                            $order_id = $row['id'];
                        ?>
                         <tr>
                            <td>#<?php echo $row['id']; ?></td>
                            <td><?php echo $row['full_name']; ?></td>
                            <td><?php echo $row['phone']; ?></td>
                            <td><?php echo $row['governorate']; ?></td>
                            <td><strong><?php echo $row['total_price']; ?> EGP</strong></td>
                            <td>
                                <?php
                                $items_res = $conn->query("SELECT * FROM order_items WHERE order_id = $order_id");
                                while($item = $items_res->fetch_assoc()) {
                                    echo"• ".$item['product_name'] . " (×" . $item['quantity'] . ")<br>";
                                }
                                ?>
                            </td>
                            <td><?php echo date('Y-m-d', strtotime($row['created_at'])); ?> </td>
                        </tr>
                        <?php endwhile; ?>

                        </tbody>
                    </table>

                    <?php elseif ($page == 'edit-product'):
                    $id = $_GET['id'];
                    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
                    $stmt->bind_param("i",$id);
                    $stmt->execute();
                    $product = $stmt->get_result()->fetch_assoc();
                    ?>

                    <h1> Edit Scarf </h1>
                    <div class="form-container">
                        <form action="admin_dashboard.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="product-id" value="<?php echo $product['id']; ?>" >

                            <div class="input-group">
                                <label>Name:</label>
                                <input type="text" name="name" value="<?php echo $product['name']; ?>" required>
                    </div>

                    <div class="input-group">
                        <label>Price (EGP):</label>
                        <input type="number" name="price" step="0.5" value="<?php echo $product['price']; ?>" required>
                    </div>
                   
                    <div class="input-group">
                        <label>Image (Keep empty to stay the same):</label>
                        <input type="file" name="image_file" accept="image/*">
                    </div>

                    <button type="submit" name="update-product" class="add-product-button" onclick="return confirm('Save Changes?')">Save Changes</button>
                    </form>
                    </div>

            <?php endif; ?>      
           
           <?php 
           if(isset($conn))  { $conn->close(); } 
           ?>
           
        </div>
    </main>
    <script>
function toggleSidebar(){
    document.querySelector(".sidebar-menu").classList.toggle("active");
}
</script>
</body>
</html>