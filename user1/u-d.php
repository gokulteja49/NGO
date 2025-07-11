<?php
session_start();
include 'common/connect.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit();
}

$user_id = $_SESSION['user_id'];
$payment_id = $_POST['razorpay_payment_id'];
$amount = $_POST['amount'];
$campaign_id = $_POST['campaign_id'];

if (!$payment_id || !$amount || !$campaign_id) {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
    exit();
}

// Fetch user details
$user_query = $obj->query("SELECT name FROM user WHERE user_id = '$user_id'");
if ($user_query->num_rows === 0) {
    echo json_encode(["status" => "error", "message" => "User not found"]);
    exit();
}
$user = $user_query->fetch_object();
$user_name = $user->name;

// Ensure campaign exists
$campaign_check = $obj->query("SELECT * FROM campaign WHERE campaign_id = '$campaign_id'");
if ($campaign_check->num_rows === 0) {
    echo json_encode(["status" => "error", "message" => "Invalid campaign ID"]);
    exit();
}

// Begin transaction
$obj->begin_transaction();

try {
    // Update the raised amount for the campaign
    $update_query = $obj->query("UPDATE campaign SET raised = raised + $amount WHERE campaign_id = '$campaign_id'");

    // Insert payment record into campaign_payments
    $insert_query = $obj->query("INSERT INTO campaign_payments (user_id, user_name, campaign_id, amount, payment_id) 
                                 VALUES ('$user_id', '$campaign_id', '$amount', '$payment_id')");

    if ($update_query && $insert_query) {
        $obj->commit();
        echo json_encode(["status" => "success", "message" => "Donation updated successfully"]);
    } else {
        $obj->rollback();
        echo json_encode(["status" => "error", "message" => "Database update failed"]);
    }
} catch (Exception $e) {
    $obj->rollback();
    echo json_encode(["status" => "error", "message" => "Transaction failed"]);
}
?>
