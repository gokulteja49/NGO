<?php
session_start();
include 'common/connect.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header('location:home.php');
    exit;
}

$message = ""; // Variable to store success/error messages

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $amt = trim($_POST['amt']);
    $desc = trim($_POST['desc']);
    $date = date('Y-m-d');
    $user_id = $_SESSION['user_id'];

    $exe = $obj->query("INSERT INTO money_donation(user_id, amount, description, date) VALUES ('$user_id', '$amt', '$desc', '$date')");

    // API keys
    $apiKey = "rzp_test_pXtLNzDfIlN645";
    $profile_data = $obj->query("SELECT * FROM user WHERE user_id='$user_id'");
    $profile = $profile_data->fetch_object();

    if ($exe) {
        $message = "<p style='color: green;'>Money donation successful!</p>";
    } else {
        $message = "<p style='color: red;'>An error occurred. Please try again.</p>";
    }
}
?>
<!doctype html>
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>RTF</title>
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <link href="//fonts.googleapis.com/css?family=Poppins:300,400,400i,500,600,700&display=swap" rel="stylesheet">
</head>

<body>

    <?php include 'common/header.php'; ?>

    <div class="inner-banner"></div>

    <section class="w3l-contact-11">
        <div class="form-41-mian py-5">
            <div class="container py-lg-4">
                <div class="row align-form-map">
                    <div class="col-lg-12 form-inner-cont">
                        <div class="title-content text-left">
                            <h3 class="hny-title mb-lg-5 mb-4">Donate Money</h3>
                        </div>
                        <form method="post" class="donation-form">
                            <div class="container">
                                <div class="col-lg-10 form-input">
                                    <input type="number" name="amt" id="amt" placeholder="Amount" required />
                                </div>
                                <br>
                                <div class="col-lg-10 form-input">
                                    <textarea name="desc" id="desc" placeholder="Description" required></textarea>
                                </div>
                                <br>
                                <div class="submit-button text-lg-center">
                                    <button type="submit" class="btn btn-style" name="submit">Donate Now</button>
                                </div>
                            </div>
                        </form>

                        <!-- Display success/error message below the form -->
                        <div class="text-center mt-3">
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
