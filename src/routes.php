<?php
// Routes

//$app->get('/[{name}]', function ($request, $response, $args) {
//    // Sample log message
//    $this->logger->info("Slim-Skeleton '/' route");
//
//    // Render index view
//    return $this->renderer->render($response, 'login/login.php', $args);
//});

//NOTES
//HTTP Verb	CRUD	Entire Collection (e.g. /customers)	Specific Item (e.g. /customers/{id})
//POST	Create	201 (Created), 'Location' header with link to /customers/{id} containing new ID.	404 (Not Found), 409 (Conflict) if resource already exists..
//GET	Read	200 (OK), list of customers. Use pagination, sorting and filtering to navigate big lists.	200 (OK), single customer. 404 (Not Found), if ID not found or invalid.
//PUT	Update/Replace	404 (Not Found), unless you want to update/replace every resource in the entire collection.	200 (OK) or 204 (No Content). 404 (Not Found), if ID not found or invalid.
//PATCH	Update/Modify	404 (Not Found), unless you want to modify the collection itself.	200 (OK) or 204 (No Content). 404 (Not Found), if ID not found or invalid.
//DELETE	Delete	404 (Not Found), unless you want to delete the whole collection—not often desirable.	200 (OK). 404 (Not Found), if ID not found or invalid.


//PATH
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

/*USUARIOS*/
    //OBTENGO DATOS DE USUARIOS
    $app->post('/abm_getUsuarios', function($req, $res) use($app){
        require_once "../app/controllers/abm_getUsuariosController.php";
        return getDatos();
    });

    //VISTA USUARIOS
    $app->get('/abm_usuarios', function($req, $res) use($app){
        return $this->renderer->render($res, 'usuarios/abm.usuarios.php');
    });


/*RUBROS*/
    //OBTENGO RUBROS
    $app->get('/abm_getRubros', function($req, $res) use($app){
        require_once "../app/controllers/abm_getRubrosController.php";
        return getDatos();
    });

    //GUARDA RUBROS
    $app->post('/abm_getRubros', function($req, $res) use($app){
        require_once "../app/controllers/abm_getRubrosController.php";
        return saveDatos();
    });

    //BORRA RUBROS
    $app->delete('/abm_getRubros', function($req, $res) use($app){
        require_once "../app/controllers/abm_getRubrosController.php";
        return deleteDatos();
    });

    //BORRA RUBROS
    $app->put('/abm_getRubros', function($req, $res) use($app){
        require_once "../app/controllers/abm_getRubrosController.php";
        return editDatos();
    });

    //VISTA RUBROS
    $app->get('/abm_rubros', function($req, $res) use($app){
        return $this->renderer->render($res, 'rubros/abm.rubros.php');
    });

/*FIN RUBROS*/

/*MARCAS*/
//OBTENGO MARCAS
$app->get('/abm_getMarcas', function($req, $res) use($app){
    require_once "../app/controllers/abm_getMarcasController.php";
    return getDatos();
});

//GUARDA MARCAS
$app->post('/abm_getMarcas', function($req, $res) use($app){
    require_once "../app/controllers/abm_getMarcasController.php";
    return saveDatos();
});

//BORRA MARCAS
$app->delete('/abm_getMarcas', function($req, $res) use($app){
    require_once "../app/controllers/abm_getMarcasController.php";
    return deleteDatos();
});

//BORRA MARCAS
$app->put('/abm_getMarcas', function($req, $res) use($app){
    require_once "../app/controllers/abm_getMarcasController.php";
    return editDatos();
});

//OBTIENE MARCAS RUBROS - DROPDOWN
$app->get('/abm_getMarcasRubros', function($req, $res) use($app){
    require_once "../app/controllers/abm_getMarcasController.php";
    return getRubros();
});

//VISTA MARCAS
$app->get('/abm_marcas', function($req, $res) use($app){
    return $this->renderer->render($res, 'marcas/abm.marcas.php');
});

/*FIN MARCAS*/

/*METODO LOGIN*/
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

/*METODO SYSTEM*/
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

/*CHEQUEO DE USUARIO EXISTENTE*/
    $app->get('/checkUserCredentials', function($req, $res) use($app){
        require_once "../app/controllers/checkUserCredentials.php";
        return checkUsuario();

    });
