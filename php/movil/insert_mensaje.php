 <?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
include '../db_connection.php'; 
$mens_mensaje = $_POST['mens_mensaje'];
$mens_enviado_por = $_POST['mens_enviado_por'];
 
try {   
   $sql = "INSERT INTO mensaje   (mens_mensaje, mens_enviado_por, mens_leido)  VALUES('$mens_mensaje', '$mens_enviado_por', '0');  ";
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

 

