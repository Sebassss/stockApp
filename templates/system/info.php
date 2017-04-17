<?php
/**
 * Created by PhpStorm.
 * User: SEbas
 * Date: 17/04/2017
 * Time: 9:07
 */

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
            <div class="col-xs-12 col-sm-6 col-lg-4">
                    <div class="box">
                        <div class="icon">
                            <div class="image"><i class="fa fa-thumbs-o-up"></i></div>
                            <div class="info">
                                <h3 class="title">Ultiumos movimientos </h3>
                                <p>';

                                $db = new MySQL();
                                $result = $db->Consulta("select m.fechahora, 
                                                               m.deposito_id,
                                                               d.deposito_nombre,
                                                               m.proveedor_id,
                                                               p.proveedor_nombre,
                                                               m.articulo_id,
                                                               a.articulo_nombre,
                                                               (case  m.operacion when 0 then 'INGRESO' when 1 then 'EGRESO' end) as operacion, 
                                                               m.cantidad from movimientos m
                                                          left join depositos d on d.deposito_id = m.deposito_id
                                                          left join proveedores p on p.proveedor_id = m.proveedor_id
                                                          left join articulos a on a.articulo_id = m.articulo_id order by m.fechahora desc limit 0, 5;");

                                while($row = $db->fetch_array($result))
                                {
                                    echo '<li class="list-group-item list-group-item-danger">El dia <u>'.fecha_hora($row['fechahora']).'</u> se registra un <i>'.$row['operacion'].'</i> del Artículo <b>'.$row['articulo_nombre'].' - </b>  de <b>'.$row['cantidad'].'</b> Items</li>';
                                }
                                echo '</p>
                                
                            </div>
                        </div>
                        <div class="space"></div>
                    </div>
                </div>

            <div class="col-xs-12 col-sm-6 col-lg-4">
                    <div class="box">
                        <div class="icon">
                            <div class="image"><i class="fa fa-flag"></i></div>
                            <div class="info">
                                <h3 class="title">Top 10 de Cantidades</h3>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed in lobortis nisl, vitae iaculis sapien. Phasellus ultrices gravida massa luctus ornare. Suspendisse blandit quam elit, eu imperdiet neque semper.
                                </p>
                                <div class="more">
                                    <a href="#" title="Title Link">
                                        Read More <i class="fa fa-angle-double-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="space"></div>
                    </div>
                </div>

            <div class="col-xs-12 col-sm-6 col-lg-4">
                    <div class="box">
                        <div class="icon">
                            <div class="image"><i class="fa fa-desktop"></i></div>
                            <div class="info">
                                <h3 class="title">Rubros</h3>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed in lobortis nisl, vitae iaculis sapien. Phasellus ultrices gravida massa luctus ornare. Suspendisse blandit quam elit, eu imperdiet neque semper.
                                </p>
                                <div class="more">
                                    <a href="#" title="Title Link">
                                        Read More <i class="fa fa-angle-double-right"></i>
                                    </a>
                                </div>
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