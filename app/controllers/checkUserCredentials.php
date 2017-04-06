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


    $alias = 'NONE';
    $estado = 'NONE';
    $mensaje = 'El usuario o clave proporcionados no existen, o el usuario fue deshabilitado, consulte con el administrador del sistema.';

    $db = new MySQL();

    $user = $_GET['txt_usr'];
    $pwd = $_GET['txt_pwd'];

    $sql = $db->Consulta("select USUARIO_ID,USUARIO_ESTADO, USUARIO_NOMBRE, USUARIO_ALIAS, USUARIO_CLAVE from usuarios where USUARIO_NOMBRE = '$user' and USUARIO_CLAVE = '$pwd' AND USUARIO_ESTADO = 0");

    if($db->num_rows($sql)>0)
    {
        while($row = $db->fetch_array($sql)) {
            $alias = $row['USUARIO_ALIAS'];
            $estado = "HABILITADO";
            $mensaje = 'Hola '.$row['USUARIO_ALIAS'].', serás redireccionado en breve.';
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
    );

    echo json_encode($response);
}