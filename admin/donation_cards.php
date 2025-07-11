<?php
session_start();
include 'common/connect.php';

if (!isset($_SESSION['admin_id'])) {
    header('location:index.php');
    exit();
}

$id = $_SESSION['admin_id'];
$result = $obj->query("SELECT * FROM user WHERE user_id='$id'");
$row = $result->fetch_object();

// Handle Image Upload
function uploadImage($file) {
    $target_dir = "./images/";
    $target_file = $target_dir . basename($file["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if ($file["size"] > 2000000) {
        return ["error" => "File is too large (max 2MB)."];
    }
    if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
        return ["error" => "Only JPG, JPEG, PNG & GIF files are allowed."];
    }
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return ["success" => basename($file["name"])];
    } else {
        return ["error" => "Error uploading file."];
    }
}

if (isset($_POST['add'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price']; // Get the price from the form

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploadResult = uploadImage($_FILES['image']);
        if (isset($uploadResult['error'])) {
            $message = $uploadResult['error'];
        } else {
            $image = $uploadResult['success'];
            $stmt = $obj->prepare("INSERT INTO donationcards (title, description, image, price) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssd", $title, $description, $image, $price); // Bind the price parameter
            if ($stmt->execute()) {
                $message = "Donation card added successfully.";
            } else {
                $message = "Error adding donation card.";
            }
        }
    } else {
        $message = "Please upload an image.";
    }
}


// Delete Donation Card
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $obj->prepare("DELETE FROM donationcards WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: donation_cards.php");
        exit();
    } else {
        $message = "Error deleting record.";
    }
}

// Fetch all donation cards
$donations = $obj->query("SELECT * FROM donationcards");
?>
<!DOCTYPE HTML>
<html>
<head>
<title>User</title>
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
    <!--left-fixed -navigation-->
    <?php include 'common/sidebar.php' ?>
  </div>
    
    <?php include 'common/header.php'?>
    
    <div id="page-wrapper">
        <div class="main-page">
            <div class="tables">
                <h2 class="title1">Manage Donations</h2>

                <div class="panel-body widget-shadow">
                    <h4>Add Donation Card</h4>
                    <?php if (isset($message)) echo "<p class='alert alert-info'>$message</p>"; ?>
                    <form method="post" enctype="multipart/form-data">
    <input type="text" name="title" class="form-control" placeholder="Title" required><br>
    <textarea name="description" class="form-control" placeholder="Description" required></textarea><br>
    <input type="number" name="price" class="form-control" placeholder="Price" step="0.01" min="0" required><br>
    <input type="file" name="image" class="form-control" required><br>
    <button type="submit" name="add" class="btn btn-primary">Add Donation Card</button>
</form>

                </div>
                <div class="panel-body widget-shadow">
    <h4>Existing Donations</h4>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $donations->fetch_assoc()): ?>
                    <tr>
                        <td><img src="./images/<?php echo $row['image']; ?>" class="donation-img"></td>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo htmlspecialchars($row['description']); ?></td>
                        <td>Rs <?php echo number_format($row['price'], 2); ?></td>
                        <td>
                            <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<style>
    .donation-img {
        width: 80px;
        height: auto;
        border-radius: 5px;
    }
    
    @media (max-width: 768px) {
        .table-responsive {
            overflow-x: auto;
        }
    }
</style>

            </div>
        </div>
    </div>
    <?php include 'common/footr.php'; ?>
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
