<?php
session_start();

include'includes/db_connect.php';

$email_error = "";
$pass_error = "";
$conf_error = "";

if(isset($_POST['register_btn'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $conf = $_POST['confirm_password'];
    

if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $email_error = "email must include '@' and'.'";
}
if(strlen($pass) < 8){
    $pass_error = "password must be at least 8 characters";
}

if($pass !== $conf){
    $conf_error = "Passwords don't match";
}

if(empty($email_error) && empty($pass_error) && empty($conf_error)){
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

        $stmt_check = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $result = $stmt_check->get_result();

    if(mysqli_num_rows($result) > 0){
        $_SESSION['message'] = "❌ You already have an account ! Please sign in.";
        $_SESSION['msg_type'] = "error";
        header("Location: sign_in.php");
        exit();
    }else{
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?,?,?)");
        $stmt->bind_param("sss", $username, $email, $hashed_password);
        $stmt->execute();

        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit();
        }
    }
}
if(isset($conn)){
    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Registration</title>

<link rel="stylesheet" href="register.css">
<link rel="stylesheet" href="check.css">
<link rel="stylesheet" href="style.css">

</head>

<body>

     <?php include 'includes/header.php'; ?>
    <?php include 'cart.php'; ?>


    <div class="container">
    <div class="row justify-content-center align-items-center vh-95">
        <div class="col-auto">
            <div class="card shadow-lg p-5 mb-7">
                <h3 class="mb-6" style="text-align:center; color: #c9a26d;">Register</h3>

                 <form id="registerform" action="" method="post" novalidate>
                    <label>
                        <span>User Name</span>
                        <input type="text" name="username" placeholder="Enter Your Name"
                                value = "<?php echo isset($username) ? $username : ''; ?>" required/>
                    
                </label>




                <label>
                    <span>Email</span>
                    <input type="email" name="email" placeholder="Enter Email"
                                value = "<?php echo isset($email) ? $email : ''; ?>" required/>
                                <?php if($email_error != ""):  ?>
                                    <span style="color:red; padding: 10px; text-align: center; font-size: 20px">
                                    <?php    echo "Email must include '@' and '.'";    ?>
                                </span>
                                    <?php    endif;      ?>          
                </label>


                <label>
                    <span>Password</span>
                    <input type="password" name="password" placeholder="New Password" minlength="8" required/>
                                    <?php if($pass_error != ""):
                                        echo "<span style='color:red; padding: 10px; text-align: center; font-size: 20px'>
                                                Password must be at least 8 characters</span>";
                                    endif;
                                    ?>
                                
                </label>



                <label>
                    <span>Confirm Password</span>
                    <input type="password" name="confirm_password" placeholder="Confirm Password" minlength="8" required/>
                                    <?php if($conf_error != ""):  ?>
                                    <span style="color:red; padding: 10px; text-align: center; font-size: 20px">
                                    <?php    echo $conf_error;    ?>
                                </span>
                                    <?php    endif;      ?>
                </label>


                <button type="submit" name="register_btn">Register</button>


                </form>

            </div>
        </div>
    </div>
</div>

   
<script src="script.js"></script>

</body>
</html>
