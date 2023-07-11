 <?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
include '../db_connection.php'; 
 
 $ase_id =  $_POST['ase_id'] ;
 
 $rs = mysqli_query( $conn,"select  obs_id, obs_fecha_hora,   obs_texto  from observacion  where ase_id =  $ase_id   ");
 $items = array();
 while($row = mysqli_fetch_object($rs)){
    array_push($items, $row);
 }
 echo json_encode($items);
 ?>