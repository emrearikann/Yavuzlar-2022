<?php
include("./database.php");

try {
    if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["phone"]) && isset($_POST["message"])) {
        $senderName = $_POST["name"];
        $senderEmail = $_POST["email"];
        $senderPhone = $_POST["phone"];
        $senderMessage = $_POST["message"];

        $fm = $db->prepare("INSERT INTO contact (name, email, phone, message) VALUES ('$senderName', '$senderEmail', '$senderPhone', '$senderMessage');");
        $fm->execute(array());
        $results = $fm->fetchAll();
        header("Location: index.php");
        exit();
    }
} catch (PDOException $e) {
    echo $e;
}

include("./database.php");

$content4 = $db->prepare("SELECT blogCover FROM content");
$content4->execute(array());
$contentResults = $content4->fetchAll();
foreach ($contentResults as $contentt4) {
    $file = "./images/" . $contentt4["blogCover"];
    $image = fopen($file, "w") or die("Unable to open file!");
    fclose($image);
}

$aboutme = $db->prepare("SELECT * FROM aboutme");
$aboutme->execute(array());
$aboutResults = $aboutme->fetchAll();
foreach ($aboutResults as $aboutt) {
}

$categories = $db->prepare("SELECT * FROM categories");
$categories->execute(array());
$catResults = $categories->fetchAll();
foreach ($catResults as $catt) {
}

$contact = $db->prepare("SELECT * FROM contact");
$contact->execute(array());
$contactResults = $contact->fetchAll();
foreach ($contactResults as $contactt) {
}

$content = $db->prepare("SELECT * FROM content");
$content->execute(array());
$contentResults = $content->fetchAll();
// foreach ($contentResults as $contentt) {
//     echo '<pre> ' . explode(" ", trim($contentt["blogCat"]))[0] . ' </pre>';
// }

$homepage = $db->prepare("SELECT * FROM homepage");
$homepage->execute(array());
$homeResults = $homepage->fetchAll();
foreach ($homeResults as $homee) {
}
?>

<!DOCTYPE html>
<html lang="en">

<!-- Basic -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<!-- Mobile Metas -->
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

<!-- Site Metas -->
<title>Dominic - Responsive HTML5 OnePage Template</title>
<meta name="keywords" content="">
<meta name="description" content="">
<meta name="author" content="">

<!-- Site Icons -->
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
<link rel="apple-touch-icon" href="images/apple-touch-icon.png">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="css/bootstrap.min.css">
<!-- Site CSS -->
<link rel="stylesheet" href="css/style.css">
<!-- Responsive CSS -->
<link rel="stylesheet" href="css/responsive.css">
<!-- Custom CSS -->
<link rel="stylesheet" href="css/custom.css">
<script src="js/modernizr.js"></script> <!-- Moderniz -->

