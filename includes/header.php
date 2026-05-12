

<nav>
        <div>
            
            <div class="hamburger" onclick="toggleMenu()">
        ☰
    </div>  
            <a id="logo" href="index.php">
                <img src="images/scarfity_feminine_1.png" alt="Scarfity Logo">
            </a>  
            
    </div>

        <div class="nav-links" id="navLinks">
            <a href="index.php">Home</a>
            <a href="products.php">Products</a>
            <a href="about.php">About</a>
            <a href="contact.php">Contact</a>            

             <?php
            if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1 ):
            ?>
            <a href="admin_dashboard.php">Dashboard</a>
            <?php endif; ?>



        </div>
        <div class="nav-right-side">
        <div onclick="open_close_cart()" >
           
          <div>
            <i class="cart-icon fa-solid fa-cart-arrow-down"></i>
            <span id="count">0</span>
         </div>
        </div>
       
         <div class="profile-dropdown">
            <div class="profile-icon" onclick="toggleDropdown()">
                <img src="images/profile.png" alt="profile" class="profile-img" style="width:40px ; cursor: pointer">
            </div>



            <ul class="dropdown-menu" id="dropdown">
                <?php
                    if(isset($_SESSION['username'])){
                        echo "<li class='user-name'>Hello, " . htmlspecialchars($_SESSION['username']). "</li>";
                        echo "<li><a href='logout.php'>Log out</a></li>";




                    }else{
                        echo "<li><a href='sign_in.php'>Sign In</a></li>";
                        echo "<li><a href='register.php'>Register</a></li>";
                    }
                     ?>
               
            </ul>            
        </div>
                    </div>


    </nav>



    <div class="shipping-bar">
        <div class="marquee-content" behavior="scroll" direction="left" scrollamount="6">
           <?php
           $shipping_message = " Free Shipping For Orders Over 1500 EGP ";


           for ($i = 0; $i < 10 ; $i++){
            echo "<span class='marquee-item'>" .$shipping_message. "</span>" ;
           }
           ?>
        </div>
    </div>



<?php if(isset($_SESSION['message'])): ?>
    <div class="message-box <?php echo $_SESSION['msg_type'] ?? ''; ?>" id="flash-msg">
        <?php
            echo $_SESSION['message'];
            unset($_SESSION['message']);
            unset($_SESSION['msg_type']);
        ?>
    </div>



    <script>
        setTimeout(function(){
            var msg = document.getElementById('flash-msg');
            if(msg) {
                msg.style.display = 'none';
            }
        }, 4000);
    </script>
<?php endif; ?>




<script>
function toggleMenu() {
    document.getElementById("navLinks").classList.toggle("active");
}
</script>


