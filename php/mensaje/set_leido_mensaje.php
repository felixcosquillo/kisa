 <?php 
header('Content-Type: application/json');
include '../db_connection.php'; 

$mens_id = $_REQUEST['mens_id'];

 $result = array();  
 
 $sql="update mensaje set mens_leido='1'  where mens_id= $mens_id "   ;
 $rs = mysqli_query( $conn,$sql); 
 $items = array();
 while($row = mysqli_fetch_object($rs)){
    array_push($items, $row);
 }
  echo json_encode($items);
 ?>