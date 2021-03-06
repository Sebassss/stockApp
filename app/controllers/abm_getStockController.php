<?php
/**
 * Created by PhpStorm.
 * User: SEbas
 * Date: 19/01/2017
 * Time: 10:49
 */

//echo lista();

require_once "../app/data/class.conexion.php";


//Elimina registros a partir del modal
function deleteDatos()
{

    /*Parser para  metodos put y delete*/
    parse_str(file_get_contents("php://input"),$post_vars);
    //print_r($post_vars);



    $db = new MySQL();
    $a = $post_vars['table_field_rubro_id'];
    $result = $db->consulta("delete from marcas where marca_id = '$a'");
    $mensaje = "No pudo Eliminar.";
    $estado = "false";

    if(!$result)
    {
        $mensaje = "Procesado correctamente.";
        $estado = "true";
    }
    else
    {
        $mensaje = "Error: ".$result;
    }

    $response = array(
        'mensaje' => $mensaje,
        'estado' => $estado,
    );

    echo json_encode($response);

}

//modifica registros
function editDatos()
{

    /*Parser para  metodos put y delete*/
    parse_str(file_get_contents("php://input"),$post_vars);
    //print_r($post_vars);



    $db = new MySQL();
    $a = $post_vars['table_field_marca_id'];
    $b = $post_vars['table_field_marca_nombre'];
    $c = $post_vars['table_field_rubro_id'];
    $d = $post_vars['table_field_marca_detalle'];
    $result = $db->consulta("update marcas set marca_nombre= '$b', marca_detalle='$d', rubro_id='$c'  where marca_id = '$a'");
    $mensaje = "No pudo editar.";
    $estado = "false";

    if(!$result)
    {
        $mensaje = "Procesado correctamente.";
        $estado = "true";
    }
    else
    {
        $mensaje = "Error: ".$result;
    }

    $response = array(
        'mensaje' => $mensaje,
        'estado' => $estado,
    );

    echo json_encode($response);

}

//Guarda registros a partir del modal
function saveDatos()
{
    $db = new MySQL();
    //print_r( $_POST);

    $a = $_POST['table_field_marca_nombre'];
    $b = $_POST['table_field_rubro_id'];
    $c = $_POST['table_field_marca_detalle'];


    $result = $db->consulta("insert into marcas (marca_nombre, rubro_id, marca_detalle) values ('$a','$b','$c')");


    $mensaje = "No pudo guardar.";
    $estado = "false";

    if(!$result)
    {
        $mensaje = "Procesado correctamente.";
        $estado = "true";
    }
    else
    {
        $mensaje = "Error: ".$result;
    }

    $response = array(
        'mensaje' => $mensaje,
        'estado' => $estado,
    );

    echo json_encode($response);
}

//Carga registros en la grilla
function getDatos()
{
//print_r($_GET);
$articulo = $_GET['txt_articulo'];
$cant = $_GET['txt_cant'];
$db = new MySQL();

$consulta = $db->Consulta("select  a.articulo_id, a.articulo_nombre, ma.marca_nombre, r.rubro_nombre,(select  sum(mo.cantidad)  from movimientos mo 
				 left join articulos a on a.articulo_id = mo.articulo_id
				 left join rubros r on r.rubro_id = a.rubro_id
				 left join marcas ma on ma.marca_id = a.marca_id where mo.operacion = 0 and  a.articulo_codigo = ".$articulo.") as cantidad   from movimientos mo 
				 left join articulos a on a.articulo_id = mo.articulo_id
				 left join rubros r on r.rubro_id = a.rubro_id
				 left join marcas ma on ma.marca_id = a.marca_id where mo.operacion = 0 and a.articulo_codigo = ".$articulo."  GROUP BY a.articulo_id");


$x = array();

$i=0;

$mensaje = "No hay artículos disponibles";
$estado = "false";
$datos = array();



    if($db->num_rows($consulta) > 0)
    {
        $mensaje = "Hay artículos disponibles.";
        $estado = "true";

        while($row = $db->fetch_array($consulta))
        {
            $x[$i] = $row;
            $i++;
        }
        $datos = $x;
    }

    $response = array(
        'mensaje' => $mensaje,
        'estado' => $estado,
        'datos' => $datos,
    );

    echo json_encode($response);









}


function getRubros()
{
    $db = new MySQL();

    $consulta = $db->Consulta("SELECT  a.rubro_nombre, a.rubro_id  FROM rubros a");

    $i = 0;
    $x = array();
    while ($row = $db->fetch_array($consulta)) {
        $x[$i] = array("value" => $row['rubro_id'], "text" => $row['rubro_nombre']);
        $i++;
    }

    echo json_encode($x);

}