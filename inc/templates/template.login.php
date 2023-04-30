<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta id="viewport" name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="copyright" content="© 2022 [%author%]" />
    <meta name="robots" content="all" />
    <meta name="robots" content="max-image-preview:standard" />
    <meta name="revisit-after" content="7 days" />
    <meta name="description" content="[%description%]">
    <meta name="author" content="[%author%]">
    <meta name="theme-color" />
    <meta name="msapplication-navbutton-color" />
    <meta name="msapplication-TileColor" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="msapplication-TileImage" content="[%icon%]">
    
    <link rel="stylesheet" type="text/css" href="./app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="./app-assets/css/bootstrap-extended.min.css">
    <link rel="stylesheet" type="text/css" href="./app-assets/css/app.css">
    <link rel="stylesheet" type="text/css" href="./app-assets/css/pages/authentication.css">

    <link rel="stylesheet" type="text/css" href="./app-assets/css/components.css">

    <link rel="stylesheet" type="text/css" href="./app-assets/css/themes/dark-layout.css">
    
    <link rel="icon" href="[%icon%]" sizes="32x32">
    <link rel="apple-touch-icon" href="[%icon%]">
    
    <title>[%title%]</title>
    [%css%]
</head>

<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static loginPage" data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">
    <!-- Login Content -->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="auth-wrapper auth-basic px-2">
                    <div class="auth-inner my-2">
                        <div class='card mb-0' data-aos="zoom-in" data-aos-easing="linear" data-aos-duration="500">
                            <div class='card-body'>
                                <img src="./app-assets/images/logo.png" class="card-img-top" alt="Logo [%title%]" title="[%title%]">
                                [%include_content%]
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Login Content -->
    <script src="./app-assets/vendors/js/vendors.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./app-assets/js/app.js"></script>

    [%js%]
    [%sweetalert%]
</body>

</html>