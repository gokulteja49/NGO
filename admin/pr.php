<?php
include 'common/connect.php';

if (!isset($_GET['id'])) {
    die("Invalid request");
}

$id = $_GET['id'];
$result = $obj->query("SELECT * FROM money_donation WHERE m_id='$id'");

if ($result->num_rows == 0) {
    die("No record found");
}

$row = $result->fetch_object();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Donation Receipt - Rajini Tech Foundation</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 20px; background-color: #f8f9fa; }
        .receipt-container { background: #fff; padding: 20px; border-radius: 10px; width: 50%; margin: auto; box-shadow: 0px 0px 10px rgba(0,0,0,0.1); }
        .receipt-header img { width: 80px; }
        .receipt-header h2 { margin: 10px 0; font-size: 24px; }
        .receipt-details { text-align: left; margin-top: 20px; font-size: 18px; }
        .receipt-details p { margin: 8px 0; }
        .btn-print { padding: 10px 20px; background: blue; color: white; border: none; cursor: pointer; font-size: 16px; margin-top: 20px; }
        .footer { margin-top: 20px; font-size: 14px; color: gray; }
    </style>
</head>
<body>

<div class="receipt-container">
    <div class="receipt-header">
        <img src="logo1.jpg" alt="Rajini Tech Foundation">
        <h2>Rajini Tech Foundation</h2>
        <p><strong>Official Donation Receipt</strong></p>
    </div>

    <div class="receipt-details">
        <p><strong>Donor Name:</strong> <?php echo htmlspecialchars($row->d_name); ?></p>
        <p><strong>Donation Amount:</strong> ₹<?php echo number_format($row->amount, 2); ?></p>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($row->description); ?></p>
        <p><strong>Date:</strong> <?php echo date("d M Y, h:i A", strtotime($row->date)); ?></p>
    </div>

    <button class="btn-print" onclick="window.print()">Print Receipt</button>

    <div class="footer">
        <p>Thank you for your generous donation! Your support helps us make a difference.</p>
    </div>
</div>

</body>
</html>
