 <?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
include '../db_connection.php'; 
 
 $lug_id =  $_POST['lug_id'] ;
 
 $rs = mysqli_query( $conn,"select  lug_id, lug_cliente, fecha, lug_nombre, lug_direccion, lug_latitud, lug_longitud, lug_ruta  from lugar_visita  where lug_id =  $lug_id  and lug_activo= '1' ");
 $items = array();
 while($row = mysqli_fetch_object($rs)){
    array_push($items, $row);
 }
 echo json_encode($items);
 ?>