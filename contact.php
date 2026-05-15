<?php
session_start();
include 'includes/db_connect.php';

$error = [];
$name = $email = $phone = $msg = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name  = trim($_POST['name'] ?? "");
    $email = trim($_POST['email'] ?? "");
    $phone = trim($_POST['phone'] ?? "");
    $msg   = trim($_POST['msg'] ?? "");

    // Validation
    if (strlen($name) < 3){
        $error[] = "Name must be at least 3 characters.";
    }


    if (!$email) {
        $error[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error[] = "Invalid email format";
    }


    if (!$phone) {
        $error[] = "Phone is required";
    } elseif (!preg_match("/^01[0-9]{9}$/", $phone)) {
        $error[] = "Invalid phone number";
    }

    if (!$msg) {
        $error[] = "Message is required";
    }

    // لو مفيش errors
    if (empty($error)) {

        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, phone, message) VALUES (?, ?, ?, ?)");

        if ($stmt) {

            $stmt->bind_param("ssss", $name, $email, $phone, $msg);

            if ($stmt->execute()) {

                $_SESSION['success'] = "✅ Message sent successfully! Thank You For Contacting Us 🎀";

                $stmt->close();
                $conn->close();

                header("Location: contact.php");
                exit();

            } else {

                $error[] = "Database Error";

                $stmt->close();
            }

        } else {

            $error[] = "Prepare Failed";
        }

        if (isset($conn))  {$conn->close();}
    }
}
?>

<!DOCTYPE html>
<html>
<head>
 <title>Contact form</title>
 <link href="style.css" rel="stylesheet">
 <link href="style2.css" rel="stylesheet">
  <link href="check.css" rel="stylesheet">

 <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

<?php include 'includes/header.php'; ?>
<?php include 'cart.php'; ?>
<div class="wrap">

    <div class="right">
        <h2>Contact Us 💫</h2>
       
        <!-- Errors -->
<?php   if (isset($_SESSION['success'])):   ?> 

<div id="success-message" class="message-box success">

    <?php   echo $_SESSION['success'];
            unset($_SESSION['success']);    ?>  </div>
    <?php   endif;  ?>


        <form method="POST" id="contactForm" novalidate>

            <label>
                <span>Name</span>
                <input type="text" name="name" id="name" placeholder="Type your name" value="<?php echo htmlspecialchars($name); ?>" required minlength="3"> 
                <span class="error-text" id="nameError"></span>
            </label>


            <label>
                <span>Email</span>
                <input type="email" name="email" id="email" placeholder="Type your email" value="<?php echo htmlspecialchars($email); ?>" required >
                <span class="error-text" id="emailError"></span>
            </label>


            <label>
                <span>Phone</span>
                <input type="text" name="phone" id="phone" placeholder="Type your phone" value="<?php echo htmlspecialchars($phone); ?>" required pattern="^01[0-9]{9}$" minlength="11" maxlength="11">
                <span class="error-text" id="phoneError"></span>
            </label>

            <label>
                <span>Message</span>
                <textarea name="msg" id="msg" placeholder="Enter your message" required><?php echo htmlspecialchars($msg); ?></textarea>
                <span class="error-text" id="msgError"></span>
            </label>

            <button type="submit" id="submitBtn">Send Message</button>

        </form>
    </div>


    <div class="left">
        <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d55297.321179520855!2d32.55269465624751!3d29.97705683884362!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1456257838ae4111%3A0x1f0a056a97ea1bc0!2z2KfZhNiz2YjZitiz2Iwg2YXYrdin2YHYuNipINin2YTYs9mI2YrYsw!5e0!3m2!1sar!2seg!4v1777212440227!5m2!1sar!2seg"
        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>

</div>

<script src="script.js"></script>

<!-- ____________________________________________________________________________________ -->

<script type="text/javascript"src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>

<script type="text/javascript">
    (function(){
    emailjs.init("q-0eAuewZhcLh5gcZ");
    })();


    const form = document.getElementById('contactForm');


    function validate(){

        let isValid = true;

        const name = document.getElementById('name');
        const nameError = document.getElementById('nameError');

        if(name.value.trim().length < 3){
            nameError.innerText = "Name must be at least 3 characters.";
            name.classList.add('invalid');
            isValid = false;
        }else{
            nameError.innerText = "";
            name.classList.remove('invalid');
        }


        const email = document.getElementById('email');
        const emailError = document.getElementById('emailError');
        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if(!emailRegex.test(email.value.trim())){
            emailError.innerText = "Enter valid email address.";
            email.classList.add('invalid');
            isValid = false;
        }else{
            emailError.innerText = "";
            email.classList.remove('invalid');
        }


        const phone = document.getElementById('phone');
        const phoneError = document.getElementById('phoneError');
        const phoneRegex = /^01[0-9]{9}$/;
        if(!phoneRegex.test(phone.value.trim())){
            phoneError.innerText = "Phone must be 11 digits starting with 01 .";
            phone.classList.add('invalid');
            isValid = false;
        }else{
            phoneError.innerText = "";
            phoneError.classList.remove('invalid'); 
        }


        const msg = document.getElementById('msg');
        const msgError = document.getElementById('msgError');
        if(msg.value.trim() === ""){
            msgError.innerText = "Message cannot be empty.";
            msg.classList.add('invalid');
            isValid = false;
        }else{
            msgError.innerText = "";
            msg.classList.remove('invalid');
        }
        return isValid;
    }

    form.addEventListener('submit', function(event) {
    event.preventDefault();

    if(validate()){
        const submit_btn = document.getElementById('submitBtn');
        submit_btn.disabled = true;
        submit_btn.innerText = "Sending ... ";
    
    const serviceID = 'service_scarfity';
    const templateID = 'template_ubdd32o';


        emailjs.sendForm(serviceID, templateID, form)
        .then(() => {
        console.log('Email sent successfully!🎀');
        form.submit();
     })
     .catch((err) => {
            alert("Failed to send email: " + JSON.stringify(err));

            submit_btn.disabled = false;
            submit_btn.innerText = "Send Message";
        });
        }
    });
</script>

<script>

setTimeout(function () {

    let message = document.getElementById("success-message");

    if(message){
        message.style.display = "none";
    }

}, 3000);

</script>

</body>
</html>