<?php
require_once "../function.php";
init_connection();
$post_id = intval(isset($_GET['post_id']) ? $_GET['post_id'] : '');
$post = getPostByID($post_id);
$media = getMediaByPostID($post_id);
?>

<!DOCTYPE html>
<html lang="en-US" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $post['post_title']; ?>></title>
    <link rel="shortcut icon" href="../img/img-page/favicon.png">
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
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="../../eProject-32smiles">
                            <div class="logo-brand"><img src="../img/img-page/logo.png" alt=""></div>
                        </a>
                    </div>
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="../../eProject-32smiles">HOME</a></li>
                            <li><a href="../professional-education">PROFESSIONAL EDUCATION</a></li>
                            <li><a href="../patient-education">PATIENT EDUCATION</a></li>
                            <li><a href="../research">RESEARCH</a></li>
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
                    <h1>Blog Single</h1>
                    <div class="page-map"><p>Home &nbsp;/&nbsp;Latest Research</p></div>
                </div>
            </div>
        </div>
    </div>

    <div class="main">
        <div class="section">
            <div class="row">
                <div class="col-md-9">
                    <div class="post-content">
                        <div class="post-photo">
                            <?php if ($media['media_type'] == 'image'):?>
                                <img src="<?php echo convertImagePath($media['media_path']) ?>"
                                     alt="<?php echo $media['media_text'] ?>">
                            <?php elseif ($media['media_type'] =='video'):?>
                                <video autoplay controls >
                                    <source src="<?php echo convertImagePath($media['media_path']) ?>">
                                </video>
                            <?php endif;?>
                        </div>
                        <div class="post-title"><h1><?php echo $post['post_title'] ?></h1></div>
                        <div class="post-content">
                            <p><?php $content = $post['post_content'];
                                echo nl2br($content); ?></p>
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
<script src="https://code.jquery.com/jquery-1.11.1.js"></script>
<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/loader.js"></script>
<script src="../js/top.js"></script>
<script src="../js/navbar.js"></script>
<script src="../js/jquery.waypoints.min.js"></script>

</body>

</html>