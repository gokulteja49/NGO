<?php
session_start();
include 'common/connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$apiKey = "rzp_test_pXtLNzDfIlN645";  // Replace with your Razorpay API Key

// Fetch user details
$profile_data = $obj->query("SELECT * FROM user WHERE user_id='$user_id'");
$profile = $profile_data->fetch_object();

// Fetch campaign details (Modify this to get the correct campaign)
$campaign_data = $obj->query("SELECT * FROM campaigns ORDER BY campaign_id DESC LIMIT 1"); // Modify based on logic
$campaign = $campaign_data->fetch_object();
$campaign_id = $campaign->campaign_id; // Ensure this is correct
?>

<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Donate - RTF NGO</title>
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <link href="//fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">
</head>

<body>

<?php include 'common/header.php'; ?>

<div class="inner-banner"></div>

<section class="w3l-contact-11">
    <div class="form-41-mian py-5">
        <div class="container py-lg-4">
            <div class="row align-form-map">
                <div class="col-lg-6 contact-left pr-lg-4">
                    <h3 class="hny-title mb-4">Support Our Cause</h3>
                    <p>Every contribution helps us make a difference in the lives of those in need.</p>
                </div>
                
                <div class="col-lg-6 form-inner-cont">
                    <div class="title-content text-left mb-3">
                        <h4>Make a Donation</h4>
                    </div>

                    <form id="donation-form">
                        <label for="amount">Enter Amount (INR)</label>
                        <input type="number" name="amount" id="amount" class="form-control mb-3" required>
                        <input type="hidden" id="campaign_id" value="<?php echo $campaign_id; ?>">
                        <button type="button" id="rzp-button1" class="btn btn-primary">Donate Now</button>
                        <p id="payment-status" style="color: green; display: none;">Payment successful! Thank you for your donation.</p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'common/footer.php'; ?>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="assets/js/jquery-3.3.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<script>
    document.getElementById('rzp-button1').onclick = function (e) {
        var amount = document.getElementById('amount').value;
        var campaign_id = document.getElementById('campaign_id').value;

        if (!amount || amount <= 0) {
            alert("Please enter a valid amount.");
            return;
        }

        var options = {
            "key": "<?php echo $apiKey; ?>",
            "amount": amount * 100,  // Razorpay requires the amount in paise
            "currency": "INR",
            "name": "RTF NGO",
            "description": "Donation for a Noble Cause",
            "image": "https://oibp1.000webhostapp.com/logo.PNG",
            "handler": function (response) {
                $.ajax({
                    url: "u_d.php",
                    type: "POST",
                    data: {
                        razorpay_payment_id: response.razorpay_payment_id,
                        amount: amount,
                        campaign_id: campaign_id
                    },
                    success: function (data) {
                        let res = JSON.parse(data);
                        if (res.status === "success") {
                            document.getElementById('payment-status').style.display = "block";
                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);
                        } else {
                            alert("Payment successful, but there was an issue updating the donation.");
                        }
                    },
                    error: function () {
                        alert("Payment was successful, but the database update failed.");
                    }
                });
            },
            "prefill": {
                "name": "<?php echo htmlspecialchars($profile->name); ?>",
                "email": "<?php echo htmlspecialchars($profile->email); ?>",
                "contact": "<?php echo htmlspecialchars($profile->contact); ?>"
            },
            "theme": {
                "color": "#ff9902"
            }
        };

        var rzp1 = new Razorpay(options);
        rzp1.open();
        e.preventDefault();
    }
</script>

</body>
</html>
