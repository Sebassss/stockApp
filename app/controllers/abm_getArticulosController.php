<?php
/**
 * Created by PhpStorm.
 * User: SEbas
 * Date: 19/01/2017
 * Time: 10:49
 */

//echo lista();

require_once "../app/data/class.conexion.php";

function insertTolog($valor, $usuario_id)
{

    $db = new MySQL();
    $result = $db->Consulta("insert into logs (log,usuario_id)  values('$valor','$usuario_id')");

}

//Elimina registros a partir del modal
function deleteDatos()
{


    /*Parser para  metodos put y delete*/
    parse_str(file_get_contents("php://input"),$post_vars);
    //print_r($post_vars);



    $db = new MySQL();
    $a = $post_vars['table_field_articulo_id'];

    $result_tmp = $db->consulta("select * from articulos where articulo_id = '$a'");
    $row = $db->fetch_array($result_tmp);
    $art_nombre=$row['articulo_nombre'];
    $art_cant = $row['articulo_cantidad'];

    $result = $db->consulta("delete from articulos where articulo_id = '$a'");
    $mensaje = "No pudo Eliminar.";
    $estado = "false";

    if(!$result)
    {
        $mensaje = "Procesado correctamente.";
        $estado = "true";

        $alias = $_SESSION['userCredentials']['usuario_alias'];
        $usuario_id = $_SESSION['userCredentials']['usuario_id'];
        insertTolog("El usuario: ".$alias.", ha eliminado un artículo del stock,  Nombre: ".$art_nombre." Cantidad: ".$art_cant,$usuario_id);
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
    $a = $post_vars['table_field_articulo_id'];
    $b = $post_vars['table_field_marca_id'];
    $c = $post_vars['table_field_rubro_id'];
    $d = $post_vars['table_field_articulo_nombre'];
    $e = $post_vars['table_field_articulo_detalle'];
    $f = $post_vars['table_field_proveedor_id'];
    $g = $post_vars['table_field_articulo_codigo'];
    $h = $post_vars['table_field_articulo_cantidad'];
    $i = $post_vars['table_field_deposito_id'];

    $result = $db->consulta("update articulos set deposito_id='$i', articulo_nombre= '$d', articulo_cantidad='$h', articulo_detalle='$e', rubro_id='$c', marca_id='$b',proveedor_id='$f', articulo_codigo='$g'  where articulo_id = '$a'");
    $mensaje = "No pudo editar.";
    $estado = "false";

    if(!$result)
    {
        $mensaje = "Procesado correctamente.";
        $estado = "true";

        $alias = $_SESSION['userCredentials']['usuario_alias'];
        $usuario_id = $_SESSION['userCredentials']['usuario_id'];
        insertTolog("El usuario: ".$alias.", ha editado un artículo del stock,  Nombre: ".$d." Cantidad: ".$h,$usuario_id);
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


function getDeposito()
{
    $db = new MySQL();
    $consulta = $db->Consulta("SELECT  a.deposito_nombre, a.deposito_id  FROM depositos a");
    $i = 0;
    $x = array();
    while ($row = $db->fetch_array($consulta)) {
        $x[$i] = array("value" => $row['deposito_id'], "text" => $row['deposito_nombre']);
        $i++;
    }
    echo json_encode($x);
}

//Descuenta/Usa articulos
function descArticulos()
{

    parse_str(file_get_contents("php://input"),$post_vars);

    $db = new MySQL();

    $a = $post_vars['articulo_id'];
    $b = $post_vars['usuario_id'];
    $c = $post_vars['articulo_cantidad'];
    $d = $post_vars['articulo_comentario'];

    /*
    echo $a;
    echo $b;
    echo $c;
    echo $d;

    die;    
    */
    $result_rows = $db->Consulta("select articulo_cantidad from articulos where articulo_id=".$a);

    $mensaje = "No pudo guardar.";
    $estado = "false";

    if($db->num_rows($result_rows)>0) {

        $tmp = $db->fetch_array($result_rows);
        //print_r($tmp);
        $resta = $tmp['articulo_cantidad'] - $c;

        if ($resta < 0)
        {
            $query = $db->Consulta("select a.articulo_cantidad,a.articulo_nombre, m.marca_nombre, r.rubro_nombre,d.deposito_nombre from articulos a 
                                left join marcas m on m.marca_id = a.marca_id
                                left join rubros r on r.rubro_id = a.rubro_id
                                left join depositos d on d.deposito_id = a.deposito_id
                            where a.articulo_id=".$a);

            $articulo = $db->fetch_array($query);

            $mensaje = "No puedes superar el stock, Rubro : ".$articulo['rubro_nombre']." Marca : ".$articulo['marca_nombre'].", Artículo : ".$articulo['articulo_nombre'].", Disponibles: ".$tmp['articulo_cantidad'];
            insertTolog($mensaje,$b);
        }
        else
        {

            $result = $db->Consulta("update articulos set articulo_cantidad=" . $resta . " where articulo_id=" . $a);

            if (!$result) {

                $mensaje = "Procesado correctamente.";
                $estado = "true";

                $query = $db->Consulta("select a.articulo_cantidad,a.articulo_nombre, m.marca_nombre, r.rubro_nombre,d.deposito_nombre from articulos a 
                                left join marcas m on m.marca_id = a.marca_id
                                left join rubros r on r.rubro_id = a.rubro_id
                                left join depositos d on d.deposito_id = a.deposito_id
                            where a.articulo_id=".$a);

                $articulo = $db->fetch_array($query);
                insertTolog("Se descontó del stock en depósito: ".$articulo['deposito_nombre']." el rubro : ".$articulo['rubro_nombre']. " Marca: ".$articulo['marca_nombre']." Articulo: ".$articulo['articulo_nombre']." Cantidad: ".$c." quedando en stock ".$articulo['articulo_cantidad']." disponibles."." Comentarios: ".$d,$b);
            } else {
                $mensaje = "Error: " . $result;
                insertTolog("Se produjo un error :".$mensaje,$b);
            }
        }
    }
    else
    {
        $mensaje = "No hay stock.";
        insertTolog($mensaje,$b);
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

    $a = $_POST['table_field_articulo_nombre'];
    $b = $_POST['table_field_marca_id'];
    $c = $_POST['table_field_rubro_id'];
    $d = html_entity_decode($_POST['table_field_articulo_detalle']);
    $e = $_POST['table_field_proveedor_id'];
    $f = $_POST['table_field_articulo_codigo'];
    $g = $_POST['table_field_articulo_cantidad'];
    $h = $_POST['table_field_deposito_id'];


    $result = $db->consulta("insert into articulos (articulo_nombre, marca_id,rubro_id, articulo_detalle,proveedor_id,articulo_codigo,articulo_cantidad,deposito_id) values ('$a','$b','$c','$d','$e','$f','$g','$h')");


    $mensaje = "No pudo guardar.";
    $estado = "false";

    if(!$result)
    {
        $mensaje = "Procesado correctamente.";
        $estado = "true";

        $alias = $_SESSION['userCredentials']['usuario_alias'];
        $usuario_id = $_SESSION['userCredentials']['usuario_id'];
        insertTolog("El usuario: ".$alias.", ha agregado un nuevo artículo al stock, Nombre: ".$a." Cantidad: ".$g,$usuario_id);

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

$key =$_GET['key'];



$db = new MySQL();

    if($_GET['key'] != "")
    {
        $consulta = $db->Consulta("select a.articulo_id, a.proveedor_id,p.proveedor_nombre,a.marca_id,m.marca_nombre, a.rubro_id,r.rubro_nombre, a.articulo_nombre, a.articulo_detalle,a.articulo_codigo,a.articulo_cantidad,a.deposito_id, d.deposito_nombre from articulos a 
                                  left join rubros r on r.rubro_id=a.rubro_id 
                                  left join marcas m on m.marca_id=a.marca_id
                                  left join proveedores p on p.proveedor_id=a.proveedor_id
                                  left join depositos d on d.deposito_id = a.deposito_id
                                  WHERE 
                                              p.proveedor_nombre like '%$key%' OR
                                              m.marca_nombre like '%$key%' OR 
                                              r.rubro_nombre like '%$key%' OR 
                                              a.articulo_nombre like '%$key%' OR 
                                              a.articulo_detalle like '%$key%' OR
                                              a.articulo_codigo like '%$key%' OR
                                              a.articulo_cantidad like '%$key%' OR
                                              d.deposito_nombre like '%$key%'");
    }
    else {
        $consulta = $db->Consulta("select a.articulo_id, a.proveedor_id,p.proveedor_nombre,a.marca_id,m.marca_nombre, a.rubro_id,r.rubro_nombre, a.articulo_nombre, a.articulo_detalle,a.articulo_codigo,a.articulo_cantidad,a.deposito_id, d.deposito_nombre from articulos a 
                                  left join rubros r on r.rubro_id=a.rubro_id 
                                  left join marcas m on m.marca_id=a.marca_id
                                  left join proveedores p on p.proveedor_id=a.proveedor_id
                                  left join depositos d on d.deposito_id = a.deposito_id");
    }
$num_total_registros = $db->num_rows($consulta);
$total_paginas = ceil($num_total_registros / $TAMANO_PAGINA);


if($key !="") {
    $consulta = $db->Consulta("select a.articulo_id, a.proveedor_id,p.proveedor_nombre,a.marca_id,m.marca_nombre, a.rubro_id,r.rubro_nombre, a.articulo_nombre, a.articulo_detalle,a.articulo_codigo,a.articulo_cantidad,a.deposito_id, d.deposito_nombre from articulos a 
                                  left join rubros r on r.rubro_id=a.rubro_id 
                                  left join marcas m on m.marca_id=a.marca_id
                                  left join proveedores p on p.proveedor_id=a.proveedor_id 
                                  left join depositos d on d.deposito_id = a.deposito_id
                                   WHERE 
                                              p.proveedor_nombre like '%$key%' OR
                                              m.marca_nombre like '%$key%' OR 
                                              r.rubro_nombre like '%$key%' OR 
                                              a.articulo_nombre like '%$key%' OR 
                                              a.articulo_detalle like '%$key%' OR
                                              a.articulo_codigo like '%$key%' OR
                                              a.articulo_cantidad like '%$key%' OR
                                              d.deposito_nombre like '%$key%' limit " . $inicio . "," . $TAMANO_PAGINA . ";");
}
else
{
    $consulta = $db->Consulta("select a.articulo_id, a.proveedor_id,p.proveedor_nombre,a.marca_id,m.marca_nombre, a.rubro_id,r.rubro_nombre, a.articulo_nombre, a.articulo_detalle,a.articulo_codigo,a.articulo_cantidad,a.deposito_id, d.deposito_nombre from articulos a 
                                  left join rubros r on r.rubro_id=a.rubro_id 
                                  left join marcas m on m.marca_id=a.marca_id
                                  left join proveedores p on p.proveedor_id=a.proveedor_id 
                                  left join depositos d on d.deposito_id = a.deposito_id limit " . $inicio . "," . $TAMANO_PAGINA . ";");
}

$x = array();

$i=0;
while($row = $db->fetch_array($consulta))
{
     //$x[$i] = $row;

    $x[$i] = array('articulo_id' => $row['articulo_id'],
                   'proveedor_nombre' => $row['proveedor_nombre'],
        'marca_id' => $row['marca_id'],
        'marca_nombre' => $row['marca_nombre'],
        'rubro_id' => $row['rubro_id'],
        'rubro_nombre' => $row['rubro_nombre'],
        'articulo_nombre' => $row['articulo_nombre'],
        'articulo_codigo' => $row['articulo_codigo'],
        'articulo_cantidad' => $row['articulo_cantidad'],
        'deposito_id' => $row['deposito_id'],
        'deposito_nombre' => $row['deposito_nombre'],
        'articulo_detalle' => htmlentities(utf8_encode(stripslashes($row['articulo_detalle']))),
        'proveedor_id' => $row['proveedor_id']);
    $i++;
}


$t = array(array(
    'rows' => $i,
    'key' => $key,
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

function getDatos2()
{




    $db = new MySQL();

    $consulta = $db->Consulta("select a.articulo_id, a.proveedor_id,p.proveedor_nombre,a.marca_id,m.marca_nombre, a.rubro_id,r.rubro_nombre, a.articulo_nombre, a.articulo_detalle,a.articulo_codigo,a.articulo_cantidad,a.deposito_id, d.deposito_nombre from articulos a 
                                  left join rubros r on r.rubro_id=a.rubro_id 
                                  left join marcas m on m.marca_id=a.marca_id
                                  left join proveedores p on p.proveedor_id=a.proveedor_id
                                  left join depositos d on d.deposito_id = a.deposito_id");


    $x = array();

    $i=0;
    while($row = $db->fetch_array($consulta))
    {
        //$x[$i] = $row;

        $x[$i] = array('articulo_id' => $row['articulo_id'],
            'proveedor_nombre' => $row['proveedor_nombre'],
            'marca_id' => $row['marca_id'],
            'marca_nombre' => $row['marca_nombre'],
            'rubro_id' => $row['rubro_id'],
            'rubro_nombre' => $row['rubro_nombre'],
            'articulo_nombre' => $row['articulo_nombre'],
            'articulo_codigo' => $row['articulo_codigo'],
            'articulo_cantidad' => $row['articulo_cantidad'],
            'deposito_id' => $row['deposito_id'],
            'deposito_nombre' => $row['deposito_nombre'],
            'articulo_detalle' => htmlentities(utf8_encode(stripslashes($row['articulo_detalle']))),
            'proveedor_id' => $row['proveedor_id']);
        $i++;
    }





    echo json_encode($x);



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

function getMarcas()
{
    $db = new MySQL();

    $consulta = $db->Consulta("SELECT  concat(a.marca_nombre,' - ', a.marca_detalle) as marca_nombre, a.marca_id  FROM marcas a  ");

    $i = 0;
    $x = array();
    while ($row = $db->fetch_array($consulta)) {
        $x[$i] = array("value" => $row['marca_id'], "text" => $row['marca_nombre']);
        $i++;
    }

    echo json_encode($x);

}

function getProveedor()
{
    $db = new MySQL();

    $consulta = $db->Consulta("SELECT  a.proveedor_nombre, a.proveedor_id  FROM proveedores a");

    $i = 0;
    $x = array();
    while ($row = $db->fetch_array($consulta)) {
        $x[$i] = array("value" => $row['proveedor_id'], "text" => $row['proveedor_nombre']);
        $i++;
    }

    echo json_encode($x);

}