<?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
include '../db_connection.php'; 
 
$lug_id = $_REQUEST['lug_id'];
try {
   $sql = " UPDATE  lugar_visita SET lug_hora_fin= current_timestamp()      WHERE lug_id= $lug_id ;  ";
   $result = @mysqli_query($conn, $sql);
   if ($result){
      echo json_encode(array('success'=>true));
   } else {
      echo json_encode(array('msg'=>'Some errors occured.'));
   }
 } catch (Exception $e) {
   echo json_encode(array('errorMsg'=>'Some errors occured.'));
 }

 ?>

 

