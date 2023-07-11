 <?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
include '../db_connection.php'; 
$ase_cedula = $_REQUEST['ase_cedula'];
$ase_nombre = $_REQUEST['ase_nombre'];
$ase_telefono = $_REQUEST['ase_telefono'];
$ase_direccion = $_REQUEST['ase_direccion'];
$sup_id = $_REQUEST['sup_id'];
$usu_login = $_REQUEST['usu_login'];
$ase_id = $_REQUEST['ase_id'];
try {
   $sql = " UPDATE  asesor SET usu_login='$usu_login', ase_nombre='$ase_nombre', ase_telefono='$ase_telefono', ase_direccion='$ase_direccion', sup_id= $sup_id, usu_login='$usu_login'    WHERE ase_id= $ase_id ;  ";
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

 

