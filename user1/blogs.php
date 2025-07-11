

<?php
session_start();
include 'common/connect.php';

// Fetch blogs from the database
$blogs = [];
$query = "SELECT * FROM blogs ORDER BY id DESC";
$result = mysqli_query($obj, $query);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $blogs[] = $row;
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>RTF(NGO) - Blogs</title>
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f7f7f7;
        }

        .blog-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .blog-card {
            position: relative;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            border-radius: 10px;
            height: 350px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .blog-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.2); /* Reduced overlay */
            transition: 0.3s ease-in-out;
        }

        .blog-card:hover::before {
            background: rgba(0, 0, 0, 0.5);
        }

        .blog-card-content {
            position: relative;
            z-index: 2;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 15px;
            border-radius: 0 0 10px 10px;
            transition: 0.3s ease-in-out;
        }

        .blog-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .read-more {
            text-decoration: none;
            background: #ff6600;
            color: white;
            padding: 8px 12px;
            display: inline-block;
            border-radius: 5px;
            transition: 0.3s ease;
            font-weight: bold;
        }

        .read-more:hover {
            background: #cc5500;
        }
    </style>
</head>

<body>
    <?php include 'common/header.php'; ?>

    <div class="inner-banner"></div>

    <section class="w3l-blogs py-5">
        <div class="container py-lg-4">
            <div class="title-content text-left">
                <h3 class="hny-title mb-lg-5 mb-4">Latest Blogs</h3>
            </div>
            <div class="blog-container">
                <?php foreach ($blogs as $blog): ?>
                    <div class="blog-card" style="background-image: url('../admin/uploads/blogs/<?php echo htmlspecialchars($blog['image']); ?>');">
                        <div class="blog-card-content">
                            <h5 class="blog-title"><?php echo htmlspecialchars($blog['title']); ?></h5>
                            <a href="blogs-details.php?id=<?php echo urlencode($blog['id']); ?>" class="read-more">Read More</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php include 'common/footer.php'; ?>

    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <script>
        $(function () {
            $('.navbar-toggler').click(function () {
                $('body').toggleClass('noscroll');
            });
        });

        $(window).on("scroll", function () {
            var scroll = $(window).scrollTop();
            if (scroll >= 80) {
                $("#site-header").addClass("nav-fixed");
            } else {
                $("#site-header").removeClass("nav-fixed");
            }
        });

        $(".navbar-toggler").on("click", function () {
            $("header").toggleClass("active");
        });

        $(document).ready(function () {
            if ($(window).width() > 991) {
                $("header").removeClass("active");
            }
            $(window).on("resize", function () {
                if ($(window).width() > 991) {
                    $("header").removeClass("active");
                }
            });
        });
    </script>
</body>

</html>
