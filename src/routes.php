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

    if(isset($_SESSION['userCredentials']['usuario_id']))
    {
        return $res->withStatus(302)->withHeader('Location', 'system');
    }
    else
    {
        return $res->withStatus(302)->withHeader('Location','login');
    }

});


//Rellena la grilla
$app->post('/abm_getUsuarios', function($req, $res) use($app){

    require_once "../app/controllers/abm_getUsuariosController.php";

    return getDatos();
});
//ABM usuarios (retorna vista)
$app->get('/abm_usuarios', function($req, $res) use($app){

    return $this->renderer->render($res, 'usuarios/abm.usuarios.php');
});


//login
$app->get('/login', function($req, $res) use($app)
{
    if(isset($_SESSION['userCredentials']['usuario_id']))
    {
        return $res->withStatus(302)->withHeader('Location', 'system');
    }
    else {
        return $this->renderer->render($res, 'login/login.php');
    }
});

$app->get('/system', function($req, $res) use($app)
{
    if(isset($_SESSION['userCredentials']['usuario_id']))
    {
        return $this->renderer->render($res, 'system/system.php');
    }
    else {

        return $res->withStatus(302)->withHeader('Location', 'login');
    }
});

//Check login user
$app->get('/checkUserCredentials', function($req, $res) use($app){

    //print_r($_POST);
    require_once "../app/controllers/checkUserCredentials.php";
    return checkUsuario();

});
