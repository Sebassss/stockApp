<?php

echo $_SESSION['userCredentials']['USUARIO_ID'];
//unset($_SESSION['userCredentials']);
//session_destroy();

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

    <style>
        @import "//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css";
        @import "http://fonts.googleapis.com/css?family=Roboto:400,500";

        .box > .icon { text-align: center; position: relative; }
        .box > .icon > .image { position: relative; z-index: 2; margin: auto; width: 88px; height: 88px; border: 8px solid white; line-height: 88px; border-radius: 50%; background: #63B76C; vertical-align: middle; }
        .box > .icon:hover > .image { background: #333; }
        .box > .icon > .image > i { font-size: 36px !important; color: #fff !important; }
        .box > .icon:hover > .image > i { color: white !important; }
        .box > .icon > .info { margin-top: -24px; background: rgba(0, 0, 0, 0.04); border: 1px solid #e0e0e0; padding: 15px 0 10px 0; }
        .box > .icon:hover > .info { background: rgba(0, 0, 0, 0.04); border-color: #e0e0e0; color: white; }
        .box > .icon > .info > h3.title { font-family: "Roboto",sans-serif !important; font-size: 16px; color: #222; font-weight: 500; }
        .box > .icon > .info > p { font-family: "Roboto",sans-serif !important; font-size: 13px; color: #666; line-height: 1.5em; margin: 20px;}
        .box > .icon:hover > .info > h3.title, .box > .icon:hover > .info > p, .box > .icon:hover > .info > .more > a { color: #222; }
        .box > .icon > .info > .more a { font-family: "Roboto",sans-serif !important; font-size: 12px; color: #222; line-height: 12px; text-transform: uppercase; text-decoration: none; }
        .box > .icon:hover > .info > .more > a { color: #fff; padding: 6px 8px; background-color: #63B76C; }
        .box .space { height: 30px; }

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
<body>


<div class="container">

    <div class="row">

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
                        <a class="navbar-brand" href="#">Brand</a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
                            <li><a href="#">Link</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="#">Separated link</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="#">One more separated link</a></li>
                                </ul>
                            </li>
                        </ul>
                        <form class="navbar-form navbar-left">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Search">
                            </div>
                            <button type="submit" class="btn btn-default">Submit</button>
                        </form>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="#">Link</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="#">Separated link</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>
        </header>
        <section>
            <div class="breadcrumb">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi eaque eius esse et in ipsam laboriosam laudantium, nemo numquam optio repellat tempore. At, commodi dolor harum hic id ratione sapiente.</p>
            </div>
            <h1>Section</h1>
            <div class="row">
                <!-- Boxes de Acoes -->
                <div class="col-xs-12 col-sm-6 col-lg-4">
                    <div class="box">
                        <div class="icon">
                            <div class="image"><i class="fa fa-thumbs-o-up"></i></div>
                            <div class="info">
                                <h3 class="title">Made with Bootstrap</h3>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed in lobortis nisl, vitae iaculis sapien. Phasellus ultrices gravida massa luctus ornare. Suspendisse blandit quam elit, eu imperdiet neque semper.
                                </p>
                                <div class="more">
                                    <a href="#" title="Title Link">
                                        Read More <i class="fa fa-angle-double-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="space"></div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6 col-lg-4">
                    <div class="box">
                        <div class="icon">
                            <div class="image"><i class="fa fa-flag"></i></div>
                            <div class="info">
                                <h3 class="title">Icons by Font Awesome</h3>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed in lobortis nisl, vitae iaculis sapien. Phasellus ultrices gravida massa luctus ornare. Suspendisse blandit quam elit, eu imperdiet neque semper.
                                </p>
                                <div class="more">
                                    <a href="#" title="Title Link">
                                        Read More <i class="fa fa-angle-double-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="space"></div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6 col-lg-4">
                    <div class="box">
                        <div class="icon">
                            <div class="image"><i class="fa fa-desktop"></i></div>
                            <div class="info">
                                <h3 class="title">Desktop Friendly</h3>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed in lobortis nisl, vitae iaculis sapien. Phasellus ultrices gravida massa luctus ornare. Suspendisse blandit quam elit, eu imperdiet neque semper.
                                </p>
                                <div class="more">
                                    <a href="#" title="Title Link">
                                        Read More <i class="fa fa-angle-double-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="space"></div>
                    </div>
                </div>
                <!-- /Boxes de Acoes -->
            </div>
        </section>
        <footer class="navbar-default navbar-fixed-bottom text-center">
            <div class="container-fluid">
                <span >Sistema de control de stock 2017 - MSP San Juan - Argentina</span>
            </div>
        </footer>

    </div>
</div>
<script src="framework/js/jquery-2.2.3.min.js"></script>
<script src="framework/js/bootstrap.min.js"></script>
</body>
</html>