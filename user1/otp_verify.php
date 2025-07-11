<?php  
session_start();  

if (!isset($_SESSION['email']) || !isset($_SESSION['otp'])) {  
    echo "<script>alert('Session expired. Please login again.');window.location='login.php';</script>";  
    exit;  
}  

if (isset($_POST['verify_otp'])) {  
    $entered_otp = $_POST['otp'];  

    if ($entered_otp == $_SESSION['otp'] && time() <= $_SESSION['otp_expiry']) {  
        $_SESSION['is_verified'] = true;  
        unset($_SESSION['otp'], $_SESSION['otp_expiry']);  

        echo "<script>alert('Login successful!');window.location='home.php';</script>";  
    } else {  
        echo "<script>alert('Invalid or expired OTP. Try again.');window.location='otp_verify.php';</script>";  
    }  
}  
?>  

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>OTP Verification</title>
    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <link href="//fonts.googleapis.com/css?family=Poppins:300,400,400i,500,600,700&display=swap" rel="stylesheet">
</head>

<body>

    <?php include 'common/header.php'; ?>

    <!-- OTP Verification Section -->
    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex align-items-center justify-content-center h-100">
                <div class="col-md-8 col-lg-7 col-xl-6">
                    <img src="verify.png" class="img-fluid" style="height: 300px;">
                </div>
                <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                    <h2 class="mb-4 text-center">OTP Verification</h2>
                    <form method="post">
                        <!-- OTP Input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="otp">Enter OTP</label>
                            <input type="number" id="otp" name="otp" class="form-control form-control-lg" required placeholder="Enter OTP">
                        </div>

                        <!-- Submit button -->
                        <button type="submit" class="btn btn-style btn-lg btn-block" name="verify_otp">Verify</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php include 'common/footer.php'; ?>

</body>

</html>

<script src="assets/js/jquery-3.3.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

