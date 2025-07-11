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

// Fetch campaign payment records
$result1 = $obj->query("
    SELECT cp.payment_id, cp.user_id, u.name AS user_name, u.email, u.contact, 
           cp.campaign_id, c.title AS campaign_title, cp.amount, cp.payment_date 
    FROM campaign_payments cp
    JOIN user u ON cp.user_id = u.user_id
    JOIN campaigns c ON cp.campaign_id = c.campaign_id
    ORDER BY cp.payment_date DESC
");
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Manage Campaign Payments</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />

    <!-- Custom CSS -->
    <link href="css/style.css" rel='stylesheet' type='text/css' />

    <!-- Font Awesome Icons -->
    <link href="css/font-awesome.css" rel="stylesheet"> 

    <!-- Side Nav CSS -->
    <link href="css/SidebarNav.min.css" media="all" rel="stylesheet" type="text/css"/>

    <!-- JS -->
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/modernizr.custom.js"></script>

    <!-- Web Fonts -->
    <link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">

    <!-- Metis Menu -->
    <script src="js/metisMenu.min.js"></script>
    <script src="js/custom.js"></script>
    <link href="css/custom.css" rel="stylesheet">
</head>

<body class="cbp-spmenu-push">
    <div class="main-content">
        <div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
            <!-- Left Navigation -->
            <?php include 'common/sidebar.php' ?>
        </div>

        <!-- Header -->
        <?php include 'common/header.php'?>

        <!-- Main Content -->
        <div id="page-wrapper">
            <div class="main-page">
                <div class="tables">
                    <h2 class="title1">Campaign Payment History</h2>
                    <div class="panel-body widget-shadow">
                        <h4>Payment Records</h4>
                        <div class="table-responsive">
                        <table class="table table-bordered">
    <thead>
        <tr>
            <th>Payment ID</th>
            <th>User Name</th>
            <th>Email</th>
            <th>Contact</th>
            <th>Campaign Title</th>
            <th>Amount (INR)</th>
            <th>Payment Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row1 = $result1->fetch_object()) { ?>
        <tr>
            <td><?php echo $row1->payment_id; ?></td>
            <td><?php echo $row1->user_name; ?></td>
            <td><?php echo $row1->email; ?></td>
            <td><?php echo $row1->contact; ?></td>
            <td><?php echo $row1->campaign_title; ?></td>
            <td>rs<?php echo number_format($row1->amount, 2); ?></td>
            <td><?php echo date("d M Y, h:i A", strtotime($row1->payment_date)); ?></td>
            <td>
                <a href="pr2.php?payment_id=<?php echo $row1->payment_id; ?>" target="_blank" class="btn btn-primary">
                    Print Receipt
                </a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

</div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <?php include 'common/footr.php' ?>
    </div>

    <!-- Side Nav JS -->
    <script src="js/SidebarNav.min.js" type="text/javascript"></script>
    <script>
        $('.sidebar-menu').SidebarNav();
    </script>

    <!-- Toggle Menu Script -->
    <script src="js/classie.js"></script>
    <script>
        var menuLeft = document.getElementById('cbp-spmenu-s1'),
            showLeftPush = document.getElementById('showLeftPush'),
            body = document.body;

        showLeftPush.onclick = function() {
            classie.toggle(this, 'active');
            classie.toggle(body, 'cbp-spmenu-push-toright');
            classie.toggle(menuLeft, 'cbp-spmenu-open');
            disableOther('showLeftPush');
        };

        function disableOther(button) {
            if (button !== 'showLeftPush') {
                classie.toggle(showLeftPush, 'disabled');
            }
        }
    </script>

    <!-- Scrolling JS -->
    <script src="js/jquery.nicescroll.js"></script>
    <script src="js/scripts.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.js"></script>
</body>
</html>
s