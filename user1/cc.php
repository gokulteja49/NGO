<?php
session_start();
include 'common/connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('location:home.php');
    exit;
}

// Fetch donation causes created by admin
$donations = [];
$query = "SELECT * FROM donationcards";
$result = mysqli_query($obj, $query);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $donations[] = $row;
    }
}
?>

<!doctype html>
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>RTF(NGO) - Donations</title>
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <link href="//fonts.googleapis.com/css?family=Poppins:300,400,400i,500,600,700&display=swap" rel="stylesheet">

    <style>
        .donation-card p {
            color: white;
            font-weight: bold;
        }

        .donation-card {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
            color: #fff;
            padding: 20px;
            border-radius: 10px;
            height: 250px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .donation-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 10px;
        }

        .donation-card-content {
            position: relative;
            z-index: 2;
        }

        .donation-card h5,
        .donation-card p {
            margin: 0;
        }
    </style>

</head>

<body>
    <?php include 'common/header.php'; ?>

    <div class="inner-banner">

    </div>

    <section class="w3l-donations py-5">
        <div class="container py-lg-4">
            <div class="title-content text-left">
                <h3 class="hny-title mb-lg-5 mb-4">Choose a Cause to Donate</h3>
            </div>
            <div class="row">
                <?php foreach ($donations as $donation): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="donation-card" style="background-image: url('../admin/images/<?php echo htmlspecialchars($donation['image']); ?>');">
                            <div class="donation-card-content">
                                <h5><?php echo htmlspecialchars($donation['title']); ?></h5>
                                <p><?php echo htmlspecialchars($donation['description']); ?></p>
                                <p><strong>Amount:</strong> rs<?php echo htmlspecialchars($donation['price']); ?></p>
                                <a href="donate.php?d_name=<?php echo urlencode($donation['title']); ?>&desc=<?php echo urlencode($donation['description']); ?>&price=<?php echo urlencode($donation['price']); ?>&user_id=<?php echo $_SESSION['user_id']; ?>" class="btn btn-style">Donate Now</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

   
</body>
<?php include 'common/footer.php'; ?>

<!-- Scripts -->
<script src="assets/js/jquery-3.3.1.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script> <!-- Bootstrap Bundle includes Popper.js -->

<script>
    $(document).ready(function () {
        // Toggle the navbar on mobile
        $(".navbar-toggler").on("click", function () {
            $("header").toggleClass("active");
        });

        // Add fixed navbar on scroll
        $(window).on("scroll", function () {
            var scroll = $(window).scrollTop();
            if (scroll >= 80) {
                $("#site-header").addClass("nav-fixed");
            } else {
                $("#site-header").removeClass("nav-fixed");
            }
        });
    });
</script>

</html>
