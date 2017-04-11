<?php 


class MySQL{



  private $conexion; private $total_consultas;
	
	  public function __construct(){ 
	  	
	if (!defined('DB_HOST')) define('DB_HOST','10.64.65.200');
	if (!defined('DB_USER')) define('DB_USER','stock'); //sebafd1
	if (!defined('DB_PASS')) define('DB_PASS','nautilus'); //universal123
	if (!defined('DB_NAME')) define('DB_NAME','stock');
	
    if(!isset($this->conexion)){
      $this->conexion = (mysqli_connect(DB_HOST,DB_USER,DB_PASS))
        or die(mysqli_error($this->conexion));
      mysqli_select_db($this->conexion,DB_NAME) or die(mysqli_error($this->conexion));
    }
  }

  public function consulta($consulta){ 
    mysqli_set_charset($this->conexion,"utf8");
    $this->total_consultas++; 
    $resultado = mysqli_query($this->conexion,$consulta);
    if(!$resultado){ 
      return 'Error '.mysqli_errno($this->conexion);
      //exit;
    }

    return $resultado;
	mysql_free_result($resultado);
	mysqli_close($this->conexion);
  }
  
  public function fetch_array($consulta){
   return mysqli_fetch_array($consulta);
  }

  public function num_rows($consulta){
   return mysqli_num_rows($consulta);
  }

  public function getTotalConsultas(){
   return $this->total_consultas; 
  }

  public function getLastID(){
   return mysqli_insert_id($this->conexion); 
  }

}?>


<?php
//Modo de uso de la clase de conexion
//By sebas 2014
//include("mysql.php");
/*
$db = new MySQL();
$consulta = $db->consulta("SELECT id FROM usuario");
if($db->num_rows($consulta)>0){
  while($resultados = $db->fetch_array($consulta)){ 
   echo "ID: ".$resultados['id']."<br />"; 
 }
}
*/
?>