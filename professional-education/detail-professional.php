<?php

require_once('../function.php');
$PostId=intval($_GET['id']);
$rows=getProfessionalPosts($PostId);

?>

<!DOCTYPE html>
<html lang="en-US" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- ==============================================
    TITLE AND META TAGS
    =============================================== -->
    <title>Professional Education</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Quickdev">

    <!-- ==============================================
    FAVICON
    =============================================== -->
    <link rel="shortcut icon" href="../img/img-page/favicon.png">

    <!-- ==============================================
    CSS
    =============================================== -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../fonts/font-awesome/css/font-awesome.min.css">

</head>

<body>

<!-- LOADER -->
<div id="loader-wrapper">
    <div id="loader"></div>
</div>
<!-- LOADER -->

<!-- MAIN CONTAINER -->
<div class="wrapper">
    <div class="header">
        <div class="navbar">
            <nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
                <div class="container">
                    <div class="navbar-header" >
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="../../eProject-32smiles"><div class="logo-brand"><img src="../img/img-page/logo.png" alt=""></div></a>
                    </div>
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="../../eProject-32smiles">HOME</a></li>
                            <li><a href="../professional-education">PROFESSIONAL EDUCATION</a></li>
                            <li><a href="../patient-education/">PATIENT EDUCATION</a></li>
                            <li><a href="../research/">RESEARCH</a></li>
                            <li><a href="../product">PRODUCTS</a></li>
                            <li><a href="../contact-us">CONTACT US</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <div class="pages-header">
        <div class="section-heading">
            <div class="section">
                <div class="span-title">
                    <h1>Professional Education</h1>
                    <div class="page-map"><p>Category &nbsp;/&nbsp;Professional Education </p></div>
                </div>
            </div>
        </div>
    </div>

    <div class="main">
        <div class="section">
            <div class="row">
                <div class="col-md-8">
                    <div class="department-info">
                        <?php if ($rows['media_type'] == 'image/png' ||  $rows['media_type'] == 'image/jpg' || $rows['media_type'] == 'image/jpeg'): ?>
                            <img src="<?php echo convertImagePath($rows['media_path']); ?>" alt="" class="department-img">
                        <?php elseif ($rows['media_type'] == 'video/mp4'): ?>
                            <video id="current_media" controls style="width: 100%" >
                                <source src="<?php echo convertImagePath($rows['media_path']); ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        <?php endif; ?>
                        <h5><?php echo $rows['post_title']; ?></h5>
                        <hr class="short">
                        <p><?php echo $rows['post_content']; ?></p>
                        <hr>
                        <p><a href="index.php" ><button type="button" class="btn btn-primary">Back To The Posts List</button></a></p>
                    </div>
                </div>
<!--                <div class="col-md-4">-->
<!--                    <div class="sidebar">-->
<!--                        <div class="inner-sidebar">-->
<!--                            <h5>Category</h5>-->
<!--                            <div class="list-group">-->
<!--                                <a href="student-resources.php" class="list-group-item"><i class="fa-solid fa-user-tie"></i> Student Resources</a>-->
<!--                                <a href="faculty-resources.php" class="list-group-item"><i class="fa-solid fa-book-open"></i> Faculty Resources</a>-->
<!--                            </div>-->
<!--                        </div>-->
<!---->
<!--                    </div>-->
<!--                </div>-->
            </div>
        </div>
    </div>



</div>
<!-- END MAIN CONTAINER -->

<div class="footer">
    <div class="main">
        <div class="row" style="background-color: #eceaea">
            <div class="col-md-7 footer-info">
                <div class="about-footer">
                    <div class="logo-brand">
                        <img src="../img/img-page/logo.png" alt=""/>
                    </div>
                    <p>
                        At 32smiles, we are dedicated to providing you with a wealth of dental health information,
                        crafted to enlighten and guide you through a journey of dental wellness. Our content, curated by
                        dental professionals, is designed to offer insights and advice that you can trust, covering
                        everything from routine care to advanced dental treatments. Unlike generic health sites,
                        32smiles ensures that every article, guide, and recommendation is backed by sound dental
                        science, aiming to empower you with knowledge that promotes oral health. Our commitment is to be
                        your most reliable source of dental information on the web, helping you to smile brighter with
                        each visit.
                    </p>
                </div>
            </div>
        </div>
        <div class="bottom-footer">
            <div class="main">
                <div class="section">
                    <div class="column-left">
                        <p>© 2024 All Rights Reserved, 32smiles</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<a href="#0" class="cd-top">Top</a>
<script src="https://kit.fontawesome.com/ad6cc57e98.js" crossorigin="anonymous"></script>
<!--	<script src="../../../ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.js"></script>-->
<script src='../js/jquery.min.js'></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/loader.js"></script>
<script src="../js/top.js"></script>
<script src="../js/navbar.js"></script>
<!--    <script src="jquery-3.2.1.min.html"></script>-->

</body>

</html>