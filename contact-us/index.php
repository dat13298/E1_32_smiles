<?php
require_once("../function.php");
init_connection();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = $_POST['name'];
    $title = $_POST['title'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];
    $isValid = validateFormContact($name, $title, $email, $phone, $message);
    if($isValid){
        addContactUs($name, $title, $email, $phone, $message);

    } else {
        echo "fail to submit";
    }
}
?>
<!DOCTYPE html>
<html lang="en-US" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Contact Us</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Quickdev">
    <link rel="shortcut icon" href="../img/img-page/favicon.png">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../fonts/font-awesome/css/font-awesome.min.css">
    <script>
        (g => {
            let h, a, k, p = "The Google Maps JavaScript API",
                c = "google",
                l = "importLibrary",
                q = "__ib__",
                m = document,
                b = window;
            b = b[c] || (b[c] = {});
            const d = b.maps || (b.maps = {}),
                r = new Set,
                e = new URLSearchParams,
                u = () => h || (h = new Promise(async (f, n) => {
                    await (a = m.createElement("script"));
                    e.set("libraries", [...r] + "");
                    for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]);
                    e.set("callback", c + ".maps." + q);
                    e.set("language", "en");
                    a.src = `https://maps.${c}apis.com/maps/api/js?` + e;
                    d[q] = f;
                    a.onerror = () => h = n(Error(p + " could not load."));
                    a.nonce = m.querySelector("script[nonce]")?.nonce || "";
                    m.head.append(a)
                }));
            d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(() => d[l](f, ...n))
        })
        ({
            key: "AIzaSyAcb1A6etySgule0S22FQwHS8ZT9Jrv6Po",
            v: "weekly"
        });
    </script>
</head>
<body onload="initMap()">
<div id="loader-wrapper">
    <div id="loader"></div>
</div>
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
                    <h1>Contact Us</h1>
                    <div class="page-map">
                        <p>Home &nbsp;/&nbsp; Contact Us</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main">
        <div class="section">
            <div class="section-title">
                <h2>GET IN TOUCH</h2>
                <hr class="center">
                <p>Reputable dental clinics.</p>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="sidebar">
                        <div class="address-box">
                            <div class="icon-circle"><i class="fa fa-map-marker" aria-hidden="true"></i></div>
                            <div class="address-info">
                                <h6>Address</h6>
                                <p>1415 Woodlawn Ave. Buffalo New York, USA 10451.</p>
                            </div>
                        </div>
                        <div class="address-box">
                            <div class="icon-circle"><i class="fa fa-phone" aria-hidden="true"></i></div>
                            <div class="address-info">
                                <h6>Phone</h6>
                                <p>212-869-3323</p>
                            </div>
                        </div>
                        <div class="address-box">
                            <div class="icon-circle"><i class="fa fa-envelope" aria-hidden="true"></i></div>
                            <div class="address-info">
                                <h6>Email</h6>
                                <p>info@dentalcare.com</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <form method="post" onsubmit="return validateFormContact()">
                        <div class="messages"></div>
                        <div class="controls">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input id="form_name" type="text" name="name" class="form-control customize" placeholder="Name" required="required" data-error="Firstname is required.">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input id="form_title" type="text" name="title" class="form-control customize" placeholder="Title" required="required" data-error="Title is required.">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input id="form_email" type="email" name="email" class="form-control customize" placeholder="Email address" required="required" data-error="Valid email is required.">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input id="form_phone" type="tel" name="phone" class="form-control customize" placeholder="Please enter your phone">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea id="form_message" name="message" class="form-control customize" placeholder="Your message" rows="6" required="required" data-error="Please,leave us a message."></textarea>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <p><input type="submit" class="btn btn-primary" value="Send message"></p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="main">
        <div class="section">
            <div class="section-title">
                <h2>CLINIC</h2>
                <hr class="center">
                <p>The list of dentists we recommend for you.</p>
            </div>
            <div class="row" id="data-list"></div>
            <ul class="pagination" id="pagination"></ul>
            <script>
                let map;
                async function initMap() {
                    const position = {
                        lat: -25.344,
                        lng: 131.031
                    };
                    const {
                        Map
                    } = await google.maps.importLibrary("maps");
                    const {
                        AdvancedMarkerElement
                    } = await google.maps.importLibrary("marker");
                    map = new google.maps.Map(document.getElementById("map"), {
                        zoom: 4,
                        center: position,
                        mapId: "MAP-32SMILES-ID",
                    });
                }

                function showLocation(address) {
                    const geocoder = new google.maps.Geocoder();
                    geocoder.geocode({
                        'address': address
                    }, function(results, status) {
                        if (status === 'OK') {
                            map.setCenter(results[0].geometry.location);
                            const advancedMarker = new google.maps.marker.AdvancedMarkerElement({
                                map: map,
                                position: results[0].geometry.location
                            });
                            map.setZoom(15);
                        } else {
                            alert('Geocode was not successful for the following reason: ' + status);
                        }
                    });
                }
            </script>
            <div id="maps">
                <div id="map"></div>
            </div>
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
<script src="../js/bootstrap.min.js"></script>
<script src="../js/loader.js"></script>
<script src="../js/top.js"></script>
<script src="../js/navbar.js"></script>
<script src="../js/function.js"></script>
</body>
</html>