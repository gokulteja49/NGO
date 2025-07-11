<header id="site-header" class="fixed-top">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark stroke">
            <a class="navbar-brand" href="home.php">
                <img src="assets/images/logo1.jpg" alt="Your logo" title="Your logo" style="height:35px;" />
                <span class="sub-logo">Rajni Tech Foundation</span>
            </a>
            
            <button class="navbar-toggler collapsed bg-gradient" type="button" data-toggle="collapse"
                data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon fa icon-expand fa-bars"></span>
                <span class="navbar-toggler-icon fa icon-close fa-times"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Inquiry</a></li>
                    <li class="nav-item"><a class="nav-link" href="blogs.php">Blogs</a></li>

                    <?php if(isset($_SESSION['user_id'])) { ?>
                        <li class="nav-item"><a class="nav-link" href="feedback.php">Feedback</a></li>
                        <li class="nav-item"><a class="nav-link" href="campaigns.php">Campaigns</a></li>
                        <li class="nav-item"><a class="nav-link" href="donation_c.php">Special Donation</a></li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="dropdownMenuButton1" data-toggle="dropdown" aria-expanded="false">
                                Profile
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a class="dropdown-item" href="my_money_donation.php"><i class="fa fa-user"></i> My Donation</a></li>
                                <li><a class="dropdown-item" href="m_profile.php"><i class="fa fa-suitcase"></i> Edit Profile</a></li>
                                <li><a class="dropdown-item" href="campaign_donation.php"><i class="fa fa-suitcase"></i> Campaign Donation</a></li>
                                <li><a class="dropdown-item" href="logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
                            </ul>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
                        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    <?php } ?>
                </ul>
            </div>
        </nav>
    </div>
</header>
<style>@media (max-width: 768px) {
    .navbar-brand {
        display: flex;
        align-items: center;
        font-size: 14px; 
        max-width: 80%; 
        white-space: nowrap; 
    }

    .sub-logo {
        font-size: 12px; 
        margin-left: 5px;
    }

    .navbar-toggler {
        margin-left: auto;
    }

    .dropdown-menu {
        position: absolute !important;
        right: 0;
        left: auto;
        top: 100%;
        transform: translateY(0);
        z-index: 1050;
    }
}
</style>