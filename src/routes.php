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


$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', 'http://10.64.65.200')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

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
    $app->get('/abm_getUsuarios', function($req, $res) use($app){
        require_once "../app/controllers/abm_getUsuariosController.php";
        return getDatos();
    });

    //VISTA USUARIOS
    $app->get('/abm_usuarios', function($req, $res) use($app){
        return $this->renderer->render($res, 'usuarios/abm.usuarios.php');
    });


/*DEPOSITOS*/
//OBTENGO DEPOSITOS
$app->get('/abm_getDepositos', function($req, $res) use($app){
    require_once "../app/controllers/abm_getDepositosController.php";
    return getDatos();
});

//GUARDA DEPOSITOS
$app->post('/abm_getDepositos', function($req, $res) use($app){
    require_once "../app/controllers/abm_getDepositosController.php";
    return saveDatos();
});

//BORRA DEPOSITOS
$app->delete('/abm_getDepositos', function($req, $res) use($app){
    require_once "../app/controllers/abm_getDepositosController.php";
    return deleteDatos();
});

//EDITA DEPOSITOS
$app->put('/abm_getDepositos', function($req, $res) use($app){
    require_once "../app/controllers/abm_getDepositosController.php";
    return editDatos();
});

//VISTA DEPOSITOS
$app->get('/abm_depositos', function($req, $res) use($app){
    return $this->renderer->render($res, 'depositos/abm.depositos.php');
});

/*FIN DEPOSITOS*/

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

    //EDITA RUBROS
    $app->put('/abm_getRubros', function($req, $res) use($app){
        require_once "../app/controllers/abm_getRubrosController.php";
        return editDatos();
    });

    //VISTA RUBROS
    $app->get('/abm_rubros', function($req, $res) use($app){
        return $this->renderer->render($res, 'rubros/abm.rubros.php');
    });

/*FIN RUBROS*/


/*SALIDA DE STOCK*/
//VISTA SALIDA DE STOCK
    $app->get('/abm_salida', function($req, $res) use($app){
        return $this->renderer->render($res, 'salida_de_stock/abm.salida.php');
    });
/*FIN SALIDA DE STOCK*/

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

//CERRAR SESION
$app->get('/cerrar_sesion', function($req, $res) use($app){
    unset($_SESSION['userCredentials']);
    session_destroy();
    return $res->withStatus(302)->withHeader('Location', 'login');
});

/*CHEQUEO DE USUARIO EXISTENTE*/
    $app->get('/checkUserCredentials', function($req, $res) use($app){
        require_once "../app/controllers/checkUserCredentials.php";
        return checkUsuario();

    });


/*PROVEEDORES*/
//OBTENGO PROVEEDORES
    $app->get('/abm_getProveedores', function($req, $res) use($app){
        require_once "../app/controllers/abm_getProveedoresController.php";
        return getDatos();
    });

    //GUARDA PROVEEDORES
    $app->post('/abm_getProveedores', function($req, $res) use($app){
        require_once "../app/controllers/abm_getProveedoresController.php";
        return saveDatos();
    });

    //BORRA PROVEEDORES
    $app->delete('/abm_getProveedores', function($req, $res) use($app){
        require_once "../app/controllers/abm_getProveedoresController.php";
        return deleteDatos();
    });

    //EDITA PROVEEDORES
    $app->put('/abm_getProveedores', function($req, $res) use($app){
        require_once "../app/controllers/abm_getProveedoresController.php";
        return editDatos();
    });

    //VISTA PROVEEDORES
    $app->get('/abm_proveedores', function($req, $res) use($app){
        return $this->renderer->render($res, 'proveedores/abm.proveedores.php');
    });

    //VISTA MOVIMIENTOS
    $app->get('/abm_movimientos', function($req, $res) use($app){
        return $this->renderer->render($res, '../app/controllers/abm_getMovimientosController.php');
    });

/*FIN PROVEEDORES*/

/*MOVIMIENTOS*/
//OBTENGO MOVIMIENTOS
    $app->get('/abm_getMovimientos', function($req, $res) use($app){
        require_once "../app/controllers/abm_getMovimientosController.php";
        return getDatos();
    });


$app->get('/abm_getMovimientosInicial', function($req, $res) use($app){
    //require_once "../app/controllers/abm_getMovimientosController.php";
    include "../templates/system/info.php";
});


/*FIN MOVIMIENTOS*/

