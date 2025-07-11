<?php 

session_start();
include 'common/connect.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('location:index.php');
    exit();
}

$id = $_SESSION['admin_id'];
$result = $obj->query("SELECT * FROM user WHERE user_id='$id'");
$row = $result->fetch_object();

// Get user details based on provided ID
if (!isset($_GET['moreid']) || empty($_GET['moreid'])) {
    die("Invalid user ID.");
}

$id = (int)$_GET['moreid'];
$result1 = $obj->query("SELECT * FROM user WHERE user_id='$id'");
$row1 = $result1->fetch_object();

// Check if user exists
if (!$row1) {
    die("User not found.");
}

// For role
$role_id = $row1->role_id;
$role = $obj->query("SELECT * FROM role WHERE role_id=$role_id");
$row_role = $role->fetch_object();

?>
<!DOCTYPE HTML>
<html>
<head>
<title>Volunteer dtails</title>
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
<!-- //font-awesome icons CSS -->

 <!-- side nav css file -->
 <link href='css/SidebarNav.min.css' media='all' rel='stylesheet' type='text/css'/>
 <!-- side nav css file -->
 
 <!-- js-->
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/modernizr.custom.js"></script>

<!--webfonts-->
<link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
<!--//webfonts--> 

<!-- Metis Menu -->
<script src="js/metisMenu.min.js"></script>
<script src="js/custom.js"></script>
<link href="css/custom.css" rel="stylesheet">
<!--//Metis Menu -->

</head> 
<body class="cbp-spmenu-push">
    <div class="main-content">
        <div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
            <!-- Left Sidebar -->
            <?php include 'common/sidebar.php' ?>
        </div>

        <!-- Header -->
        <?php include 'common/header.php' ?>

        <!-- Main Content -->
        <div id="page-wrapper">
            <div class="main-page">
                <div class="tables">
                    <h2 class="title1">Volunteer Details</h2>
                    <div class="panel-body widget-shadow">
                        <h4>Volunteer Information</h4>
                        <table class="table" align="center">
                            <thead>
                                <tr>
                                    <td>User ID</td>
                                    <td><?php echo $row1->user_id; ?></td>
                                </tr>
                                <tr>
                                    <td>Name</td>
                                    <td><?php echo $row1->name; ?></td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td><?php echo $row1->email; ?></td>
                                </tr>
                                <tr>
                                    <td>Contact</td>
                                    <td><?php echo $row1->contact; ?></td>
                                </tr>
                                <tr>
                                    <td>Gender</td>
                                    <td><?php echo $row1->gender; ?></td>
                                </tr>
                                <tr>
                             
                                <tr>
                                    <td>Registration Date</td>
                                    <td><?php echo $row1->reg_date; ?></td>
                                </tr>
                                <tr>
                                    <td>Role</td>
                                    <td><?php echo $row_role->role_name; ?></td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
		<!--footer-->
		<?php include 'common/footr.php' ?>
        <!--//footer-->
	</div>
	
	<!-- side nav js -->
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