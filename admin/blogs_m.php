<?php
session_start();
include 'common/connect.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('location:index.php');
    exit();
}

// Add new blog post with image upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title']) && isset($_POST['description'])) {
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $image = '';

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "uploads/blogs/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $image = time() . "_" . basename($_FILES['image']['name']); // Unique filename
        $target_file = $target_dir . $image;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate file type (only allow jpg, jpeg, png)
        $allowed_types = ['jpg', 'jpeg', 'png'];
        if (!in_array($imageFileType, $allowed_types)) {
            die("Invalid file type. Only JPG, JPEG, and PNG are allowed.");
        }

        // Move file to uploads folder
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            die("Error uploading file.");
        }
    }

    // Insert into database
    $stmt = $obj->prepare("INSERT INTO blogs (title, image, description) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $image, $description);
    $stmt->execute();
    $stmt->close();
    header("Location: blogs_m.php");
    exit();
}

// Fetch all blog posts
$result = $obj->query("SELECT * FROM blogs ORDER BY created_at DESC");

// Delete blog post
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $blog_id = (int)$_POST['delete_id'];

    // Fetch blog image to delete it from the server
    $stmt = $obj->prepare("SELECT image FROM blogs WHERE id = ?");
    $stmt->bind_param("i", $blog_id);
    $stmt->execute();
    $stmt->bind_result($image);
    $stmt->fetch();
    $stmt->close();

    if ($image && file_exists("uploads/blogs/" . $image)) {
        unlink("uploads/blogs/" . $image);
    }

    // Delete blog from database
    $stmt = $obj->prepare("DELETE FROM blogs WHERE id = ?");
    $stmt->bind_param("i", $blog_id);
    $stmt->execute();
    $stmt->close();
    header("Location: blogs_m.php");
    exit();
}
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Manage Campaign</title>
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
  <?php include 'common/sidebar.php' ?>
  <?php include 'common/header.php' ?>
  </div>
 

    <div id="page-wrapper">
        <div class="main-page">
            <div class="tables">
                <h2 class="title1">Manage Blogs</h2>
        
                <!-- Blog Form -->
                <h4>Add New Blog</h4>
                <form method="POST" action="blogs_m.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Blog Title</label>
                        <input type="text" class="form-control" name="title" required>
                    </div>
                    <div class="form-group">
                        <label>Blog Description</label>
                        <textarea class="form-control" name="description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Blog Image</label>
                        <input type="file" class="form-control" name="image" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-success">Add Blog</button>
                </form>
            </div>

            <!-- Blog List -->
            <div class="panel-body widget-shadow">
                <h4>Blog List</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_object()) { ?>
                            <tr>
                                <td><?php echo $row->id; ?></td>
                                <td>
                                    <img src="uploads/blogs/<?php echo htmlspecialchars($row->image); ?>" width="100" height="70" alt="Blog Image">
                                </td>
                                <td><?php echo htmlspecialchars($row->title); ?></td>
                                <td><?php echo htmlspecialchars(substr($row->description, 0, 50)) . "..."; ?></td>
                                <td><?php echo date("d M Y", strtotime($row->created_at)); ?></td>
                                <td>
                                    <form method="POST" style="display:inline-block;">
                                        <input type="hidden" name="delete_id" value="<?php echo $row->id; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div> 
            </div>
        </div>
    </div>

    <?php include 'common/footr.php'; ?>
  </div>

 <!-- side nav js -->
 <script src='js/SidebarNav.min.js' type='text/javascript'></script>
  <script>
      $('.sidebar-menu').SidebarNav()
    </script>
  >
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
