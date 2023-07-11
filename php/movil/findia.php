 <?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
include '../db_connection.php'; 
$ras_latitud = $_POST['ras_latitud'];
$ras_longitud = $_POST['ras_longitud'];
$ase_id = $_POST['ase_id']; 
try {   
   $sql = "INSERT INTO  rastreo   (ras_fecha_hora, ras_latitud, ras_longitud, ase_id )   VALUES(current_timestamp, '$ras_latitud', '$ras_longitud ', '$ase_id' ); ";
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

 

