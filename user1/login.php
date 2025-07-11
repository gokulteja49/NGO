<?php
session_start();
include 'common/connect.php';  
require __DIR__ . '/../vendor/autoload.php';  // Ensure correct path

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$role = $obj->query("SELECT * FROM role WHERE role_id != 1");  

if (isset($_POST['submit'])) {  
    $email = $_POST['email'];  
    $password = $_POST['pass'];  
    $role = $_POST['role'];  

    $result = $obj->query("SELECT * FROM user WHERE email='$email' AND role_id='$role' LIMIT 1");  
    $rowcount = $result->num_rows;  

    if ($rowcount == 1) {  
        $row = $result->fetch_object();  

        if ($password === $row->password) {  
            $_SESSION['email'] = $email;  
            $_SESSION['user_id'] = $row->user_id;  

            // Generate OTP  
            $otp = rand(100000, 999999);  
            $_SESSION['otp'] = $otp;  
            $_SESSION['otp_expiry'] = time() + 300;  

            // Send OTP via email  
            $mail = new PHPMailer(true);  
            try {  
                $mail->isSMTP();  
                $mail->SMTPDebug = 2;  // Enable debugging
                $mail->Host = 'smtp.gmail.com';  
                $mail->SMTPAuth = true;  
                $mail->Username = 'gokulteja152@gmail.com';  
                $mail->Password = 'vzekdoemdqdjyrup'; // ✅ No spaces
 // Use App Password, not your Gmail password  
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  
                $mail->Port = 587;  

                $mail->setFrom('gokulteja152@gmail.com', 'ngowebsite');  
                $mail->addAddress($email); 

                $mail->Subject = 'Your OTP Code';  
                $mail->Body = "Your OTP is: $otp. It is valid for 5 minutes.";  

                $mail->send();  
                echo "<script>alert('OTP sent to your email. Please verify.');window.location='otp_verify.php';</script>";  
            } catch (Exception $e) {  
                echo "<script>alert('Failed to send OTP. Error: " . $mail->ErrorInfo . "');window.location='login.php';</script>";  
            }  
        } else {  
            echo "<script>alert('Incorrect password.');window.location='login.php';</script>";  
        }  
    } else {  
        echo "<script>alert('Invalid email or role.');window.location='login.php';</script>";  
    }  
}
?>



