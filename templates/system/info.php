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
                                <h3 class="title">Últimos 5 movimientos </h3>
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
                                    echo '<li class="list-group-item list-group-item-danger text-left">El dia <u>'.fecha_hora($row['fechahora']).'</u> se registra un <i>'.$row['operacion'].'</i> del Artículo <b>'.$row['articulo_nombre'].' - </b>  de <b><span class="badge">'.$row['cantidad'].'</span></b> Items</li>';
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
                                <h3 class="title">Top 5 de Cantidades</h3>
                                <p>';
                                    $db = new MySQL();
                                    $mode = $db->Consulta("SET sql_mode = '';");
                                    $result = $db->Consulta("select  sum(m.cantidad) as cantidad,
                                                                    m.deposito_id,
                                                                    d.deposito_nombre,
                                                                    m.proveedor_id,
                                                                    p.proveedor_nombre,
                                                                    m.articulo_id,
                                                                    a.articulo_nombre,
                                                                    m.operacion,
                                                                    ma.marca_nombre,
                                                                    ru.rubro_nombre
                                                                    from movimientos m
                                                              left join depositos d on d.deposito_id = m.deposito_id
                                                              left join proveedores p on p.proveedor_id = m.proveedor_id
                                                              left join articulos a on a.articulo_id = m.articulo_id
                                                              left join marcas ma on ma.marca_id=a.marca_id
                                                              left join rubros ru on ru.rubro_id = a.rubro_id
                                                              group by m.articulo_id limit 0, 5;");

                                    while($row = $db->fetch_array($result))
                                    {
                                        echo '<li class="list-group-item list-group-item-success text-left"> Hay un total de <b><span class="badge">'.$row['cantidad'].'</span></b> <u>Rubro : '.$row['rubro_nombre'].' Marca : '.$row['marca_nombre'].' Artículo : '.$row['articulo_nombre'].'</u> </li>';
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
                            <div class="image"><i class="fa fa-desktop"></i></div>
                            <div class="info">
                                <h3 class="title">Últimos 5 movimientos en artículos</h3>
                                <p>
                                    <li class="list-group-item list-group-item-success text-left"> Jhonatan Recio ha tomado <b><span class="badge">3</span></b> <u>Rubro : IMPRESORAS Marca : EPSON Artículo : epsons</u> </li>
                                    <li class="list-group-item list-group-item-success text-left"> Dario Peña ha tomado <b><span class="badge">1</span></b> <u>Rubro : IMPRESORAS Marca : EPSON Artículo : Toner a35</u> </li>
                                    <li class="list-group-item list-group-item-success text-left"> Sebastián Mendoza ha tomado <b><span class="badge">1</span></b> <u>Rubro : IMPRESORAS Marca : EPSON Artículo : Toner a35</u> </li>
                                </p>
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