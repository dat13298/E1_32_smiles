<?php
require_once ('../function.php');
init_connection();
$id = intval($_GET['id'] ?? '');
$row = $id ? getProduct($id) : [];
$productShows = getProductOther($id);
?>

<!DOCTYPE html>
<html lang="en-US" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $row['product_name'] ?></title>
    <link rel="shortcut icon" href="../img/img-page/favicon.png">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../fonts/font-awesome/css/font-awesome.min.css">
</head>
<body>
<div id="loader-wrapper">
    <div id="loader"></div>
</div>
<div class="wrapper">
    <div class="header">
        <div class="navbar">
            <nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
                <div class="container">
                    <div class="navbar-header">
                        <button
                                type="button"
                                class="navbar-toggle collapsed"
                                data-toggle="collapse"
                                data-target="#bs-example-navbar-collapse-1"
                        >
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a
                                class="navbar-brand"
                                href="/eProject-32smiles"
                        >
                            <div class="logo-brand">
                                <img src="../img/img-page/logo.png" alt=""/></div
                            >
                        </a>
                    </div>
                    <div
                            class="collapse navbar-collapse"
                            id="bs-example-navbar-collapse-1"
                    >
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="/eProject-32smiles">HOME</a></li>
                            <li><a href="/professional-education">PROFESSIONAL EDUCATION</a></li>
                            <li><a href="/patient-education">PATIENT EDUCATION</a></li>
                            <li><a href="/research">RESEARCH</a></li>
                            <li><a href="/product">PRODUCTS</a></li>
                            <li><a href="/contact-us">CONTACT US</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button
                            type="button"
                            class="navbar-toggle collapsed"
                            data-toggle="collapse"
                            data-target="#bs-example-navbar-collapse-1"
                    >
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a
                            class="navbar-brand"
                            href="../../eProject-32smiles"
                    >
                        <div class="logo-brand">
                            <img src="../img/img-page/logo.png" alt=""/></div
                        >
                    </a>
                </div>
                <div
                        class="collapse navbar-collapse"
                        id="bs-example-navbar-collapse-1"
                >
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
                <h1>Product</h1>
                <div class="page-map">
                    <p>Home &nbsp;/&nbsp; Product</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="main">
    <div class="section">
        <div class="row">
            <div class="col-md-6">
                <img src="<?= convertImagePath($row['media_path']) ?>" alt="Image" style="width: 100%">
            </div>
            <div class="col-md-6">
                <h2><?= $row['product_name']?></h2>
                <div class="content_product">
                    <h5>Category:</h5>
                    <p><?= $row['category_name'] ?></p>
                    <h5>Description:</h5>
                    <p><?= $row['product_description'] ?></p>
                    <h4>Price: <?= $row['product_price'] ?></h4>
                    <button class="btn btn-danger" style="width: 100%">CONTACT</button>
                </div>
            </div>
        </div>
        <a href="../product" class="btn btn-primary btn-back-product">Back</a>
    </div>
    <div class="section">
        <h1>Other Product</h1>
        <div class="row">
            <?php $count = 0; foreach($productShows as $row) { $count++;?>
                <a href="show-detail.php?id=<?= $row['product_id']?>">
                    <div class="col-sm-3 col-md-3 card-col">
                        <div class="card">
                            <img src="<?= convertImagePath($row['media_path']) ?>" alt="Image" style="width:100%">
                            <div class="box-card">
                                <h4><b><?= $row['product_name'] ?></b></h4>
                                <h6>Price</h6>
                                <p><?= $row['product_price'] ?></p>
                            </div>
                        </div>
                    </div>
                </a>
                <?php if($count == 4){break;} } ?>
        </div>
    </div>

</div>

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
<script src="https://code.jquery.com/jquery-1.11.1.js"></script>
<script src='../js/jquery.min.js'></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/loader.js"></script>
<script src="../js/top.js"></script>
<script src="../js/navbar.js"></script>
<script src="../js/jquery.waypoints.min.js"></script>

</body>
</html>