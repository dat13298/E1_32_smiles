<?php
require_once "../function.php";
init_connection();
$posts = getAllPostResearch();
?>
<!DOCTYPE html>
<html lang="en-US" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Research</title>
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
                    <h1>Research</h1>
                    <div class="page-map"><p>Home &nbsp;/&nbsp; Research</p></div>
                </div>
            </div>
        </div>
    </div>
    <!-- MEDIA LIBRARY -->
    <div class="main">
        <div class="section">
            <div class="section-title">
                <h2>REASEARCH FIELD</h2>
                <hr class="center">
                <p> Welcome to our Research page – the hub of innovation and discovery in dental and oral health. Here,
                    we're committed to bringing you the cutting-edge of dental science and the latest advancements from
                    the field. Our research corner features a curated selection of scholarly articles, comprehensive
                    case studies, and insightful documentaries that delve deep into the newest findings and
                    methodologies. Whether you're a healthcare professional seeking to expand your knowledge, a student
                    on the quest for academic excellence, or simply an enthusiast eager to learn about the latest trends
                    in dental care, our repository is a treasure trove of valuable information. Dive into our vast
                    library of resources and let's forge the path to a healthier future together.</p>
            </div>
            <div class="section-title">
                <h2>MEDIA LIBRARY</h2>
                <hr class="center">
            </div>
            <div class="row">
                <?php foreach ($posts as $post):
                    if ($post['category_id'] == 9):
                        $post_id = $post['post_id'];
                        $media = getMediaByPostID($post_id);
                        if ($media['media_type'] == 'video'): ?>
                            <div class="col-sm-6 col-md-4">
                                <div class="post-news">
                                    <a href="media-library.php?post_id=<?php echo $post_id ?>">
                                        <video style="width: 368px; height:200px;" muted loop autoplay>
                                            <source src="<?php echo convertImagePath($media['media_path']) ?>"
                                                    type="video/mp4">
                                        </video>
                                        <div class="caption">
                                            <h5><?php echo mb_substr($post['post_title'], 0, 22) . '...'; ?></h5>
                                            <p><?php echo mb_substr($post['post_content'], 0, 100) . '...'; ?></p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="col-sm-6 col-md-4">
                                <div class="post-news">
                                    <a href="media-library.php?post_id=<?php echo $post_id ?>"><img
                                                src="<?php echo convertImagePath($media['media_path']); ?>" alt="..."
                                                style="width: 368px; height:200px;">
                                        <div class="caption">
                                            <h5><?php echo $post['post_title'] ?></h5>
                                            <p><?php echo mb_substr($post['post_content'], 0, 100) . '...'; ?></p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <!-- LATEST RESEARCH -->
    <div class="main">
        <div class="section">
            <div class="section-title">
                <h2>LATEST RESEARCH</h2>
                <hr class="center">
            </div>
            <div class="row">
                <?php foreach ($posts as $post):
                    if ($post['category_id'] == 8):
                        $post_id = $post['post_id'];
                        $media = getMediaByPostID($post_id);
                        // Kiểm tra nếu media là video hoặc ảnh để xử lý tương ứng
                        if ($media['media_type'] == 'video'): ?>
                            <div class="col-sm-6 col-md-4">
                                <div class="post-news">
                                    <a href="latest-research.php?post_id=<?php echo $post_id ?>">
                                        <video style="width: 368px; height:200px;" muted loop autoplay>
                                            <source src="<?php echo convertImagePath($media['media_path']) ?>"
                                                    type="video/mp4">
                                        </video>
                                        <div class="caption">
                                            <h5><?php echo mb_substr($post['post_title'], 0, 22) . '...'; ?></h5>
                                            <p><?php echo mb_substr($post['post_content'], 0, 100) . '...'; ?></p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="col-sm-6 col-md-4">
                                <div class="post-news">
                                    <a href="latest-research.php?post_id=<?php echo $post_id ?>"><img
                                                src="<?php echo convertImagePath($media['media_path']); ?>" alt="..."
                                                style="width: 368px; height:200px;">
                                        <div class="caption">
                                            <h5><?php echo mb_substr($post['post_title'], 0, 22) . '...' ?></h5>
                                            <p><?php echo mb_substr($post['post_content'], 0, 100) . '...'; ?></p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
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
<script src="https://code.jquery.com/jquery-1.11.1.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/loader.js"></script>
<script src="../js/top.js"></script>
<script src="../js/navbar.js"></script>
<script src="../js/jquery.waypoints.min.js"></script>
</body>
</html>