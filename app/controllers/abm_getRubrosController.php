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
    $result = $db->consulta("delete from rubros where rubro_id = '$a'");
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
    $a = $post_vars['table_field_rubro_id'];
    $b = $post_vars['table_field_rubro_nombre'];
    $result = $db->consulta("update rubros set rubro_nombre= '$b'  where rubro_id = '$a'");
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

    $a = $_POST['table_field_rubro_nombre'];


    $result = $db->consulta("insert into rubros (rubro_nombre) values ('$a')");


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


if(isset($_POST['pagesize']))
{
    $TAMANO_PAGINA = $_POST['pagesize'];
}
else
{
    $TAMANO_PAGINA=10;
}

//examino la página a mostrar y el inicio del registro a mostrar

if(isset($_POST['page']))
{
    $pagina = $_POST["page"];
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

$consulta = $db->Consulta("select rubro_id, rubro_nombre from rubros");
$num_total_registros = $db->num_rows($consulta);
$total_paginas = ceil($num_total_registros / $TAMANO_PAGINA);


$consulta = $db->Consulta("select rubro_id, rubro_nombre from rubros limit ". $inicio. ",". $TAMANO_PAGINA.";");

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

?>