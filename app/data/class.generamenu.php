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

class Menu extends MySQL {

    public function __construct (){
        parent::__construct();
    }

    var $mi_miron;

    /**
     * Funcion que retorna los permisos de un recurso como menu
     *
     * @param int $usuario_id
     * @param int $recurso_id
     * @return object|stdClass
     */

    public function GeneraMenu ($parent,$level, $user){


        $consulta = "SELECT a.RecursoID, a.Nombre,a.Icon, a.Link, Deriv1.Count as Count FROM Tbl_Recursos a
                     LEFT OUTER JOIN (SELECT Parent, COUNT(*) AS Count FROM Tbl_Recursos GROUP BY parent) Deriv1 ON a.RecursoID = Deriv1.Parent
                     LEFT JOIN Tbl_PerfilesRecursos pr on pr.RecursoID = a.RecursoID
                     LEFT JOIN Tbl_UsuariosPerfiles up on up.PerfilID = pr.PerfilID
                     WHERE a.Parent =".$parent." and up.UsuarioID = ".$user." group by a.RecursoID,a.Nombre, a.Icon,a.Link, Deriv1.count order by Orden asc";

        $result = $this->Consulta($consulta);
        echo '<ul class="sidebar-menu">
		<li class="header">Menu Principal</li>';
        if($this->num_rows($result)>0)
        {
            while($resultados = $this->fetch_array($result))
            {
                echo '<li class="treeview">
            		    <a href="javascript:;"><i class="'.$resultados['Icon'].'"></i><span>'.($resultados['Nombre']).'</span>
              			    <span class="pull-right-container">';

                		       if($resultados['Count']>0) echo '<i class="fa fa-angle-left pull-right"></i>';
              	echo	   '</span>
            			</a>';
                echo Get_Parents($resultados['RecursoID']);
                echo '</li>';
            }
        }
        echo '</ul>';
    }
}

function Get_Parents($parent)
{
    $db = new MySQL();
    $result = $db->Consulta("select * from Tbl_Recursos where Parent='$parent' order by Orden asc");
    if($db->num_rows($result)>0)
    {
        echo '<ul class="treeview-menu">';
        while ($row = $db->fetch_array($result))
        {
            echo '<li>
          <a href="' . $row['Link'] . '" ><i class="' . $row['Icon'] . '"></i> ' . ($row['Nombre']) . '</a>
        </li>';
        }
        echo '</ul>';
    }
}
