 <?php 
header('Content-Type: application/json');
include '../db_connection.php'; 
 $result = array(); 
 $rs = mysqli_query( $conn,"select count(*) from mensaje");
 
 $sql="select mens_id,mens_mensaje,mens_enviado_por,mens_leido from mensaje where mens_leido= '0' ";
 $rs = mysqli_query( $conn,$sql); 
 $items = array();
 while($row = mysqli_fetch_object($rs)){
    array_push($items, $row);
 }
  echo json_encode($items);
 ?>