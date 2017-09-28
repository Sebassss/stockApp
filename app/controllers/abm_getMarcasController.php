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
    $a = $post_vars['table_field_marca_id'];
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


if(isset($_GET['pagesize']))
{
    $TAMANO_PAGINA = $_GET['pagesize'];
}
else
{
    $TAMANO_PAGINA=10;
}

//examino la página a mostrar y el inicio del registro a mostrar

if(isset($_GET['page']))
{
    $pagina = $_GET["page"];
    if (!$pagina)
    {
        $inicio = 0;
        $pagina = 1;
    }
    else
    {
        $inicio = ($pagina - 1) * $TAMANO_PAGINA;
    }
    //calculo el total de páginas
}
else
{
    $inicio = 0;
    $pagina=1;
}


$db = new MySQL();

$consulta = $db->Consulta("select m.marca_id,m.rubro_id, r.rubro_nombre, m.marca_nombre, m.marca_detalle from marcas m 
                           left join rubros r on r.rubro_id = m.rubro_id");
$num_total_registros = $db->num_rows($consulta);
$total_paginas = ceil($num_total_registros / $TAMANO_PAGINA);


$consulta = $db->Consulta("select m.marca_id,m.rubro_id, r.rubro_nombre, m.marca_nombre, m.marca_detalle from marcas m 
                           left join rubros r on r.rubro_id = m.rubro_id limit ". $inicio. ",". $TAMANO_PAGINA.";");

$x = array();

$i=0;
while($row = $db->fetch_array($consulta))
{
    $x[$i] = $row;
    $i++;
}


$t = array(array(
    'rows' => $i,
    'page' => $pagina,
    'page_count' => $total_paginas,
    'total_rows' => $num_total_registros,
    'start' => $inicio));


//array_push($x, $t);
//echo json_encode($x);



class resultado {

    public function __construct($a,$b){
        $this->values = $a;
        $this->info = $b;
    }

    public $values;
    public $info;
}

$elresultado = new resultado($x,$t);

echo json_encode($elresultado);



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