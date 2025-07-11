<?php
session_start();
include 'common/connect.php';

// Check if required session variables exist
if (!isset($_SESSION['email']) || !isset($_SESSION['otp']) || !isset($_SESSION['user_data'])) {
    echo "<script>alert('Session expired. Please register again.');window.location='register.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $entered_otp = $_POST['otp'];

    // Ensure OTP session data exists
    if (!isset($_SESSION['otp']) || !isset($_SESSION['otp_expiry'])) {
        echo "<script>alert('OTP session data missing. Please register again.');window.location='register.php';</script>";
        exit;
    }

    if ($entered_otp == $_SESSION['otp'] && time() <= $_SESSION['otp_expiry']) {
        // Retrieve user data from session
        $user_data = $_SESSION['user_data'];
        $name = $user_data['name'];
        $email = $_SESSION['email']; // Ensure it's retrieved properly
        $password = $user_data['password'];  // ⚠️ Plain text password (as per request)
        $contact = $user_data['contact'];
        $gender = $user_data['gender'];
        $reg_date = date('Y-m-d');
        $is_volunteer = $user_data['is_volunteer'];

        // Ensure email is not null
        if (empty($email)) {
            echo "<script>alert('Error: Email is missing. Please register again.');window.location='register.php';</script>";
            exit;
        }

        // Check if email already exists
        $check_stmt = $obj->prepare("SELECT user_id FROM user WHERE email = ?");
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows == 0) {
            // Insert user data into the database
            $stmt = $obj->prepare("INSERT INTO user (name, email, contact, gender, reg_date, password, role_id, is_verified, is_volunteer) VALUES (?, ?, ?, ?, ?, ?, 2, 1, ?)");
            $stmt->bind_param("ssssssi", $name, $email, $contact, $gender, $reg_date, $password, $is_volunteer);

            if ($stmt->execute()) {
                // Clear session after successful registration
                unset($_SESSION['otp'], $_SESSION['otp_expiry'], $_SESSION['user_data'], $_SESSION['email']);

                echo "<script>alert('Registration successful! You can now log in.');window.location='login.php';</script>";
            } else {
                echo "<script>alert('Database insertion failed. Try again.');window.location='otp_verification.php';</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('Email already registered. Please log in.');window.location='login.php';</script>";
        }
        $check_stmt->close();
    } else {
        echo "<script>alert('Invalid or expired OTP. Try again.');window.location='otp_verification.php';</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>OTP Verification</title>
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <link href="//fonts.googleapis.com/css?family=Poppins:300,400,400i,500,600,700&display=swap" rel="stylesheet">
</head>

<body>

    <?php include 'common/header.php'; ?>

    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex align-items-center justify-content-center h-100">
                <div class="col-md-8 col-lg-7 col-xl-6">
                    <img src="verify.png" class="img-fluid" style="height: 300px;">
                </div>
                <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                    <h2 class="mb-4 text-center">OTP Verification</h2>
                    <form method="post">
                        <div class="form-outline mb-4">
                            <label class="form-label" for="otp">Enter OTP</label>
                            <input type="number" id="otp" name="otp" class="form-control form-control-lg" required placeholder="Enter OTP">
                        </div>

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
