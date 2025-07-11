<?php 
session_start();
include 'common/connect.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('location:index.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$result = $obj->query("SELECT * FROM user WHERE user_id='$user_id'");
$row = $result->fetch_object();

$message = "";

// Fetch total donation amount from money_donation table
$total_donations = 0;
$donation_query = $obj->query("SELECT SUM(amount) AS total FROM money_donation WHERE user_id='$user_id'");
if ($donation_query) {
    $donation_data = $donation_query->fetch_object();
    $total_donations = $donation_data->total ?? 0;
}

// Fetch total campaign payments
$total_campaign_payments = 0;
$campaign_query = $obj->query("SELECT SUM(amount) AS total FROM campaign_payments WHERE user_id='$user_id'");
if ($campaign_query) {
    $campaign_data = $campaign_query->fetch_object();
    $total_campaign_payments = $campaign_data->total ?? 0;
}

// Calculate overall total payments (donations + campaign payments)
$total_payments = $total_donations + $total_campaign_payments;

// Fetch number of projects supported from campaign_payments table
$projects_supported = 0;
$projects_query = $obj->query("SELECT COUNT(DISTINCT campaign_id) AS total_projects FROM campaign_payments WHERE user_id='$user_id'");
if ($projects_query) {
    $projects_data = $projects_query->fetch_object();
    $projects_supported = $projects_data->total_projects ?? 0;
}

// Determine donation rank based on total payments
if ($total_payments < 5000) {
    $donation_rank = "Bronze";
} elseif ($total_payments < 10000) {
    $donation_rank = "Silver";
} else {
    $donation_rank = "Gold";
}

// Handle Profile Update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $cpass = $_POST['cpassword'];
    $contact = trim($_POST['contact']);
    $gender = $_POST['gender'];
    $reg_date = date('Y-m-d');

    if ($password === $cpass) {
        $stmt = $obj->prepare("UPDATE user SET name=?, email=?, contact=?, gender=?, reg_date=?, password=? WHERE user_id=?");
        $stmt->bind_param("ssssssi", $name, $email, $contact, $gender, $reg_date, $password, $user_id);
        if ($stmt->execute()) {
            $message = "<p style='color: green;'>Profile updated successfully.</p>";
        } else {
            $message = "<p style='color: red;'>Error updating profile.</p>";
        }
        $stmt->close();
    } else {
        $message = "<p style='color: red;'>Password mismatch.</p>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            overflow-x: hidden;
        }
        .wrapper {
            display: flex;
            flex-wrap: wrap;
        }
        #sidebar {
            min-width: 250px;
            max-width: 250px;
            background: #343a40;
            color: #fff;
            transition: all 0.3s;
            position: fixed;
            height: 100%;
            z-index: 1000;
            left: -250px;
        }
        #sidebar.active {
            left: 0;
        }
        #content {
            width: 100%;
            transition: all 0.3s;
            padding: 20px;
            margin-left: 0;
        }
        .card {
            margin-bottom: 20px;
        }
        .sidebar-footer a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 10px;
        }
        @media (max-width: 768px) {
            #sidebar {
                min-width: 0;
                max-width: 0;
                left: -250px;
            }
            #sidebar.active {
                min-width: 250px;
                max-width: 250px;
                left: 0;
            }
            #content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header text-center">
                <h3>Rajni Tech Foundation</h3>
                <img src="assets/images/logo1.jpg" alt="NGO Logo" class="img-fluid">
            </div>
            <ul class="list-unstyled components">
                <li><a href="home.php"><i class="fas fa-home"></i> Home</a></li>
                <li><a href="my_money_donation.php"><i class="fas fa-hand-holding-heart"></i> My Donations</a></li>
                <li><a href="campaigns.php"><i class="fas fa-project-diagram"></i> Campaigns</a></li>
            </ul>
            <div class="sidebar-footer">
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <button type="button" id="sidebarCollapse" class="btn btn-info">
                    <i class="fas fa-align-left"></i> Menu
                </button>
            </nav>
            <div class="container mt-4">
                <div class="row">
                    <div class="col-12 col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5>Total Donated</h5>
                                <h2>₹<?= $total_payments ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5>Campaign donation</h5>
                                <h2>₹<?= $total_campaign_payments ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5>Campaigns Supported</h5>
                                <h2><?= $projects_supported ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5>Donation Rank</h5>
                                <h2><?= $donation_rank ?></h2>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Update Form -->
                <div class="card mt-4">
                    <div class="card-header text-center">
                        <h5>Edit Profile</h5>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <div class="mb-3">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($row->name) ?>">
                            </div>
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($row->email) ?>">
                            </div>
                            <div class="mb-3">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Confirm Password</label>
                                <input type="password" name="cpassword" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Contact</label>
                                <input type="text" name="contact" class="form-control" maxlength="10" required value="<?= htmlspecialchars($row->contact) ?>">
                            </div>
                            <div class="mb-3">
                                <label>Gender</label>
                                <select name="gender" class="form-control">
                                    <option value="Male" <?= ($row->gender == "Male") ? "selected" : "" ?>>Male</option>
                                    <option value="Female" <?= ($row->gender == "Female") ? "selected" : "" ?>>Female</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                        <?= $message ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>
</body>
</html>

