<?php
require '../app/data/class.user.php';
require_once "../app/data/db.inc.php";
require_once "../app/data/class.conexion.php";

//login
$app->get('/login', function($req, $res) use($app){

    return $this->renderer->render($res, 'login.php');
});

// intenta acceso 1 es permitido 0 es no encontrado
$app->post('/trylogin/{usr}/{pass}', function( $req,  $response) use($app){


    $user = $req->getAttribute('usr');
    $password = $req->getAttribute('pass');
    $db = new MySQL();


    $result = $db->consulta("SELECT UsuarioID FROM Tbl_Usuarios WHERE Email = '".$user."' AND Password = '".$password."' LIMIT 1");
    $id = new stdClass();

    if($db->num_rows($result)>0) {

        $row = $db->fetch_array($result);

        $id = $row['UsuarioID'];

        $_SESSION['id'] = $id;

    }else{

        $id = 0;
    }

    return $id;

});