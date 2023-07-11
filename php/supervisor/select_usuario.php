 <?php 
header('Content-Type: application/json');
include '../db_connection.php'; 
 
 $sql="SELECT usu_login,  usu_nombre  FROM usuario;";
 $rs = mysqli_query( $conn,$sql); 
 $items = array();
 while($row = mysqli_fetch_object($rs)){
    array_push($items, $row);
 }
 
 echo json_encode($items);
 ?>