<?php
// Database Connection
session_start();
include 'common/connect.php';

if (!isset($_SESSION['user_id'])) {
    header('location:home.php');
    exit;
}

if (isset($_POST['submit'])) {
    $rating  = $_POST['rating'];
    $comment = $_POST['comment'];
    $date    = date('Y-m-d');
    $user_id = $_SESSION['user_id'];

    // Insert feedback into the database
    $exe = $obj->query("INSERT INTO feedback(date, rating, comment, user_id) VALUES('$date', '$rating', '$comment', '$user_id')");

    // Set session message based on success or failure
    if ($exe) {
        $_SESSION['feedback_status'] = 'success';
        $_SESSION['feedback_message'] = 'Feedback sent successfully!';
    } else {
        $_SESSION['feedback_status'] = 'error';
        $_SESSION['feedback_message'] = 'There was an error sending your feedback.';
    }

    // Redirect to the same page to avoid resubmission on page refresh
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!doctype html>
<html lang="zxx">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>RTF (NGO)</title>
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <link href="//fonts.googleapis.com/css?family=Poppins:300,400,400i,500,600,700&display=swap" rel="stylesheet">
  </head>

<body>
  <?php include 'common/header.php'; ?>

  <div class="inner-banner"></div>
  
  <!-- Feedback Section -->
  <section class="w3l-contact-11">
    <div class="form-41-mian py-5">
      <div class="container py-lg-4">
        <div class="row align-form-map">
          <div class="col-lg-4 contact-left pr-lg-4">
            <div class="partners">
              <div class="cont-details"><br><br><br>
                <div class="col-md-6 col-lg-7 col-xl-6">
                  <img src="feed_back.png" class="img-fluid" style="height: 200px; width: 200px;">
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-8 form-inner-cont">
            <div class="title-content text-left">
              <h3 class="hny-title mb-lg-5 mb-4">Send Feedback</h3>
            </div>

            <!-- Feedback Form -->
            <form method="post" class="feedback-form">
              <!-- Display Session Message -->
         <!-- Display Session Message -->
<?php
if (isset($_SESSION['feedback_status'])) {
    $status = $_SESSION['feedback_status'] == 'success' ? 'success-message' : 'error-message';
    echo '<p class="' . $status . '">' . (isset($_SESSION['feedback_message']) ? $_SESSION['feedback_message'] : '') . '</p>';
    unset($_SESSION['feedback_status']);
    unset($_SESSION['feedback_message']);
}
?>


              <div class="form-input">
                <select class="form-control" id="rating" name="rating" required>
                  <option value="">Please Select Rating...</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                </select>
                <br>
                <textarea placeholder="Comment" id="comment" name="comment" required></textarea>
              </div>

              <div class="submit-button text-lg-center">
                <button type="submit" class="btn btn-style" name="submit" id="submit">Submit</button>
              </div>
            </form>
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
<script src="assets/js/bootstrap.min.js"></script>
