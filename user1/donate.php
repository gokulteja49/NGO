<?php
session_start();
include 'common/connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('location:home.php');
    exit;
}

$message = ''; // Variable to store message

// Check if form is submitted
if (isset($_POST['submit'])) {
    $d_name = $_POST['d_name'];
    $amt = $_POST['amt'];
    $desc = $_POST['desc'];
    $date = date('Y-m-d');
    $user_id = $_SESSION['user_id'];

    // Redirect to payment page with donation details (no database insertion here)
    header("Location: payment.php?d_name=$d_name&amt=$amt&desc=$desc&date=$date&user_id=$user_id");
    exit;
}
?>

<!doctype html>
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>RTF(NGO)</title>
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <link href="//fonts.googleapis.com/css?family=Poppins:300,400,400i,500,600,700&display=swap" rel="stylesheet">
</head>

<body>

    <?php include 'common/header.php'; ?>

    <div class="inner-banner"></div>

    <!-- Donation Form Section -->
    <section class="w3l-contact-11">
        <div class="form-41-mian py-5">
            <div class="container py-lg-4">
                <div class="row align-form-map">
                    <div class="col-lg-12 form-inner-cont">
                        <div class="title-content text-left">
                            <h3 class="hny-title mb-lg-5 mb-4">Please Donate</h3>
                        </div>
                        <form method="post" class="signin-form">
                            <div class="container">
                                <div class="col-lg-10 form-input">
                                    <input type="text" name="d_name" id="d_name" placeholder="Donor Name" required="" />
                                </div><br>
                                <div class="col-lg-10 form-input">
                                    <input type="text" name="amt" id="amt" placeholder="Amount" required="" />
                                </div><br>
                                <div class="col-lg-10 form-input">
                                    <textarea name="desc" id="desc" placeholder="Description"></textarea>
                                </div><br>
                                <div class="submit-button text-lg-center">
                                    <button type="submit" class="btn btn-style" name="submit" id="submit">Submit</button>
                                </div>
                            </div>
                        </form>

                        <!-- Display Success/Failure Messages -->
                        <?php if ($message != ''): ?>
                            <div class="alert alert-info mt-3">
                                <?php echo $message; ?>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'common/footer.php'; ?>

    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

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

</body>

</html>
