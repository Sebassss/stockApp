<?php
/**
 * Created by PhpStorm.
 * User: Calopsia
 * Date: 06/04/2017
 * Time: 16:44
 */

require_once "../app/data/class.conexion.php";

function checkUsuario()
{

    $usuario_id='NONE';
    $alias = 'NONE';
    $estado = 'NONE';
    $mensaje = 'El usuario o clave proporcionados no existen, o el usuario fue deshabilitado, consulte con el administrador del sistema.';

    $db = new MySQL();

    $user = $_GET['txt_usr'];
    $pwd = $_GET['txt_pwd'];

    $sql = $db->Consulta("select usuario_id,usuario_estado, usuario_nombre, usuario_alias from usuarios where usuario_nombre = '$user' and usuario_clave = '$pwd' AND usuario_estado = 0");

    if($db->num_rows($sql)>0)
    {
        while($row = $db->fetch_array($sql)) {
            $usuario_id = $row['usuario_id'];
            $alias = $row['usuario_alias'];
            $estado = "HABILITADO";
            $mensaje = 'Hola '.$row['usuario_alias'].', serás redireccionado en breve.';
            $_SESSION['userCredentials'] = $row;
        }
    }
    else {
//        $alias = 'NONE';
//        $estado = 'NONE';

    }

    $response = array(
        'alias' => $alias,
        'estado' => $estado,
        'mensaje' => $mensaje,
        'usuario_id'=> $usuario_id,
    );

    echo json_encode($response);
}