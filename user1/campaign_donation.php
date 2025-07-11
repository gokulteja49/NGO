<?php 
// Start the session and include necessary files
session_start();
include('./common/connect.php'); // Include your database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if the user is not logged in
    header('Location: login.php');
    exit();
}

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Fetch all transactions made by the logged-in user
$query = "
    SELECT 
        p.payment_id AS payment_id, 
        c.title, 
        p.amount, 
        p.payment_date
    FROM 
        campaign_payments p
    INNER JOIN 
        campaigns c ON p.campaign_id = c.campaign_id
    WHERE 
        p.user_id = ?
    ORDER BY 
        p.payment_date DESC
";

// Prepare and execute the query to prevent SQL injection
$stmt = $obj->prepare($query);
$stmt->bind_param("i", $user_id); // "i" denotes an integer type
$stmt->execute();
$result = $stmt->get_result(); // Fetch the results
?><!doctype html>
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

<body>

  <!--w3l-header-->

  <?php include 'common/header.php'; ?>
<!--/header-->
<div class="inner-banner">


</div>

<section class="w3l-contact-11">
    <div class="form-41-mian py-5">
      <div class="container py-lg-4">
        <div class="row align-form-map">
        
          <div class="title-content text-left">
            <h3 class="hny-title mb-lg-5 mb-4">Your Transaction History</h3>
          </div>

          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">Payment ID</th>
                <th scope="col">Campaign Title</th>
                <th scope="col">Amount</th>
                <th scope="col">Date</th>
              </tr>
            </thead>
            <tbody>
                <?php
                  if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                ?>
                  <tr>
                    <td><?php echo htmlspecialchars($row['payment_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo '$' . number_format($row['amount'], 2); ?></td>
                    <td><?php echo date("F j, Y, g:i a", strtotime($row['payment_date'])); ?></td>
                  </tr>
                <?php
                    }
                  } else {
                ?>
                  <tr>
                    <td colspan="4" class="text-center">No donations found</td>
                  </tr>
                <?php
                  }
                ?>
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </section>
</body>
</html>

<script src="assets/js/jquery-3.3.1.min.js"></script>
<!-- disable body scroll which navbar is in active -->

<!-- disable body scroll which navbar is in active -->
<script>
  $(function () {
    $('.navbar-toggler').click(function () {
      $('body').toggleClass('noscroll');
    })
  });
</script>
<!-- disable body scroll which navbar is in active -->

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