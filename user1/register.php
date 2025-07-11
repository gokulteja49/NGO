<?php
session_start();
include 'common/connect.php';
require __DIR__ . '/../vendor/autoload.php'; // Ensure PHPMailer is loaded

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$message = ""; // Store success/error messages

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password']; // ⚠️ Plain text storage (not recommended)
    $cpass = $_POST['cpassword'];
    $contact = trim($_POST['contact']);
    $gender = $_POST['gender'];
    $reg_date = date('Y-m-d');
    $is_volunteer = isset($_POST['is_volunteer']) ? intval($_POST['is_volunteer']) : 0;

    // Validate input
    if (empty($name) || empty($email) || empty($password) || empty($cpass) || empty($contact) || empty($gender)) {
        $message = "<p style='color: red;'>All fields are required!</p>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "<p style='color: red;'>Invalid email format!</p>";
    } elseif ($password !== $cpass) {
        $message = "<p style='color: red;'>Passwords do not match!</p>";
    } else {
        // Generate OTP
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;
        $_SESSION['email'] = $email;
        $_SESSION['user_data'] = [
            'name' => $name,
            'password' => $password, // ⚠️ Storing as plain text
            'contact' => $contact,
            'gender' => $gender,
            'reg_date' => $reg_date,
            'is_volunteer' => $is_volunteer
        ];
        $_SESSION['otp_expiry'] = time() + 300; // OTP expires in 5 minutes

        // Send OTP Email
        if (sendOTPEmail($email, $otp)) {
            echo "<script>alert('OTP sent to your email. Please verify.'); window.location='otp_verification.php';</script>";
            exit;
        } else {
            $message = "<p style='color: red;'>Error sending OTP. Please try again.</p>";
        }
    }
}

