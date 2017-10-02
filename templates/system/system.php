<?php

require_once "../app/data/class.conexion.php";
require_once "../app/data/class.generamenu.php";

if(!isset($_SESSION['menu'])) {
    $_SESSION['menu'] = '';
}

/**
 * Created by PhpStorm.
 * User: Calopsia
 * Date: 06/04/2017
 * Time: 18:49
 */
?>

<!DOCTYPE html>
<html>
<head>


    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Stock MSP  - Control de Stock| Acceso seguro</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="framework/css/bootstrap.min.css">
    <link rel="stylesheet" href="framework/css/ls.css">
    <link rel="stylesheet" type="text/css" href="framework/plugins/scrolltotop/material-scrolltop.css">
    <style>

        @import "framework/css/font-awesome.min.css";
        /*@import "http://fonts.googleapis.com/css?family=Roboto:400,500";*/

        /***********************************************/
        /* cyrillic-ext */
        @font-face {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 400;
            src: local('Roboto'), local('Roboto-Regular'), url(framework/fonts/Roboto-Regular.ttf) format('ttf');
            unicode-range: U+0460-052F, U+20B4, U+2DE0-2DFF, U+A640-A69F;
        }
        /* cyrillic */
        @font-face {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 400;
            src: local('Roboto'), local('Roboto-Regular'), url(http://fonts.gstatic.com/s/roboto/v16/mErvLBYg_cXG3rLvUsKT_fesZW2xOQ-xsNqO47m55DA.woff2) format('woff2');
            unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }
        /* greek-ext */
        @font-face {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 400;
            src: local('Roboto'), local('Roboto-Regular'), url(http://fonts.gstatic.com/s/roboto/v16/-2n2p-_Y08sg57CNWQfKNvesZW2xOQ-xsNqO47m55DA.woff2) format('woff2');
            unicode-range: U+1F00-1FFF;
        }
        /* greek */
        @font-face {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 400;
            src: local('Roboto'), local('Roboto-Regular'), url(http://fonts.gstatic.com/s/roboto/v16/u0TOpm082MNkS5K0Q4rhqvesZW2xOQ-xsNqO47m55DA.woff2) format('woff2');
            unicode-range: U+0370-03FF;
        }
        /* vietnamese */
        @font-face {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 400;
            src: local('Roboto'), local('Roboto-Regular'), url(http://fonts.gstatic.com/s/roboto/v16/NdF9MtnOpLzo-noMoG0miPesZW2xOQ-xsNqO47m55DA.woff2) format('woff2');
            unicode-range: U+0102-0103, U+1EA0-1EF9, U+20AB;
        }
        /* latin-ext */
        @font-face {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 400;
            src: local('Roboto'), local('Roboto-Regular'), url(http://fonts.gstatic.com/s/roboto/v16/Fcx7Wwv8OzT71A3E1XOAjvesZW2xOQ-xsNqO47m55DA.woff2) format('woff2');
            unicode-range: U+0100-024F, U+1E00-1EFF, U+20A0-20AB, U+20AD-20CF, U+2C60-2C7F, U+A720-A7FF;
        }
        /* latin */
        @font-face {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 400;
            src: local('Roboto'), local('Roboto-Regular'), url(http://fonts.gstatic.com/s/roboto/v16/CWB0XYA8bzo0kSThX0UTuA.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2212, U+2215;
        }
        /* cyrillic-ext */
        @font-face {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 500;
            src: local('Roboto Medium'), local('Roboto-Medium'), url(http://fonts.gstatic.com/s/roboto/v16/ZLqKeelYbATG60EpZBSDyxJtnKITppOI_IvcXXDNrsc.woff2) format('woff2');
            unicode-range: U+0460-052F, U+20B4, U+2DE0-2DFF, U+A640-A69F;
        }
        /* cyrillic */
        @font-face {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 500;
            src: local('Roboto Medium'), local('Roboto-Medium'), url(http://fonts.gstatic.com/s/roboto/v16/oHi30kwQWvpCWqAhzHcCSBJtnKITppOI_IvcXXDNrsc.woff2) format('woff2');
            unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }
        /* greek-ext */
        @font-face {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 500;
            src: local('Roboto Medium'), local('Roboto-Medium'), url(http://fonts.gstatic.com/s/roboto/v16/rGvHdJnr2l75qb0YND9NyBJtnKITppOI_IvcXXDNrsc.woff2) format('woff2');
            unicode-range: U+1F00-1FFF;
        }
        /* greek */
        @font-face {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 500;
            src: local('Roboto Medium'), local('Roboto-Medium'), url(http://fonts.gstatic.com/s/roboto/v16/mx9Uck6uB63VIKFYnEMXrRJtnKITppOI_IvcXXDNrsc.woff2) format('woff2');
            unicode-range: U+0370-03FF;
        }
        /* vietnamese */
        @font-face {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 500;
            src: local('Roboto Medium'), local('Roboto-Medium'), url(http://fonts.gstatic.com/s/roboto/v16/mbmhprMH69Zi6eEPBYVFhRJtnKITppOI_IvcXXDNrsc.woff2) format('woff2');
            unicode-range: U+0102-0103, U+1EA0-1EF9, U+20AB;
        }
        /* latin-ext */
        @font-face {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 500;
            src: local('Roboto Medium'), local('Roboto-Medium'), url(http://fonts.gstatic.com/s/roboto/v16/oOeFwZNlrTefzLYmlVV1UBJtnKITppOI_IvcXXDNrsc.woff2) format('woff2');
            unicode-range: U+0100-024F, U+1E00-1EFF, U+20A0-20AB, U+20AD-20CF, U+2C60-2C7F, U+A720-A7FF;
        }
        /* latin */
        @font-face {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 500;
            src: url("framework/fonts/Roboto-Medium.ttf");
        }
        /***********************************************/

        @media (min-width: 767px) {
            .navbar-nav .dropdown-menu .caret {
                transform: rotate(-90deg);
            }
        }

        body .modal {
            /* new custom width */
            width: 50%;
            /* must be half of the width, minus scrollbar on the left (30px) */
            margin: 0 auto;
            overflow-y: auto;
        }




        .box > .icon { text-align: center; position: relative; }
        .box > .icon > .image { position: relative; z-index: 2; margin: auto; width: 88px; height: 88px; border: 8px solid white; line-height: 88px; border-radius: 50%; background: #63B76C; vertical-align: middle; }
        .box > .icon:hover > .image { background: #333; }
        .box > .icon > .image > i { font-size: 36px !important; color: #333 !important; }
        .box > .icon:hover > .image > i { color: white !important; }
        .box > .icon > .info { margin-top: -24px; background: rgb(27, 225, 234); border: 1px solid #e0e0e0; padding: 15px 0 10px 0; border-radius: 30px; }
        .box > .icon:hover > .info { background: rgb(27, 225, 234); border-color: #e0e0e0; color: #333; border-radius: 30px; }
        .box > .icon > .info > h3.title { font-family: "Roboto",sans-serif !important; font-size: 16px; color: #222; font-weight: 500; }
        .box > .icon > .info > p { font-family: "Roboto",sans-serif !important; font-size: 13px; color: #666; line-height: 1.5em; margin: 20px;}
        .box > .icon:hover > .info > h3.title, .box > .icon:hover > .info > p, .box > .icon:hover > .info > .more > a { color: #222; }
        .box > .icon > .info > .more a { font-family: "Roboto",sans-serif !important; font-size: 12px; color: #222; line-height: 12px; text-transform: uppercase; text-decoration: none; }
        .box > .icon:hover > .info > .more > a { color: #fff; padding: 6px 8px; background-color: rgb(27, 225, 234); }
        .box .space { height: 30px; }

        .navbar-fixed-bottom
        {
            position: relative;
        }


        footer.navbar-default.navbar-fixed-bottom
        {

            background:#e7e7e7;
            color:black;
            padding:1em 0;
        }
        footer.navbar-default.navbar-fixed-bottom p
        {
            margin:0;
        }
    </style>
</head>
<body class="body" onload="javascript:loadPage('<?php echo $_SESSION['menu']; ?>');">


<div class="container">

    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#"><b>STOCK MSP</b></a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                <?php
                $menu = new Menu();
                $menu->display_children(0,1,$_SESSION['userCredentials']['usuario_id']);
                ?>
                </ul>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->

            </div><!-- /.container-fluid -->
        </nav>
    </header>

    <div class="breadcrumb">
        <p>PIOR es nada.</p>
    </div>


<!--    <div class="row">-->
<!---->
<!--                <div class="col-12 col-md-12">-->
<!--                    <h1>Section</h1>-->
<!--                        <div class="row">-->
<!--                <!-- Boxes de Acoes -->
<!--                <div class="col-xs-12 col-sm-6 col-lg-4">-->
<!--                    <div class="box">-->
<!--                        <div class="icon">-->
<!--                            <div class="image"><i class="fa fa-thumbs-o-up"></i></div>-->
<!--                            <div class="info">-->
<!--                                <h3 class="title">Made with Bootstrap</h3>-->
<!--                                <p>-->
<!--                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed in lobortis nisl, vitae iaculis sapien. Phasellus ultrices gravida massa luctus ornare. Suspendisse blandit quam elit, eu imperdiet neque semper.-->
<!--                                </p>-->
<!--                                <div class="more">-->
<!--                                    <a href="#" title="Title Link">-->
<!--                                        Read More <i class="fa fa-angle-double-right"></i>-->
<!--                                    </a>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="space"></div>-->
<!--                    </div>-->
<!--                </div>-->
<!---->
<!--                <div class="col-xs-12 col-sm-6 col-lg-4">-->
<!--                    <div class="box">-->
<!--                        <div class="icon">-->
<!--                            <div class="image"><i class="fa fa-flag"></i></div>-->
<!--                            <div class="info">-->
<!--                                <h3 class="title">Icons by Font Awesome</h3>-->
<!--                                <p>-->
<!--                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed in lobortis nisl, vitae iaculis sapien. Phasellus ultrices gravida massa luctus ornare. Suspendisse blandit quam elit, eu imperdiet neque semper.-->
<!--                                </p>-->
<!--                                <div class="more">-->
<!--                                    <a href="#" title="Title Link">-->
<!--                                        Read More <i class="fa fa-angle-double-right"></i>-->
<!--                                    </a>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="space"></div>-->
<!--                    </div>-->
<!--                </div>-->
<!---->
<!--                <div class="col-xs-12 col-sm-6 col-lg-4">-->
<!--                    <div class="box">-->
<!--                        <div class="icon">-->
<!--                            <div class="image"><i class="fa fa-desktop"></i></div>-->
<!--                            <div class="info">-->
<!--                                <h3 class="title">Desktop Friendly</h3>-->
<!--                                <p>-->
<!--                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed in lobortis nisl, vitae iaculis sapien. Phasellus ultrices gravida massa luctus ornare. Suspendisse blandit quam elit, eu imperdiet neque semper.-->
<!--                                </p>-->
<!--                                <div class="more">-->
<!--                                    <a href="#" title="Title Link">-->
<!--                                        Read More <i class="fa fa-angle-double-right"></i>-->
<!--                                    </a>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="space"></div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <!-- /Boxes de Acoes -->
<!--            </div>-->
<!--                </div>-->
<!---->
<!--    </div>-->

    <?php require_once "info.php" ;?>





</div>

<div class="container">
    <div class="col-12 col-md-12" id="main">
        <div class="row">
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="col-12 col-md-12" id="main">
        <div class="row">
        <footer class="navbar-default navbar-fixed-bottom text-center">
            <div class="container-fluid">
                <span >Sistema de control de stock 2017 - MSP San Juan - Argentina</span>
            </div>
        </footer>
            </div>
        </div>
</div>
<button class="material-scrolltop" type="button"></button>




<script src="framework/js/jquery-2.2.3.min.js"></script>
<script src="framework/js/bootstrap.min.js"></script>
<script src="framework/plugins/scrolltotop/material-scrolltop.js"></script>
<script src="core/Grid/Grid.js"></script>
<script src="core/js/functions.js"></script>

<script>
    $(document).ready(function() {
        $('body').materialScrollTop({
            revealElement: 'header',
            revealPosition: 'bottom',
            onScrollEnd: function() {
                console.log('Scrolling End');
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('.navbar a.dropdown-toggle').on('click', function(e) {
            var $el = $(this);
            var $parent = $(this).offsetParent(".dropdown-menu");
            $(this).parent("li").toggleClass('open');

            if(!$parent.parent().hasClass('nav')) {
                $el.next().css({"top": $el[0].offsetTop, "left": $parent.outerWidth() - 4});
            }

            $('.nav li.open').not($(this).parents("li")).removeClass("open");

            return false;
        });
    });

</script>
</body>
</html>