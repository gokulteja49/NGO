<?php

session_start();

include 'common/connect.php';

$role = $obj->query("select * from role");

//session start
if(!isset($_SESSION['admin_id']))
{
    header('location:index.php');
}

$id = $_SESSION['admin_id'];
$result = $obj->query("select * from user where user_id='$id'");
$row = $result->fetch_object();
//session close

//editcode
$id1 = $_GET['editid'];
$result1 = $obj->query("select * from user where user_id='$id'");
$row1 = $result->fetch_object();

$row1 = $result->fetch_object();
$gen=$row->gender;

$message = ""; // Variable to store success/error message

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpass = $_POST['cpassword'];
    $contact = $_POST['contact'];
    $role = $_POST['role'];
    $reg_date = date('Y-m-d');

    if ($password == $cpass) {
        // Update user information without image upload
        $exe = $obj->query("UPDATE user SET name='$name', email='$email', contact='$contact', gender='$gen', reg_date='$reg_date', password='$password', role_id='$role' WHERE user_id='$id'");

        if($exe) {
            $message = "Profile updated successfully!";
        } else {
            $message = "Error updating profile.";
        }
    } else {
        $message = "Passwords do not match!";
    }
}
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Update Profile</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Glance Design Dashboard Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, SmartPhone Compatible web template, free WebDesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
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
		<!--left-fixed -navigation-->
		<?php include 'common/sidebar.php' ?>
	</div>
		<!--left-fixed -navigation-->
		
		<!-- header-starts -->
		<?php include 'common/header.php' ?>
		<!-- //header-ends -->
		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page">
				<div class="forms">
					<h2 class="title1">Update Profile</h2>
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 

						<?php if($message): ?>
							<div class="alert alert-info">
								<?php echo $message; ?>
							</div>
						<?php endif; ?>
						
						<div class="form-grids row form-grids-right">
							<div class="widget-shadow" data-example-id="basic-forms"> 
								<div class="row">
									<div class="form-three widget-shadow">
										<form class="form-horizontal" method="post">
											<div class="form-group">
												<label for="focusedinput" class="col-sm-2 control-label">Name</label>
												<div class="col-sm-8">
													<input type="text" class="form-control1" id="name" name="name" placeholder="Name" value="<?php echo $row->name; ?>">
												</div>
											</div>
											<div class="form-group">
												<label for="disabledinput" class="col-sm-2 control-label">Email</label>
												<div class="col-sm-8">
													<input  type="text" class="form-control1" name="email" id="email" placeholder="Email" value="<?php echo $row->email; ?>">
												</div>
											</div>
											<div class="form-group">
												<label for="inputPassword" class="col-sm-2 control-label">Contact</label>
												<div class="col-sm-8">
													<input type="text" class="form-control1" id="contact" placeholder="Contact" value="<?php echo $row->contact; ?>" name="contact">
												</div>
											</div>
											<div class="form-group">
												<label for="inputPassword" class="col-sm-2 control-label">Password</label>
												<div class="col-sm-8">
													<input type="password" class="form-control1" id="password" name="password" placeholder="Password">
												</div>
											</div>
											<div class="form-group">
												<label for="inputPassword" class="col-sm-2 control-label">Confirm password</label>
												<div class="col-sm-8">
													<input type="password" class="form-control1" id="cpassword" name="cpassword" placeholder="Confirm Password">
												</div>
											</div>
											<div class="form-group">
												<label for="radio" class="col-sm-2 control-label">Role</label>
												<div class="col-sm-8">
													<select class="form-control" id="role" name="role">
														<option value="">--Select Role--</option>
														<?php
															while($r = $role->fetch_object()) {
																?>
																<option value="<?php echo $r->role_id;?>"<?php if($row->role_id == $r->role_id) echo 'selected'; ?>><?php echo $r->role_name;?></option>
																<?php
															}
														?>
													</select>
												</div>
											</div>
											<div class="form-group mb-n">
												<label for="largeinput" class="col-sm-2 control-label label-input-lg"></label>
												<div class="col-sm-8">
													<button type="submit" class="btn btn-default" name="submit">Submit</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					
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
