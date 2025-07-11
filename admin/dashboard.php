<?php

session_start();



include 'common/connect.php';

if(!isset($_SESSION['admin_id']))
{
    header('location:index.php');
}

$id = $_SESSION['admin_id'];
$result = $obj->query("select * from user where user_id='$id'");
$row = $result->fetch_object();

//for user
$result = $obj->query("SELECT * from user where role_id=2");
$row = mysqli_num_rows($result);
//for volunteer
$result1 = $obj->query("SELECT * from user WHERE is_volunteer='1'");
$row1 = mysqli_num_rows($result1);

$result3 = $obj->query("SELECT SUM(amount)  FROM campaign_payments");
while ($row3= mysqli_fetch_array($result3)) {
    # code...
    $sum1 = $row3['SUM(amount)'];
}





$sql = $obj->query("SELECT SUM(amount) FROM money_donation");
while ($row4 = mysqli_fetch_array($sql)) {
    # code...
    $sum = $row4['SUM(amount)'];
}



?>
<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>
<html>
<head>
<title>Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Glance Design Dashboard Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
SmartPhone Compatible web template, free WebDesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<!-- Bootstrap Core CSS -->
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />

<!-- Custom CSS -->
<link href="css/style.css" rel='stylesheet' type='text/css' />

<!-- font-awesome icons CSS -->
<link href="css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons CSS-->

<!-- side nav css file -->
<link href='css/SidebarNav.min.css' media='all' rel='stylesheet' type='text/css'/>
<!-- //side nav css file -->
 
 <!-- js-->
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/modernizr.custom.js"></script>

<!--webfonts-->
<link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
<!--//webfonts--> 

<!-- chart -->
<script src="js/Chart.js"></script>
<!-- //chart -->

<!-- Metis Menu -->
<script src="js/metisMenu.min.js"></script>
<script src="js/custom.js"></script>
<link href="css/custom.css" rel="stylesheet">
<!--//Metis Menu -->
<style>
	@media screen and (max-width: 768px) {
    .r3_counter_box {
        text-align: center;
        padding: 15px;
        margin-bottom: 15px;
    }

    .r3_counter_box i {
        display: block;
        margin: 0 auto 10px;
        float: none;
    }

    .stats h5 {
        font-size: 18px;
    }
}

#chartdiv {
  width: 100%;
  height: 295px;
}
</style>
<!--pie-chart --><!-- index page sales reviews visitors pie chart -->
<script src="js/pie-chart.js" type="text/javascript"></script>
 <script type="text/javascript">

        $(document).ready(function () {
            $('#demo-pie-1').pieChart({
                barColor: '#2dde98',
                trackColor: '#eee',
                lineCap: 'round',
                lineWidth: 8,
                onStep: function (from, to, percent) {
                    $(this.element).find('.pie-value').text(Math.round(percent) + '%');
                }
            });

            $('#demo-pie-2').pieChart({
                barColor: '#8e43e7',
                trackColor: '#eee',
                lineCap: 'butt',
                lineWidth: 8,
                onStep: function (from, to, percent) {
                    $(this.element).find('.pie-value').text(Math.round(percent) + '%');
                }
            });

            $('#demo-pie-3').pieChart({
                barColor: '#ffc168',
                trackColor: '#eee',
                lineCap: 'square',
                lineWidth: 8,
                onStep: function (from, to, percent) {
                    $(this.element).find('.pie-value').text(Math.round(percent) + '%');
                }
            });

           
        });

    </script>
<!-- //pie-chart --><!-- index page sales reviews visitors pie chart -->

	<!-- requried-jsfiles-for owl -->
					<link href="css/owl.carousel.css" rel="stylesheet">
					<script src="js/owl.carousel.js"></script>
						<script>
							$(document).ready(function() {
								$("#owl-demo").owlCarousel({
									items : 3,
									lazyLoad : true,
									autoPlay : true,
									pagination : true,
									nav:true,
								});
							});
						</script>
					<!-- //requried-jsfiles-for owl -->
</head> 
<body class="cbp-spmenu-push">
	<div class="main-content">
	<div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
		<!--left-fixed -navigation-->
		<?php include 'common/sidebar.php'; ?>
	</div>
		<!--left-fixed -navigation-->
		
		<!-- header-starts -->
		<?php include 'common/header.php'; ?>
		
		<div id="page-wrapper">
			<div class="main-page">
			<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-3">
        <div class="r3_counter_box">
            <i class="pull-left fa fa-money icon-rounded"></i>
            <div class="stats">
                <h5><strong><?php echo $sum; ?></strong></h5>
                <span>Money Donation</span>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-3">
        <div class="r3_counter_box">
            <i class="pull-left fa fa-users user2 icon-rounded"></i>
            <div class="stats">
                <h5><strong><?php echo $row1; ?></strong></h5>
                <span>Total Volunteer</span>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-3">
        <div class="r3_counter_box">
            <i class="pull-left fa fa-pie-chart dollar1 icon-rounded"></i>
            <div class="stats">
                <h5><strong><?php echo $sum1; ?></strong></h5>
                <span>Total Campaign Donation</span>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-3">
        <div class="r3_counter_box">
            <i class="pull-left fa fa-users dollar2 icon-rounded"></i>
            <div class="stats">
                <h5><strong><?php echo $row; ?></strong></h5>
                <span>Total Users</span>
            </div>
        </div>
    </div>
</div>

        	<div class="clearfix"> </div>
		</div>
		
				
	
	<!-- for amcharts js -->
			<script src="js/amcharts.js"></script>
			<script src="js/serial.js"></script>
			<script src="js/export.min.js"></script>
			<link rel="stylesheet" href="css/export.css" type="text/css" media="all" />
			<script src="js/light.js"></script>
	<!-- for amcharts js -->

    <script  src="js/index1.js"></script>
	
		
		
		
				
			</div>
		</div>
	<!--footer-->
	<?php include 'common/footr.php'; ?>
    <!--//footer-->
	</div>
	<script src='js/SidebarNav.min.js' type='text/javascript'></script>
	<script>
      $('.sidebar-menu').SidebarNav()
    </script>
	<!-- //side nav js -->
	
	<!-- Classie --><!-- for toggle left push menu script -->
		<script src="js/classie.js"></script>
		<script>
			var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
				showLeftPush = document.getElementById( 'showLeftPush' ),
				body = document.body;
				
			showLeftPush.onclick = function() {
				classie.toggle( this, 'active' );
				classie.toggle( body, 'cbp-spmenu-push-toright' );
				classie.toggle( menuLeft, 'cbp-spmenu-open' );
				disableOther( 'showLeftPush' );
			};
			
			function disableOther( button ) {
				if( button !== 'showLeftPush' ) {
					classie.toggle( showLeftPush, 'disabled' );
				}
			}
		</script>
	<!-- //Classie --><!-- //for toggle left push menu script -->
	
	<!--scrolling js-->
	<script src="js/jquery.nicescroll.js"></script>
	<script src="js/scripts.js"></script>
	<!--//scrolling js-->
	
	<!-- Bootstrap Core JavaScript -->
   <script src="js/bootstrap.js"> </script>
	
</body>
</html>