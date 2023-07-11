 <?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
include '../db_connection.php'; 
$obs_latitud = $_POST['obs_latitud'];
$obs_longitud = $_POST['obs_longitud'];
$obs_texto = trim($_POST['obs_texto']);
$ase_id = $_POST['ase_id'];
$lug_id = $_POST['lug_id'];
try {   
   $sql = "INSERT INTO  observacion (obs_fecha_hora, obs_latitud, obs_longitud, obs_texto, ase_id,lug_id)   VALUES(current_timestamp, $obs_latitud, $obs_longitud, '$obs_texto', $ase_id ,$lug_id); ";
   $result = @mysqli_query($conn, $sql);
   if ($result){
      echo json_encode(array('success'=>true));
   } else {
      echo json_encode(array('msg'=>    $sql  ));
   }
 } catch (Exception $e) {
   echo json_encode(array('errorMsg'=>   $sql ));
 }

 ?>

 

