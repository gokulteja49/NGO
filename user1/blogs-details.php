<?php
session_start();
include 'common/connect.php';
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("❌ Invalid request: Missing blog ID.");
}

$blog_id = intval($_GET['id']); 

// Fetch the main blog details
$query = "SELECT * FROM blogs WHERE id = ?";
$stmt = $obj->prepare($query);
if ($stmt) {
    $stmt->bind_param("i", $blog_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $blog = $result->fetch_assoc();
    $stmt->close();
} else {
    die("Database error: " . $obj->error);
}

// If no blog found, redirect
if (!$blog) {
    header('location:blogs.php');
    exit;
}

// Fetch 3 related blogs (excluding the current one)
$related_blogs = [];
$query_related = "SELECT * FROM blogs WHERE id != ? ORDER BY RAND() LIMIT 3";
$stmt_related = $obj->prepare($query_related);
if ($stmt_related) {
    $stmt_related->bind_param("i", $blog_id);
    $stmt_related->execute();
    $result_related = $stmt_related->get_result();
    while ($row = $result_related->fetch_assoc()) {
        $related_blogs[] = $row;
    }
    $stmt_related->close();
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo htmlspecialchars($blog['title']); ?></title>
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        .blog-container {
            max-width: 900px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .blog-title {
            font-size: 28px;
            font-weight: 700;
            color: #222;
            text-align: center;
            margin-bottom: 20px;
        }

        .blog-image {
            width: 100%;
            max-height: 450px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
            display: block;
            margin: auto;
        }

        .blog-content {
            font-size: 18px;
            line-height: 1.7;
            text-align: justify;
            margin-top: 20px;
        }

        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #ff6600;
            color: white;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
            transition: 0.3s ease;
        }

        .back-btn:hover {
            background: #cc5500;
        }

        /* Related Blogs Section */
        .related-blogs {
            margin-top: 50px;
            text-align: center;
        }

        .related-blogs h4 {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .related-blog-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .related-blog-card:hover {
            transform: translateY(-5px);
        }

        .related-blog-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .related-blog-content {
            padding: 15px;
        }

        .related-blog-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #333;
        }

        .related-blog-btn {
            display: inline-block;
            padding: 8px 15px;
            background: #007bff;
            color: white;
            text-decoration: none;
            font-size: 14px;
            border-radius: 5px;
            transition: 0.3s ease;
        }

        .related-blog-btn:hover {
            background: #0056b3;
        }

    </style>
</head>

<body>
    <?php include 'common/header.php'; ?>

    <div class="inner-banner"></div>

    <section class="w3l-blog-details py-5">
        <div class="container">
            <div class="blog-container">
                <h3 class="blog-title"><?php echo htmlspecialchars($blog['title']); ?></h3>
                <img src="../admin/uploads/blogs/<?php echo htmlspecialchars($blog['image']); ?>" class="blog-image" alt="Blog Image">
                <p class="blog-content"><?php echo nl2br(htmlspecialchars($blog['description'])); ?></p>
                <a href="blogs.php" class="back-btn">← Back to Blogs</a>
            </div>

            <!-- Related Blogs Section -->
            <div class="related-blogs">
                <h4>More Blogs You May Like</h4>
                <div class="row">
                    <?php foreach ($related_blogs as $related): ?>
                        <div class="col-md-4 mb-4">
                            <div class="related-blog-card">
                                <img src="../admin/uploads/blogs/<?php echo htmlspecialchars($related['image']); ?>" alt="Related Blog">
                                <div class="related-blog-content">
                                    <h5 class="related-blog-title"><?php echo htmlspecialchars($related['title']); ?></h5>
                                    <a href="blogs-details.php?id=<?php echo urlencode($related['id']); ?>" class="related-blog-btn">Read More</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
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
