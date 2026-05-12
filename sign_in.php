<?php
session_start();

include'includes/db_connect.php';


$email_error = "";
$pass_error = "";


$host = "localhost";
$user = "root";
$password = "";
$db_name = "scarfity";


if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST['email'];
    $pass = $_POST['password'];

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
             $email_error = "email must include '@' and '.'";
            }
            elseif(strlen($pass) < 8){
             $pass_error = "password must be at least 8 characters";
            }else{
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows > 0){
                $user = $result->fetch_assoc();
                
                if(password_verify($pass, $user['password'])){
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['is_admin'] = $user['is_admin'];


                    $_SESSION['message'] = "✅ Welcome back !";
                    $_SESSION['msg_type'] = "success";
                        header("Location: index.php");   
                     exit();   
                }else{
                    $pass_error = "Wrong Password. Please try again.";
                }    
            }else{
                $_SESSION['message'] = "❌ No account found with this Email ! Please register.";
                $_SESSION['msg_type'] = "error";
                header("Location:register.php");
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
    <title>Sign In - Scarfity</title>
    <!----bootstrap css---->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <!-----CSS---->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="check.css">
    <link rel="stylesheet" href="register.css">

</head>
<body>
    

      <?php include 'includes/header.php'; ?>
    <?php include 'cart.php'; ?>
     


     <div class="container">
        <div class="row justify-content-center align-items-center vh-95">
            <div class="col-lg-4">
                <div class="card shadow-lg p-4 constant-shadow">
                    <h3 class="text-center mb-6" style="color: #c9a26d"><b>Sign In</b></h3>
                        <div id="signin">

                        <form id="registerform" class="needs_validation" method="post" action="" novalidate>
                                                    
                            <div class="mb-3">



                            <label>
                                <span>Email Address</span>
                                    <input type="email" name="email" placeholder="Enter Email" value = "<?php echo isset($email) ? $email : ''; ?>" required>
                                        <?php if($email_error != ""):  ?>
                                        <span style="color:red; padding: 10px; text-align: center; font-size: 20px">
                                        <?php    echo $email_error;    ?>
                                    </span>
                                        <?php    endif;      ?>  
                                </label>


                            <label>
                                <span>Password</span>
                                    <input type="password" name="password" placeholder="Enter password" required>
                                        <?php if($pass_error != ""):  ?>
                                        <span style="color:red; padding: 10px; text-align: center; font-size: 20px">
                                        <?php    echo $pass_error;    ?>
                                    </span>
                                        <?php    endif;      ?>  
                                        </label>

                            <button type="submit" class="btn btn-primary w-100">Submit</button>
                            </form>
                                        </div>                            
                </div>
            </div>
        </div>
    <div>





    <!-------boostrap js-------->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <!-------JS-------->
    <script src="script.js"></script>
</body>
</html>