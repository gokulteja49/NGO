<?php
include 'common/connect.php';

$message = ""; // Variable to store success/error messages

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $result = $obj->query("SELECT * FROM user WHERE verification_token='$token' AND is_verified=0");

    if ($result->num_rows > 0) {
        $obj->query("UPDATE user SET is_verified=1, verification_token=NULL WHERE verification_token='$token'");
        $message = "<p style='color: green;'>Email verified successfully! You can now <a href='login.php'>log in</a>.</p>";
    } else {
        $message = "<p style='color: red;'>Invalid or expired token. Please <a href='register.php'>register again</a>.</p>";
    }
} else {
    $message = "<p style='color: red;'>Invalid request. Please <a href='register.php'>register again</a>.</p>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification - Rajini Tech Foundation</title>
    <link rel="stylesheet" href="assets/css/style-starter.css">
</head>

<body>

    <?php include 'common/header.php'; ?>

    <div class="inner-banner"></div>

    <section class="w3l-contact-11">
        <div class="form-41-mian py-5">
            <div class="container py-lg-4">
                <div class="row align-form-map">
                    <div class="col-lg-12 form-inner-cont text-center">
                        <h3 class="hny-title mb-lg-5 mb-4">Email Verification</h3>
                        <div class="verification-message">
                            <?php echo $message; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'common/footer.php'; ?>

</body>

</html>

<script src="assets/js/jquery-3.3.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
