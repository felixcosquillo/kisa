 <?php 
header('Content-Type: application/json');
include '../db_connection.php'; 
$ase_cedula = $_REQUEST['ase_cedula'];
$ase_nombre = $_REQUEST['ase_nombre'];
$ase_telefono = $_REQUEST['ase_telefono'];
$ase_direccion = $_REQUEST['ase_direccion'];
$sup_id = $_REQUEST['supervisor'];
$usu_login = $_REQUEST['usu_login'];
try {   
   $sql = "INSERT INTO  asesor   (ase_cedula, ase_nombre, ase_telefono, ase_direccion, sup_id, usu_login)   VALUES('$ase_cedula', '$ase_nombre', '$ase_telefono ', '$ase_direccion', $sup_id, '$usu_login'); ";
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

 