/*ARTICULOS*/
//OBTENGO ARTICULOS
    $app->get('/abm_getArticulos2', function($req, $res) use($app){
        require_once "../app/controllers/abm_getArticulosController.php";
        return getDatos();
    });

    $app->get('/abm_getArticulos', function($req, $res) use($app){
        require_once "../app/controllers/abm_getArticulosController.php";
        return getDatos2();
    });

    //DESCUENTA ARTICULOS
    $app->put('/abm_descArticulos', function($req, $res) use($app){
        require_once "../app/controllers/abm_getArticulosController.php";
        return descArticulos();
    });

    //GUARDA ARTICULOS
    $app->post('/abm_getArticulos', function($req, $res) use($app){
        require_once "../app/controllers/abm_getArticulosController.php";
        return saveDatos();
    });

    //BORRA ARTICULOS
    $app->delete('/abm_getArticulos', function($req, $res) use($app){
        require_once "../app/controllers/abm_getArticulosController.php";
        return deleteDatos();
    });

    //BORRA ARTICULOS
    $app->put('/abm_getArticulos', function($req, $res) use($app){
        require_once "../app/controllers/abm_getArticulosController.php";
        return editDatos();
    });

    //OBTIENE MARCAS RUBROS - DROPDOWN
    $app->get('/abm_getArticulosRubros', function($req, $res) use($app){
        require_once "../app/controllers/abm_getArticulosController.php";
        return getRubros();
    });

    //OBTIENE MARCAS RUBROS - DROPDOWN
    $app->get('/abm_getArticulosMarcas', function($req, $res) use($app){
        require_once "../app/controllers/abm_getArticulosController.php";
        return getMarcas();
    });

    //OBTIENE MARCAS RUBROS - DROPDOWN
    $app->get('/abm_getArticulosProveedor', function($req, $res) use($app){
        require_once "../app/controllers/abm_getArticulosController.php";
        return getProveedor();
    });

    //VISTA ARTICULOS
    $app->get('/abm_articulos', function($req, $res) use($app){
        return $this->renderer->render($res, 'articulos/abm.articulos.php');
    });

/*FIN ARTICULOS*/




/*GENERADOR DE CODIGO DE BARRAS*/

    //GENERACION DE CODIGO DE BARRAS
    $app->get('/cod_generacion/[{codigo}]', function($req, $res) use($app){
        require_once "../app/controllers/cod_generacion.php";
        $codigo = $req->getAttribute('codigo');

        return $this->renderer->render($res, 'barcode\make.barcode.php', array(
            'code'=>$codigo
        ));

    });


    //PRUEBA DE GENERACION DE CODIGO DE BARRAS
    $app->get('/testcode', function($req, $res) use($app){

        return $this->renderer->render($res, 'barcodetest\barcodehtml.php');
    });

    //BUSQUEDA DE CODIGO DE BARRAS
    $app->get('/cod_busqueda', function($req, $res) use($app){
        //require_once "../app/controllers/abm_getMovimientosController.php";
        //return getBarcode();
    });

/*FIN GENERADOR DE CODIGO DE BARRAS*/

/*STOCK*/
//OBTENGO ARTICULO POR CODIGO
$app->get('/getArticuloCodigo', function($req, $res) use($app){
    require_once "../app/controllers/abm_getStockController.php";
    return getDatos();
});

////GUARDA MOVIMIENTOS
//$app->post('/abm_getMovimientos', function($req, $res) use($app){
//    require_once "../app/controllers/abm_getMovimientosController.php";
//    return saveDatos();
//});
//
////BORRA MOVIMIENTOS
//$app->delete('/abm_getMovimientos', function($req, $res) use($app){
//    require_once "../app/controllers/abm_getMovimientosController.php";
//    return deleteDatos();
//});
//
////BORRA MOVIMIENTOS
//$app->put('/abm_getMovimientos', function($req, $res) use($app){
//    require_once "../app/controllers/abm_getMovimientosController.php";
//    return editDatos();
//});
//
////OBTIENE PROVEEDORES
//$app->get('/abm_getMovimientosProveedor', function($req, $res) use($app){
//    require_once "../app/controllers/abm_getMovimientosController.php";
//    return getProveedor();
//});
//
////OBTIENE ARTICULOS
//$app->get('/abm_getMovimientosArticulos', function($req, $res) use($app){
//    require_once "../app/controllers/abm_getMovimientosController.php";
//    return getArticulos();
//});
//
////OBTIENE OPERACION
//$app->get('/abm_getMovimientosOperacion', function($req, $res) use($app){
//    require_once "../app/controllers/abm_getMovimientosController.php";
//    return getOperacion();
//});
//
////OBTIENE OPERACION
$app->get('/abm_getMovimientosDeposito', function($req, $res) use($app){
    require_once "../app/controllers/abm_getArticulosController.php";
    return getDeposito();
});
//
//VISTA STOCK
$app->get('/abm_stock', function($req, $res) use($app){
    return $this->renderer->render($res, 'stock/abm.stock.php');
});
//
///*FIN STOCK*/