// Function to send OTP email
function sendOTPEmail($email, $otp) {
    $mail = new PHPMailer(true);
    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->SMTPDebug = 0; // Set to 2 for debugging
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'gokulteja152@gmail.com'; // Your Gmail
        $mail->Password = 'vzekdoemdqdjyrup'; // Your App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email Headers
        $mail->setFrom('gokulteja152@gmail.com', 'ngowebsite');
        $mail->addAddress($email);

        // Email Content
        $mail->Subject = "Your OTP Code - RTF";
        $mail->isHTML(true);
        $mail->Body = "
            <html>
            <head><title>OTP Verification</title></head>
            <body>
                <p>Dear User,</p>
                <p>Your OTP code is: <strong>$otp</strong></p>
                <p>This OTP is valid for 5 minutes.</p>
                <p>Thank you!</p>
            </body>
            </html>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>




<!doctype html>
<html lang="zxx">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>RTF - Register</title>
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="assets/css/style-starter.css">

    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');

        /* Wrapper and Login Box Styles */
        .wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            width: 100%;
            background: url('https://codingstella.com/wp-content/uploads/2024/01/download-5.jpeg') no-repeat;
            background-size: cover;
            background-position: center;
            animation: animateBg 5s linear infinite;
        }

        @keyframes animateBg {
            100% {
                filter: hue-rotate(360deg);
            }
        }

        .login-box {
            position: relative;
            width: 400px;
            background: transparent;
            border-radius: 15px;
            border: 2px solid rgba(255, 255, 255, .5);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(15px);
            padding: 30px;
            box-sizing: border-box;
        }

        h2 {
            font-size: 2em;
            color: #fff;
            text-align: center;
            margin-bottom: 20px;
        }

        .input-box {
            position: relative;
            width: 100%;
            margin: 15px 0;
            border-bottom: 1px solid #fff;
        }

        .input-box label {
            position: absolute;
            top: 50%;
            left: 5px;
            transform: translateY(-50%);
            font-size: 1em;
            color: #fff;
            pointer-events: none;
            transition: .5s;
        }

        .input-box input:focus ~ label,
        .input-box input:valid ~ label {
            top: -5px;
        }

        .input-box input {
            width: 100%;
            height: 50px;
            background: transparent;
            border: none;
            outline: none;
            font-size: 1em;
            color: #fff;
            padding: 0 35px 0 5px;
        }

        .input-box .icon {
            position: absolute;
            right: 8px;
            top: 50%;
            color: #fff;
            transform: translateY(-50%);
        }

        .form-checked {
            margin-top: 15px;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            color: #fff;
            font-size: 1em;
        }

        .custom-control {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .custom-control input[type="radio"] {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid #fff;
            background-color: transparent;
            appearance: none;
            outline: none;
            cursor: pointer;
            margin-right: 10px;
        }

        .custom-control input[type="radio"]:checked {
            background-color: #fff;
            border: 2px solid #fff;
        }

        .custom-control label {
            color: #fff;
            font-size: 1em;
            margin-left: 5px;
        }

        form button {
    width: 100%; /* Adjust width as needed */
    height: 45px; /* Slightly larger height */
    background-color: #007bff; /* Change to blue or preferred color */
    border: none;
    border-radius: 5px; /* Smaller border-radius */
    color: white;
    font-size: 1em;
    font-weight: bold;
    cursor: pointer;
    margin-top: 10px;
    transition: 0.3s ease-in-out;
}

form button:hover {
    background-color: #0056b3; /* Darker blue on hover */
}


        .register-link {
            font-size: .9em;
            color: #fff;
            text-align: center;
            margin: 25px 0 10px;
        }

        .register-link p a {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
        }

        .register-link p a:hover {
            text-decoration: underline;
        }

        @media (max-width: 500px) {
            .login-box {
                width: 100%;
                height: auto;
                border: none;
                border-radius: 0;
            }
        }
        
    </style>

</head>
<body>
<?php include 'common/header.php'; ?>

    <div class="wrapper">
        <div class="login-box">
            <h2>Register</h2>
            <form method="post" class="signin-form">
                <div class="input-box">
                    <input type="text" name="name" id="name" placeholder="" required />
                    <label for="name">Full Name</label>
                </div>

                <div class="input-box">
                    <input type="email" name="email" id="email" placeholder="" required />
                    <label for="email">Email Address</label>
                </div>

                <div class="input-box">
                    <input type="password" name="password" id="password" placeholder="" required />
                    <label for="password">Password</label>
                </div>

                <div class="input-box">
                    <input type="password" name="cpassword" id="cpassword" placeholder="" required />
                    <label for="cpassword">Confirm Password</label>
                </div>

                <div class="input-box">
                    <input type="text" name="contact" id="contact" maxlength="10" placeholder="" required />
                    <label for="contact">Contact Number</label>
                </div>

                <!-- Gender Selection -->
                <div class="form-checked">
                    <label>Gender:</label>
                    <div class="custom-control">
                        <input type="radio" id="male" name="gender" value="Male" required>
                        <label for="male">Male</label>
                    </div>
                    <div class="custom-control">
                        <input type="radio" id="female" name="gender" value="Female">
                        <label for="female">Female</label>
                    </div>
                </div>

                <!-- Volunteer Selection -->
                <div class="form-checked">
                    <label>Volunteer?</label>
                    <div class="custom-control">
                        <input type="radio" id="volunteer_yes" name="is_volunteer" value="1" required>
                        <label for="volunteer_yes">Yes</label>
                    </div>
                    <div class="custom-control">
                        <input type="radio" id="volunteer_no" name="is_volunteer" value="0" required>
                        <label for="volunteer_no">No</label>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" name="submit">Register</button>

                <!-- Success/Error Message -->
                <div class="message-container">
                    <?php echo $message ?? ''; ?>
                </div>

                <!-- Register Link -->
                <div class="register-link">
                    <p>Already have an account? <a href="login.php">Login here</a></p>
                </div>
            </form>
        </div>
    </div>

    
    <script src="assets/js/jquery-3.3.1.min.js"></script>
<script>
  $(function () {
    $('.navbar-toggler').click(function () {
      $('body').toggleClass('noscroll');
    });
  });

  $(window).on("scroll", function () {
    var scroll = $(window).scrollTop();
    if (scroll >= 80) {
      $("#site-header").addClass("nav-fixed");
    } else {
      $("#site-header").removeClass("nav-fixed");
    }
  });

  $(".navbar-toggler").on("click", function () {
    $("header").toggleClass("active");
  });

  $(document).ready(function () {
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
<script src="assets/js/bootstrap.min.js"></script>

</body>
</html>


