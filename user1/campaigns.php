<?php 
session_start();
include 'common/connect.php';

// Check if user is logged in
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null; 

// Fetch all campaigns
$result = $obj->query("SELECT * FROM campaigns ORDER BY created_at DESC");
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Campaigns</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <link href="//fonts.googleapis.com/css?family=Poppins:300,400,400i,500,600,700&display=swap" rel="stylesheet">
    <style>
        .campaign-container {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        .campaign-section {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .campaign-item {
            display: flex;
            flex-direction: row;
            align-items: center;
            background: #f9f9f9;
            padding: 15px;
            border-radius: 10px;
        }

        .campaign-image {
            width: 200px;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
            margin-right: 20px;
        }

        .campaign-details {
            flex: 1;
        }

        .progress-container {
            width: 100%;
            height: 10px;
            background: #ddd;
            border-radius: 5px;
            overflow: hidden;
            margin-top: 10px;
        }

        .progress-bar {
            height: 100%;
            background: #28a745;
            width: 0;
            transition: width 0.4s ease-in-out;
        }

        .donate-btn {
            background: #ff5722;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            margin-top: 10px;
            cursor: pointer;
        }

        .donate-btn:hover {
            background: #e64a19;
        }

        /* Description Section */
        .campaign-description {
            background: #f3f3f3;
            padding: 15px;
            border-radius: 10px;
            margin-top: 10px;
            border-left: 5px solid #007bff;
            font-size: 16px;
            color: #444;
        }

        @media (max-width: 768px) {
            .campaign-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .campaign-image {
                width: 100%;
                height: auto;
                margin-bottom: 10px;
            }
        }
    </style>
</head>

<body>
    <?php include 'common/header.php'; ?>

    <div class="inner-banner"></div>
    <section class="w3l-content-6">
		<!-- /content-6-main-->
		<div class="content-6-mian py-5">
			<div class="container py-lg-5">
				<div class="content-info-in row">
					<div class="col-lg-6">
						<img src="assets/images/ab1.jpg" alt="" class="img-fluid">
					</div>
					<div class="col-lg-6 mt-lg-0 mt-5 about-right-faq align-self  pl-lg-4">
						<div class="title-content text-left mb-2">
							<h6 class="sub-title">Campaigns</h6>
							<h3 class="hny-title"> We Have Years Of Experiences Give You Better Results.</h3>
						</div>
						<p class="mt-3">Millions of children in underprivileged communities lack access to quality education. This campaign aims to provide school supplies, books, and scholarships for children in need. Your donation can help shape a child's future by ensuring they receive the education they deserve</p>
						<a href="about.php" class="btn btn-style btn-primary mt-4">Read More</a>
					</div>
					<div class="col-lg-6 mt-5 about-right-faq align-self order2">
						<div class="title-content text-left mb-2">
							<h6 class="sub-title">Who We Are</h6>
							<h3 class="hny-title">We Provide  Charity
								Service</h3>
						</div>
						<p class="mt-3">Our main focus is here  money-donation, and medical-treatment like cancer and many more, we can collect that particular donation and provided to NGO .we also support some families in them financial condition.</p>
						<a href="about.php" class="btn btn-style btn-primary mt-4">Read More</a>
					</div>
					<div class="col-lg-6 mt-5 pl-lg-4">
						<img src="assets/images/ab2.jpg" alt="" class="img-fluid">
					</div>


				</div>
			</div>
	</section>

    <section class="w3l-donations py-5">
        <div class="container py-lg-4">
            <div class="title-content text-left">
                <h3 class="hny-title mb-lg-5 mb-4">Active Campaigns</h3>
            </div>

            <div class="campaign-container">
                <?php while ($row = $result->fetch_object()) { ?>
                    <section class="campaign-section">
                        <div class="campaign-item">
                            <img src="../admin/uploads/<?php echo htmlspecialchars($row->image); ?>" alt="Campaign Image" class="campaign-image">
                            
                            <div class="campaign-details">
                                <h3><?php echo htmlspecialchars($row->title); ?></h3>
                                <p>Goal: Rs<?php echo number_format($row->goal, 2); ?></p>
                                <p>Raised: Rs<span id="raised_<?php echo $row->campaign_id; ?>"><?php echo number_format($row->raised, 2); ?></span></p>

                                <div class="progress-container">
                                    <div class="progress-bar" style="width: <?php echo ($row->raised / $row->goal) * 100; ?>%"></div>
                                </div>

                                <?php if ($user_id): ?>
                                    <form action="donate_2.php" method="POST">
                                        <input type="hidden" name="campaign_id" value="<?php echo $row->campaign_id; ?>">
                                        <button type="submit" class="donate-btn">Donate</button>
                                    </form>
                                <?php else: ?>
                                    <a href="login.php" class="donate-btn">Login to Donate</a>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Description Section (Always Visible) -->
                        <div class="campaign-description">
                            <p><?php echo nl2br(htmlspecialchars($row->description)); ?></p>
                        </div>
                    </section>
                <?php } ?>
            </div>
        </div>
    </section>

    <?php include 'common/footer.php'; ?>
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

</body>
</html>
