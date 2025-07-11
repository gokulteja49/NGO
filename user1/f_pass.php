<?php 
session_start();
include 'common/connect.php'; 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php'; // Load PHPMailer

$message = ''; // Message for user feedback

// Fetch roles excluding role_id 1
$role_query = $obj->query("SELECT * FROM role WHERE role_id != 1");

// Step 1: Send OTP if email is submitted
if(isset($_POST['send_otp'])) {
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Generate random OTP
    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['otp_email'] = $email;
    $_SESSION['otp_role'] = $role;

    // Send OTP via email using PHPMailer
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = 'gokulteja152@gmail.com'; // Your email
        $mail->Password = 'vzekdoemdqdjyrup';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('gokulteja152@gmail.com', 'ngowebsite');
        $mail->addAddress($email);
        $mail->Subject = 'Your OTP for Password Reset';
        $mail->Body = "Your OTP for password reset is: $otp";

        $mail->send();
        $message = "OTP has been sent to your email. Please enter it to continue.";
    } catch (Exception $e) {
        $message = "Error sending OTP. Please try again.";
    }
}

// Step 2: Verify OTP and Update Password
if(isset($_POST['verify_otp'])) {
    $user_otp = $_POST['otp'];
    $email = $_SESSION['otp_email'];
    $role = $_SESSION['otp_role'];

    if($user_otp == $_SESSION['otp']) {
        $_SESSION['otp_verified'] = true;
        $message = "OTP verified successfully. You can now update your password.";
    } else {
        $message = "Invalid OTP. Please try again.";
    }
}

// Step 3: Update Password After OTP Verification
if(isset($_POST['update_password']) && isset($_SESSION['otp_verified']) && $_SESSION['otp_verified']) {
  $password = $_POST['pass'];
  $cpass = $_POST['cpass'];
  $email = $_SESSION['otp_email'] ?? null;
  $role = $_SESSION['otp_role'] ?? null; // Ensure role is retrieved correctly

  if (!$email || !$role) {
      $message = 'Session expired. Please try again.';
  } else if ($password == $cpass) {
      // Update password in the database without hashing
      $stmt = $obj->prepare("UPDATE user SET password=? WHERE email=? AND role_id=?");
      $stmt->bind_param("ssi", $password, $email, $role);
      $exe = $stmt->execute();

      if ($exe) {
          $message = 'Password updated successfully. <a href="login.php">Login here</a>';
          session_destroy(); // Clear session after update
      } else {
          $message = 'Error updating password. Please try again.';
      }
  } else {
      $message = 'Passwords do not match.';
  }
}

?>

<!DOCTYPE html>
<html lang="zxx">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>RTF - Password Reset</title>
  <link rel="stylesheet" href="assets/css/style-starter.css">
  <link href="//fonts.googleapis.com/css?family=Poppins:300,400,400i,500,600,700&display=swap" rel="stylesheet">
</head>

<body>
  <?php include 'common/header.php'; ?>
  <div class="inner-banner"></div>

  <section class="vh-100">
    <div class="container py-5 h-100">
      <div class="row d-flex align-items-center justify-content-center h-100">
        <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
          
          <?php if (!isset($_SESSION['otp_verified'])): ?>
            <!-- OTP Request Form -->
            <form method="post">
              <h3 class="mb-4 text-center">Verify Your Email</h3>
              <div class="form-outline mb-3">
                <label class="form-label" for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control form-control-lg" required />
              </div>
              <div class="form-outline mb-3">
                <label class="form-label" for="role">Role</label>
                <select class="form-control" id="role" name="role" required>
                  <option value="">--Select Role--</option>
                  <?php while($r = $role_query->fetch_object()) { ?>
                    <option value="<?php echo $r->role_id; ?>"><?php echo $r->role_name; ?></option>
                  <?php } ?>
                </select>
              </div>
              <button type="submit" class="btn btn-primary btn-lg btn-block" name="send_otp">Send OTP</button>
            </form>

            <?php if (isset($_SESSION['otp'])): ?>
              <form method="post" class="mt-4">
                <h3 class="mb-4 text-center">Enter OTP</h3>
                <div class="form-outline mb-3">
                  <label class="form-label" for="otp">OTP</label>
                  <input type="number" id="otp" name="otp" class="form-control form-control-lg" required />
                </div>
                <button type="submit" class="btn btn-success btn-lg btn-block" name="verify_otp">Verify OTP</button>
              </form>
            <?php endif; ?>

          <?php else: ?>
            <!-- Password Update Form (Only after OTP verification) -->
            <form method="post">
              <h3 class="mb-4 text-center">Update Your Password</h3>
              <div class="form-outline mb-3">
                <label class="form-label" for="pass">New Password</label>
                <input type="password" id="pass" name="pass" class="form-control form-control-lg" required />
              </div>
              <div class="form-outline mb-3">
                <label class="form-label" for="cpass">Confirm Password</label>
                <input type="password" id="cpass" name="cpass" class="form-control form-control-lg" required />
              </div>
              <button type="submit" class="btn btn-primary btn-lg btn-block" name="update_password">Update Password</button>
            </form>
          <?php endif; ?>

          <?php if ($message != ''): ?>
            <div class="alert alert-info mt-3">
              <?php echo $message; ?>
            </div>
          <?php endif; ?>
          
        </div>
      </div>
    </div>
  </section>

  <?php include 'common/footer.php'; ?>

  <script src="assets/js/jquery-3.3.1.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
