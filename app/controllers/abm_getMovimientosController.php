<?php
/**
 * Created by PhpStorm.
 * User: SEbas
 * Date: 19/01/2017
 * Time: 10:49
 */

//echo lista();

require_once "../app/data/class.conexion.php";


date_default_timezone_set('America/Argentina/San_Juan');

function fecha_hora($fecha)
{
    $dia =  date('l',strtotime($fecha));
    if ($dia=="Monday") $dia="Lunes";
    if ($dia=="Tuesday") $dia="Martes";
    if ($dia=="Wednesday") $dia="Miércoles";
    if ($dia=="Thursday") $dia="Jueves";
    if ($dia=="Friday") $dia="Viernes";
    if ($dia=="Saturday") $dia="Sabado";
    if ($dia=="Sunday") $dia="Domingo";

    $mes =  date('F',strtotime($fecha));
    if ($mes=="January") $mes="Enero";
    if ($mes=="February") $mes="Febrero";
    if ($mes=="March") $mes="Marzo";
    if ($mes=="April") $mes="Abril";
    if ($mes=="May") $mes="Mayo";
    if ($mes=="June") $mes="Junio";
    if ($mes=="July") $mes="Julio";
    if ($mes=="August") $mes="Agosto";
    if ($mes=="September") $mes="Setiembre";
    if ($mes=="October") $mes="Octubre";
    if ($mes=="November") $mes="Noviembre";
    if ($mes=="December") $mes="Diciembre";

    $ano =  date('Y',strtotime($fecha));
    $dia2= date('d',strtotime($fecha));
    $hora = date('H:i',strtotime($fecha));
    $fecha  = $dia.', '.$dia2.' de '.$mes.' de '.$ano. ' a las '.$hora;

    return $fecha;

}
echo '<div class="row">
        <div class="col-12 col-md-12">
            <div class="row">
            <!-- Boxes de Acoes -->
            <div class="col-xs-12 col-sm-12 col-lg-12">
                    <div class="box">
                        <div class="icon">
                            <div class="image"><i class="glyphicon glyphicon-random"></i></div>
                            <div class="info">
                                <h3 class="title">Registro de Movimientos </h3>
                                <p>';

                                $db = new MySQL();
                                $result = $db->Consulta("select l.log, u.usuario_nombre as usuario, l.fecha  from logs l left join usuarios u on u.usuario_id = l.usuario_id order by l.id desc ");

                                while($row = $db->fetch_array($result))
                                {
                                    echo '<li class="list-group-item list-group-item-danger text-left">El dia <u>'.fecha_hora($row['fecha']).
                                         '</u> se registra un evento con el usuario <b>'.$row['usuario'].'</b>: <i>'.$row['log'].'</i>';
                                }
                                echo '</p>
                                
                            </div>
                        </div>
                        <div class="space"></div>
                    </div>
                </div>

            
                <!-- /Boxes de Acoes -->
         </div>
        </div>
    </div>
';