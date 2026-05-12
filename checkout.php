<?php
 session_start();

 include'includes/db_connect.php';


if(!isset($_SESSION['user_id'])){
    header("Location: sign_in.php");
    exit(); }

 
$message = "";
$messageType = "";
$errors=[];

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $user_name =trim ($_POST['userName']);
    $second_name = trim( $_POST['name2']);
    $phone = trim($_POST['phone']);
    $phone2 =trim ($_POST['phone2']);
    $address =trim ( $_POST['address']);
     $governorate = $_POST['governorate'];
    $email = trim ($_POST['email']);
    $notes = trim($_POST['notes']);
    $payment = $_POST['payment'];
    $total_qty = $_POST['total_quantity'];

    if(empty($user_name)){
        $errors[] = "First name is required";
    } elseif(strlen($user_name) < 2){
        $errors[] = "First name must be at least 2 characters";
    } elseif(strlen($user_name) > 50){
        $errors[] = "First name cannot exceed 50 characters";
    }

    if(empty($phone)){
        $errors[] = "Phone number is required";
    } else {
        $clean_phone = preg_replace('/[^0-9]/', '', $phone);
        if(!preg_match('/^01[0-9]{9}$/', $clean_phone)){
            $errors[] = "Phone number must be a valid number (e.g. 01012345678)";
        }
    }
    
    if(!empty($phone2)){
        $clean_phone2=preg_replace('/[^0-9]/', '', $phone2);
        if(!preg_match('/^01[0-9]{9}$/', $clean_phone2)){
            $errors[]="Second phone number is invalid";
        }
    }
    
    if(empty($email)){
        $errors[] = "Email is required";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors[] = "Please enter a valid email address (e.g. name@example.com)";
    }

    if(empty($address)){
        $errors[] = "Address is required";
    } elseif(strlen($address) < 5){
        $errors[] = "Please enter a complete address";
    }

    
    
    if(!empty($errors)){
        // $message = "❌ Please fix the following errors:<br>";
        foreach($errors as $error){
            $message .= "• " . htmlspecialchars($error) . "<br>";
        }
        $messageType = "error";
    }

   else {
    $cart_items = json_decode($_POST['cart_items'], true);
        
    if(empty($cart_items)){
    $errors[] = "Cart is empty or invalid";
}
             $total_price = 0;
            foreach($cart_items as $item){
            $total_price += $item['price'] * $item['qty'];
             }
            
        $sql = "INSERT INTO orders 
        (user_name, second_name, phone, phone2, address, governorate, email, notes, payment_method, total_price, total_quantity)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssssdi", $user_name, $second_name, $phone, $phone2, $address, $governorate, $email, $notes, $payment, $total_price, $total_qty);
        
        if($stmt->execute()){
        
            $order_id = $conn->insert_id;

            $sql_item = "INSERT INTO order_items (order_id, product_name, price, quantity) VALUES (?, ?, ?, ?)";
            $stmt_item = $conn->prepare($sql_item);

            foreach($cart_items as $item){
                $name = $item['name'];
                $price = $item['price'];
                $qty = $item['qty'];
                
                $stmt_item->bind_param("isdi", $order_id, $name, $price, $qty);
                $stmt_item->execute();
            }
            
            $stmt_item->close();

            $message = "✅ Order placed successfully! Thank you for shopping with us.";
            $messageType = "success";
            
            echo "<script>localStorage.removeItem('cart');</script>";
            echo "<script>setTimeout(function(){ window.location.href = 'index.php'; }, 1000);</script>";
        } else {
            $message = "❌ Error: " . htmlspecialchars($stmt->error);
            $messageType = "error";
        }
        
        $stmt->close();
    }
}
if(isset($conn) && $conn){
       $conn->close(); 
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="style.css" rel="stylesheet">
    <link href="check.css" rel="stylesheet">

</head>

<body>

<?php include 'includes/header.php'; ?>
<?php include 'cart.php'; ?>

<?php if($message != ""): ?>
    <div class="message-box <?php echo htmlspecialchars($messageType); ?>">
        <?php echo $message; ?>
    </div>
<?php endif; ?>

<form id="checkoutForm" action="" method="post">
    <label> 
        <span>First Name</span>
        <input type="text" name="userName"  value="<?php echo htmlspecialchars($_POST['userName'] ?? '' ); ?>" 
        placeholder="Enter First Name" required/>
    </label>

    <label>
        <span>Second Name</span>
        <input type="text" name="name2" value="<?php echo htmlspecialchars($_POST['name2']?? '');?>"
        placeholder="Enter Second Name" /> 
    </label>

    <label>
        <span>Phone</span>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($_POST['phone'] ?? '');?>" 
        placeholder="01*********" required/>
    </label>

    <label>
        <span>Second Phone</span>
        <input type="text" name="phone2" value="<?php echo htmlspecialchars($_POST['phone2'] ?? '');?>"
        placeholder="01********* (optional)" />
    </label> 

    <div class="form-group">
        <span>Governorate </span>
        <select name="governorate" required>
        <option value="">Select Governorate</option>
        <option value="Cairo" <?php echo ($_POST['governorate'] ?? '') == 'Cairo' ? 'selected' : ''; ?>>Cairo</option>
        <option value="Alexandria" <?php echo ($_POST['governorate'] ?? '') == 'Alexandria' ? 'selected' : ''; ?>>Alexandria</option>
        <option value="Giza"  <?php echo ($_POST['governorate'] ?? '') == 'Giza' ? 'selected' : ''; ?>>Giza</option>
        <option value="Sharkia" <?php echo ($_POST['governorate'] ?? '') == 'Sharkia' ? 'selected' : ''; ?>>Sharkia</option>
         <option value="Dakahlia" <?php echo ($_POST['governorate'] ?? '') == 'Dakahlia' ? 'selected' : ''; ?>>Dakahlia</option>
         <option value="Beheira" <?php echo ($_POST['governorate'] ?? '') == 'Beheira' ? 'selected' : ''; ?>>Beheira</option>
        <option value="Qalyubia" <?php echo ($_POST['governorate'] ?? '') == 'Qalyubia' ? 'selected' : ''; ?>>Qalyubia</option>
        <option value="Monufia" <?php echo ($_POST['governorate'] ?? '') == 'Monufia' ? 'selected' : ''; ?>>Monufia</option>
        <option value="Gharbia" <?php echo ($_POST['governorate'] ?? '') == 'Gharbia' ? 'selected' : ''; ?>>Gharbia</option>
        <option value="Kafr El Sheikh" <?php echo ($_POST['governorate'] ?? '') == 'Kafr El Sheikh' ? 'selected' : ''; ?>>Kafr El Sheikh</option>
        <option value="Ismailia" <?php echo ($_POST['governorate'] ?? '') == 'Ismailia' ? 'selected' : ''; ?>>Ismailia</option>
        <option value="Port Said" <?php echo ($_POST['governorate'] ?? '') == 'Port Said' ? 'selected' : ''; ?>>Port Said</option>
        <option value="Suez" <?php echo ($_POST['governorate'] ?? '') == 'Suez' ? 'selected' : ''; ?>>Suez</option>
        <option value="Damietta" <?php echo ($_POST['governorate'] ?? '') == 'Damietta' ? 'selected' : ''; ?>>Damietta</option>
        <option value="Red Sea" <?php echo ($_POST['governorate'] ?? '') == 'Red Sea' ? 'selected' : ''; ?>>Red Sea</option>
        <option value="North Sinai" <?php echo ($_POST['governorate'] ?? '') == 'North Sinai' ? 'selected' : ''; ?>>North Sinai</option>
        <option value="South Sinai" <?php echo ($_POST['governorate'] ?? '') == 'South Sinai' ? 'selected' : ''; ?>>South Sinai</option>
        <option value="Matrouh" <?php echo ($_POST['governorate'] ?? '') == 'Matrouh' ? 'selected' : ''; ?>>Matrouh</option>
        <option value="Luxor" <?php echo ($_POST['governorate'] ?? '') == 'Luxor' ? 'selected' : ''; ?>>Luxor</option>
        <option value="Aswan" <?php echo ($_POST['governorate'] ?? '') == 'Aswan' ? 'selected' : ''; ?>>Aswan</option>
        <option value="Sohag" <?php echo ($_POST['governorate'] ?? '') == 'Sohag' ? 'selected' : ''; ?>>Sohag</option>
        <option value="Qena" <?php echo ($_POST['governorate'] ?? '') == 'Qena' ? 'selected' : ''; ?>>Qena</option>
        <option value="Asyut" <?php echo ($_POST['governorate'] ?? '') == 'Asyut' ? 'selected' : ''; ?>>Asyut</option>
        <option value="Beni Suef" <?php echo ($_POST['governorate'] ?? '') == 'Beni Suef' ? 'selected' : ''; ?>>Beni Suef</option>
        <option value="Faiyum" <?php echo ($_POST['governorate'] ?? '') == 'Faiyum' ? 'selected' : ''; ?>>Faiyum</option>
        <option value="Minya" <?php echo ($_POST['governorate'] ?? '') == 'Minya' ? 'selected' : ''; ?>>Minya</option>
        <option value="New Valley" <?php echo ($_POST['governorate'] ?? '') == 'New Valley' ? 'selected' : ''; ?>>New Valley</option>
        </select>
    </div>

    <label> 
        <span>Address</span>
        <input type="text" name="address" value="<?php echo htmlspecialchars($_POST['address']??'');?>" 
        placeholder="Street, Building, Apartment Number" required/>
    </label>

    <label>
        <span>Email</span>
        <input type="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ??'');?>"
        placeholder="Enter Email" required>
    </label>

    <label>
        <label>
    <span>Notes</span>
    <textarea name="notes" placeholder="Add your Notes (optional)"><?php echo htmlspecialchars($_POST['notes'] ?? ''); ?></textarea>
</label>
    </label>

    <span>Payment Method</span>
    <div class="payment_methods">
        <input type="radio" name="payment" value="cash"
         <?php echo ($_POST['payment'] ?? 'cash') == 'cash' ? 'checked' : ''; ?>>
        <label>Cash</label>

        <input type="radio" name="payment" value="card"
         <?php echo ($_POST['payment'] ?? '') == 'card' ? 'checked' : ''; ?>>         
        <label>Credit</label>
    </div>

    <div class="order_summary">
        <h4>Order Summary</h4>
        <p><b>Total Quantity:</b> <span id="total_quantity">0</span></p> <br>
        <p>Cost: <span id="cost">0</span> EGP</p>
        <p>Delivery: <span id="delivery">0</span> EGP</p>
        <p>Total Price: <span id="total_price">0</span> EGP</p>

    </div>
    <!-- <input type="hidden" name="total_price" id="hidden_price"> -->
<input type="hidden" name="total_quantity" id="hidden_qty">
<input type="hidden" name="cart_items" id="hidden_cart">

    <button type="submit" id="checkoutBtn">CHECKOUT</button>
</form>

<?php include 'includes/footer.php'; ?>
<script src="script.js"></script>

<script>
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        let totalPrice = document.getElementById('total_price').innerText;
        let totalQuantity = document.getElementById('total_quantity').innerText;

        if(totalQuantity == "0" || totalQuantity == 0) {
            e.preventDefault();
            showEmptyCartMessage();
            return false;
        }

   
    let cart = JSON.parse(localStorage.getItem("cart")) || [];

document.getElementById('hidden_qty').value = totalQuantity;
document.getElementById('hidden_cart').value = JSON.stringify(cart);
    });

    function showEmptyCartMessage() {

        let existingMsg = document.querySelector('.empty-cart-warning');
        if(existingMsg) existingMsg.remove();
        
        let warningDiv = document.createElement('div');
        warningDiv.className = 'message-box error empty-cart-warning';
        warningDiv.innerHTML = ' ❌ Your cart is empty! Please add some items before checkout.';
        document.body.insertBefore(warningDiv, document.body.firstChild);
        
        setTimeout(function() {
            warningDiv.style.opacity = '0';
            setTimeout(function() {
                if(warningDiv) warningDiv.remove();
            }, 500);
         }, 3000);
     }
</script>

</body>
</html>