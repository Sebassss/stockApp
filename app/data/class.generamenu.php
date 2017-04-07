<?php
/**
 * Clase Permiso
 *
 * Clase para validar los permiso de un usuario sobre un recurso del sistema
 *
 * @category   Configuracion
 * @package    base de datos
 * @copyright  Copyright (c) 2016 pseba20@gmail.com
 * @version    $Id:$
 */

class Menu extends MySQL
{

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Funcion que retorna los permisos de un recurso como menu
     *
     * @param int $usuario_id
     * @param int $recurso_id
     * @return object|stdClass
     */



    public function DrawMenu()
    {
        $sql = "SELECT a.menu_id, a.menu_titulo,a.menu_icon, a.menu_link,a.menu_parent, Deriv1.Count as Count FROM menu a
                LEFT OUTER JOIN (SELECT menu_parent, COUNT(*) AS Count FROM menu GROUP BY menu_parent) Deriv1 ON a.menu_id = Deriv1.menu_parent
                order by menu_orden asc";

        $result = $this->Consulta($sql);

        echo '<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">';

        if ($this->num_rows($result) > 0)
        {
            while ($resultados = $this->fetch_array($result))
            {
                if ($resultados['menu_parent'] == 0)
                {
                    if($resultados['Count'] !='')
                    {
                        echo '<li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">' . $resultados['menu_titulo'] . ' <span class="caret"></span></a>
                            <ul class="dropdown-menu">';
                        $this->Draw_Parents($resultados['menu_id']);
                        echo '</ul>
                            </li>';
                    }
                    else {
                        echo '<li><a href="#">' . $resultados['menu_titulo'] . '</a></li>'; //'<li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
                    }
                }
                else
                {

                }

            }
        }
        echo ' </ul></div>';
    }

    public function Draw_Parents($parent)
    {

        $result = "select * from menu where menu_parent='$parent' order by menu_orden asc";
        if ($this->num_rows($result) > 0)
        {
            while ($resultados = $this->fetch_array($result))
            {
               echo '<li><a href="#">'.$resultados['menu_titulo'].'</a></li>';
            }
        }
    }

}