<!doctype html>
<html lang="zxx">


	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>RTF
		</title>
		<!-- Template CSS -->
		<link rel="stylesheet" href="assets/css/style-starter.css">
		<!-- Template CSS -->
		<link href="//fonts.googleapis.com/css?family=Poppins:300,400,400i,500,600,700&display=swap" rel="stylesheet">
		<!-- Template CSS -->
	</head>
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Quicksand", sans-serif;
    }
    
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background: #111;
      width: 100%;
      overflow: hidden;
    }
    
    .ring {
      position: relative;
      width: 500px;
      height: 500px;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    
    .ring i {
      position: absolute;
      inset: 0;
      border: 2px solid #fff;
      transition: 0.5s;
    }
    
    .ring i:nth-child(1) {
      border-radius: 38% 62% 63% 37% / 41% 44% 56% 59%;
      animation: animate 6s linear infinite;
    }
    
    .ring i:nth-child(2) {
      border-radius: 41% 44% 56% 59%/38% 62% 63% 37%;
      animation: animate 4s linear infinite;
    }
    
    .ring i:nth-child(3) {
      border-radius: 41% 44% 56% 59%/38% 62% 63% 37%;
      animation: animate2 10s linear infinite;
    }
    
    .ring:hover i {
      border: 6px solid var(--clr);
      filter: drop-shadow(0 0 20px var(--clr));
    }
    
    @keyframes animate {
      0% {
        transform: rotate(0deg);
      }
      100% {
        transform: rotate(360deg);
      }
    }
    
    @keyframes animate2 {
      0% {
        transform: rotate(360deg);
      }
      100% {
        transform: rotate(0deg);
      }
    }
    
    .login {
      position: absolute;
      width: 300px;
      height: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      gap: 20px;
    }
    
    .login h2 {
      font-size: 2em;
      color: #fff;
    }
    
    .login .inputBx {
      position: relative;
      width: 100%;
    }
    
    .login .inputBx input,
    .login .inputBx select {
      position: relative;
      width: 100%;
      padding: 12px 20px;
      background: transparent;
      border: 2px solid #fff;
      border-radius: 40px;
      font-size: 1.2em;
      color: #fff;
      box-shadow: none;
      outline: none;
    }
    
    .login .inputBx input[type="submit"] {
      width: 100%;
      background: #0078ff;
      background: linear-gradient(45deg, #ff357a, #fff172);
      border: none;
      cursor: pointer;
    }
    
    .login .inputBx input::placeholder {
      color: rgba(255, 255, 255, 0.75);
    }
    
    .login .links {
      position: relative;
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 20px;
    }
    
    .login .links a {
      color: #fff;
      text-decoration: none;
    }
    .custom-control-label{
      color: #fff;
    }
 
select.form-control {
  color: #000; 
  background-color: transparent; 
  border: 2px solid #fff; 
  border-radius: 40px; 
  height: 50px;
}


select.form-control option {
  color: #000; 
  background-color: #fff; 
}


select.form-control option:hover {
  background-color: #f0f0f0; 
}

  </style>
<body>

	

	<?php include 'common/header.php'; ?>

  <body>
  <div class="ring">
    <i style="--clr:#00ff0a;"></i>
    <i style="--clr:#ff0057;"></i>
    <i style="--clr:#fffd44;"></i>
    
    <form class="login" method="post">
      <h2>Sign In</h2>
      
      <!-- Email input -->
      <div class="inputBx">
        <input type="email" id="email" name="email" placeholder="Email" class="form-control form-control-lg" value="<?php if(isset($_COOKIE['email'])) echo $_COOKIE['email']; ?>" required />
      </div>
      
      <!-- Password input -->
      <div class="inputBx">
        <input type="password" id="pass" name="pass" placeholder="Password" class="form-control form-control-lg" value="<?php if(isset($_COOKIE['password'])) echo $_COOKIE['password']; ?>" required />
      </div>
      
      <!-- Role Selection -->
      <div class="inputBx">
        <select class="form-control" id="role" name="role" required>
          <option value="">--Select Role--</option>
          <?php while($r = $role->fetch_object()) { ?>
            <option value="<?php echo $r->role_id; ?>"><?php echo $r->role_name; ?></option>
          <?php } ?>
        </select>
      </div>
      
      <!-- Remember me & Forgot password -->
      <div class="inputBx">
        <div class="custom-control custom-checkbox d-flex justify-content-between">
          <div>
            <input type="checkbox" class="custom-control-input" id="defaultGroupExample1" name="rem" value="rem" <?php if(isset($_COOKIE['email'])) echo "checked"; ?> >
            <label class="custom-control-label" for="defaultGroupExample1">Remember me</label>
          </div>
          <a href="f_pass.php" class="text-decoration-none" style="font-size: 16px; ">Forgot password?</a>
        </div>
      </div>
      
      <!-- Submit button -->
      <div class="inputBx">
        <button type="submit" class="btn btn-primary btn-lg btn-block" name="submit" id="submit">Sign in</button>
      </div>
      
   
    </form>
  </div>
</body>

</body>
<style>@media (max-width: 768px) {
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background: #111;
        width: 100%;
        overflow: hidden;
        padding: 20px;
    }

    .vh-100 {
        height: auto !important;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding-top: 20px;
        padding-bottom: 20px;
    }

    .container {
        padding: 20px;
        width: 100%;
    }

    .ring {
        position: relative;
        width: 90vw;
        max-width: 400px;
        height: 90vw;
        max-height: 400px;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0 auto;
    }

    .ring i {
        position: absolute;
        inset: 0;
        border: 2px solid #fff;
        transition: 0.5s;
    }

    .login {
        position: absolute;
        width: 100%;
        max-width: 280px;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        gap: 15px;
        text-align: center;
        left: 50%;
        transform: translateX(-50%);
    }

    .login h2 {
        font-size: 1.8em;
        color: #fff;
        text-align: center;
    }

    .inputBx {
        width: 100%;
        max-width: 250px;
    }

    form {
        padding: 10px;
        width: 100%;
        max-width: 280px;
    }

    .btn-primary {
        width: 100%;
    }

    .custom-control {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
    }
}

</style>
</html>

<script src="assets/js/jquery-3.3.1.min.js"></script>


<!-- disable body scroll which navbar is in active -->
<script>
  $(function () {
    $('.navbar-toggler').click(function () {
      $('body').toggleClass('noscroll');
    })
  });
</script>


<!--/MENU-JS-->
<script>
  $(window).on("scroll", function () {
    var scroll = $(window).scrollTop();

    if (scroll >= 80) {
      $("#site-header").addClass("nav-fixed");
    } else {
      $("#site-header").removeClass("nav-fixed");
    }
  });

  //Main navigation Active Class Add Remove
  $(".navbar-toggler").on("click", function () {
    $("header").toggleClass("active");
  });
  $(document).on("ready", function () {
    if ($(window).width() > 991) {
      $("header").removeClass("active");
    }
    $(window).on("resize", function () {
      if ($(window).width() > 991) {
        $("header").removeClass("active");
      }
    });
  });
</script>
<!--//MENU-JS-->
<script src="assets/js/bootstrap.min.js"></script>
                