<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="page-top" class="politics_version">

    <!-- LOADER -->
    <div id="preloader">
        <div id="main-ld">
            <div id="loader"></div>
        </div>
    </div><!-- end loader -->
    <!-- END LOADER -->

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand js-scroll-trigger" href="#page-top">
                <img class="img-fluid" src="images/logo.png" alt="" />
            </a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fa fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav text-uppercase ml-auto">
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger active" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="#about">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="#blog">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="#contact">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section id="home" class="main-banner parallaxie" style="background: url('uploads/banner-01.jpg')">
        <div class="heading">
            <h1><?= $homee["welcome"]; ?></h1>
            <h3 class="cd-headline clip is-full-width">
                <span>I am working on</span>
                <span class="cd-words-wrapper">
                    <b class="is-visible"><?= $homee["endeavors"]; ?></b>
                    <?php
                    foreach ($catResults as $category) {
                        echo '<b>' . $category["category"] . '</b>';
                    }
                    ?>
                </span>
            </h3>
        </div>
    </section>

    <svg id="clouds" class="hidden-xs" xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="100" viewBox="0 0 85 100" preserveAspectRatio="none">
        <path d="M-5 100 Q 0 20 5 100 Z
            M0 100 Q 5 0 10 100
            M5 100 Q 10 30 15 100
            M10 100 Q 15 10 20 100
            M15 100 Q 20 30 25 100
            M20 100 Q 25 -10 30 100
            M25 100 Q 30 10 35 100
            M30 100 Q 35 30 40 100
            M35 100 Q 40 10 45 100
            M40 100 Q 45 50 50 100
            M45 100 Q 50 20 55 100
            M50 100 Q 55 40 60 100
            M55 100 Q 60 60 65 100
            M60 100 Q 65 50 70 100
            M65 100 Q 70 20 75 100
            M70 100 Q 75 45 80 100
            M75 100 Q 80 30 85 100
            M80 100 Q 85 20 90 100
            M85 100 Q 90 50 95 100
            M90 100 Q 95 25 100 100
            M95 100 Q 100 15 105 100 Z">
        </path>
    </svg>

    <div id="about" class="section wb">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="message-box">
                        <h2>About Me</h2>
                        <p><?= $aboutt["about"]; ?></p>
                        <a href="download.php" class="sim-btn btn-hover-new" data-text="Download CV"><span>Download CV</span></a>
                    </div><!-- end messagebox -->
                </div><!-- end col -->

                <div class="col-md-6">
                    <div class="right-box-pro wow fadeIn">
                        <img src="uploads/about_04.jpg" alt="" class="img-fluid img-rounded">
                    </div><!-- end media -->
                </div><!-- end col -->
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end section -->

    <div id="blog" class="section lb">
        <div class="container">
            <div class="section-title text-left">
                <h3>Blog</h3>
                <p>Quisque eget nisl id nulla sagittis auctor quis id. Aliquam quis vehicula enim, non aliquam risus.</p>
            </div><!-- end title -->

            <div class="gallery-menu row">
                <div class="col-md-12">
                    <div class="button-group filter-button-group text-left">

                        <button class="active filter" data-filter="*" name="allBlogs" id="all">All</button>
                        <!-- <button data-filter=".gal_a">Web Development</button>
                            <button data-filter=".gal_b">Creative Design</button>
                            <button data-filter=".gal_c">Graphic Design</button> -->

                        <?php
                        foreach ($catResults as $result) {
                            echo '<button data-filter=".gal_a" class="filter" name="filterButton" id="' . explode(" ", trim($result["category"]))[0] . '"> ' . $result["category"] . ' </button>';
                        }
                        ?>

                    </div>
                </div>
            </div>

            <div class="gallery-list row">
                <?php
                foreach ($contentResults as $contentt) {
                    echo
                    '<div class="col-md-4 col-sm-6 gallery-grid gal_a gal_b renderingBlogs" id="' . explode(" ", trim($contentt["blogCat"]))[0] . '">
                        <div class="gallery-single fix">
                            <img src="./images/' . ($contentt["blogCover"]) . '" class="img-fluid" alt="Image">
                            <p>' . substr(strip_tags($contentt["blogText"]), 0, 124) . '...</p>
                        </div>
                    </div>';
                }
                ?>

                <div class="col-md-4 col-sm-6 gallery-grid gal_a gal_b">
                    <div class="gallery-single fix">
                        <img src="uploads/gallery_img-01.jpg" class="img-fluid" alt="Image">
                        <p>Quisque eget nisl id nulla sagittis auctor quis id. Aliquam quis vehicula enim, non aliquam risus.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div id="contact" class="section db">
        <div class="container">
            <div class="section-title text-left">
                <h3>Contact</h3>
            </div><!-- end title -->

            <div class="row">
                <div class="col-md-12">
                    <div class="contact_form">
                        <div id="message"></div>
                        <form id="contactForm" name="sentMessage" novalidate="novalidate" action="#" method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input class="form-control" name="name" id="name" type="text" placeholder="Your Name" required="required" autocomplete="off" data-validation-required-message="Please enter your name.">
                                        <p class="help-block text-danger"></p>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" name="email" id="email" type="email" placeholder="Your Email" required="required" autocomplete="off" data-validation-required-message="Please enter your email address.">
                                        <p class="help-block text-danger"></p>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" name="phone" id="phone" type="tel" placeholder="Your Phone" required="required" autocomplete="off" data-validation-required-message="Please enter your phone number.">
                                        <p class="help-block text-danger"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <textarea class="form-control" name="message" id="message" placeholder="Your Message" required="required" data-validation-required-message="Please enter a message."></textarea>
                                        <p class="help-block text-danger"></p>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-lg-12 text-center">
                                    <div id="success"></div>
                                    <!-- <button id="sendMessageButton" class="sim-btn btn-hover-new" data-text="Send Message" type="submit">Send Message</button> -->
                                    <input type="submit" value="Send Message">
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!-- end col -->
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end section -->

    <div class="copyrights">
        <div class="container">
            <div class="footer-distributed">
                <div class="footer-left">
                    <p class="footer-links">
                        <a href="#home">Home</a>
                        <a href="#blog">Blog</a>
                        <a href="#about">About</a>
                        <a href="#contact">Contact</a>
                    </p>
                    <p style="color: #ffc107;">This Blog is developed with love and caffeine. </p>
                </div>
            </div>
        </div><!-- end container -->
    </div><!-- end copyrights -->

    <a href="#" id="scroll-to-top" class="dmtop global-radius"><i class="fa fa-angle-up"></i></a>

    <!-- ALL JS FILES -->
    <script src="js/all.js"></script>
    <!-- Camera Slider -->
    <script src="js/jquery.mobile.customized.min.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>
    <script src="js/parallaxie.js"></script>
    <script src="js/headline.js"></script>
    <!-- Contact form JavaScript -->
    <!-- <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script> -->
    <!-- ALL PLUGINS -->
    <script src="js/custom.js"></script>
    <script src="js/jquery.vide.js"></script>

    <script>
        let ids = document.querySelectorAll(".filter");
        let render = document.querySelectorAll(".renderingBlogs");


        for (let i = 0; i < ids.length; i++) {
            ids[i].addEventListener("click", (e) => {
                let myValue = e.target.id;
                render.forEach((e) => {
                    if (myValue === "all") {
                        e.style.removeProperty("display", "none");
                    } else if (myValue !== e.id) {
                        e.style.setProperty("display", "none");
                    } else {
                        e.style.removeProperty("display", "none");
                    }
                })
            });
        }
    </script>


</body>

</html>