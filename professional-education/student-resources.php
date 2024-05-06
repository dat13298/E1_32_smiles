<?php

require_once('../function.php');
$rows=getStudentResources();

?>

<!DOCTYPE html>
<html lang="en-US" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Professional Educational</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Quickdev">
    <link rel="shortcut icon" href="../img/img-page/favicon.png">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../fonts/font-awesome/css/font-awesome.min.css">
</head>
<?php ?>

<body>

<!-- LOADER -->
<div id="loader-wrapper">
    <div id="loader"></div>
</div>
<!-- LOADER -->
<!-- MAIN CONTAINER -->
<div class="wrapper">
    <div class="header">
        <!---Nav Bar -->
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
    <!--- Header  -->
    <div class="pages-header">
        <div class="section-heading">
            <div class="section">
                <div class="span-title">
                    <h1>Student Resources</h1>
                    <div class="page-map"><p>Category &nbsp;/&nbsp;Professional Education</p></div>
                </div>
            </div>
        </div>
    </div>
    <div class="main">
        <div class="section">
            <div class="row">
                <div class="col-md-9">
                    <?php foreach($rows as $row) { ?>
                        <hr class="line-post">
                        <div class="post-preview">
                            <div class="photo-preview">
                                <?php if ($row['media_type'] == 'image/png' ||  $row['media_type'] == 'image/jpg' || $row['media_type'] == 'image/jpeg'): ?>
                                    <img id="current_media" src="<?php echo convertImagePath($row['media_path']); ?>"
                                         alt="Current Media" style="width: 290px;height: 200px">
                                <?php elseif ($row['media_type'] == 'video/mp4'): ?>
                                    <video id="current_media" controls style="width: 290px;height: 200px">
                                        <source src="<?php echo convertImagePath($row['media_path']); ?>" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                <?php endif; ?>
                            </div>
                            <div class="post-details">
                                <h5 class="post-title"><?php echo $row['post_title'] ?></h5>
                                <p class="post-text">
                                    <?php
                                    echo substr($row['post_content'], 0, 400);
                                    if(strlen($row['post_content']) > 255){
                                        echo "...";
                                    }
                                    ?>
                                </p>
                                <p class="author"><i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp; <?php echo date('Y-m-d', strtotime($row['post_created_at'])); ?></p>
                                <p><a href="detail-professional.php?id=<?php echo $row['post_id']; ?>"><button type="button" class="btn btn-primary">Read More</button></a></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <div class="col-md-3">
                    <div class="sidebar">
                        <div class="inner-sidebar">
                            <h5>Category</h5>
                            <div class="list-group">
                                <a href="index.php" class="list-group-item"><i class="fa-solid fa-list"></i> All Posts</a>
                                <a href="student-resources.php" class="list-group-item"><i class="fa-solid fa-user-tie"></i> Student Resources</a>
                                <a href="faculty-resources.php" class="list-group-item"><i class="fa-solid fa-book-open"></i> Faculty Resources</a>
                            </div>
                        </div>
                    </div>
                </div>

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