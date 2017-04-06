<?php
// Routes

//$app->get('/[{name}]', function ($request, $response, $args) {
//    // Sample log message
//    $this->logger->info("Slim-Skeleton '/' route");
//
//    // Render index view
//    return $this->renderer->render($response, 'login/login.php', $args);
//});


//engancha todos
$app->any('/', function($req, $res, $args) use($app) {

    if(isset($_SESSION['user']->id))
    {
        //return $this->renderer->render($res, 'aindex.php');
        return $this->renderer->render($response, 'login/login.php', $args);
    }
    else
    {
        return $res->withStatus(302)->withHeader('Location','login');
    }

});

//login
$app->get('/login', function($req, $res) use($app)
{
    return $this->renderer->render($res, 'login/login.php');
});


//Check login user
$app->post('/checkUserCredentials', function($req, $res) use($app){

    //print_r($_POST);
    require_once "../app/controllers/checkUserCredentials.php";
    return checkUsuario();

});
