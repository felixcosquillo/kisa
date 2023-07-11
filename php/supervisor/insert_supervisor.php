 <?php 
header('Content-Type: application/json');
include '../db_connection.php'; 
$sup_cedula = $_REQUEST['sup_cedula'];
$sup_nombre = $_REQUEST['sup_nombre'];
$sup_telefono = $_REQUEST['sup_telefono'];
$sup_direccion = $_REQUEST['sup_direccion'];
$usu_login = $_REQUEST['usu_login'];
 

try {

   if (!empty($usu_login)) 
   $sql = "INSERT INTO  supervisor   (sup_cedula, sup_nombre, sup_telefono, sup_direccion, usu_login)   VALUES('$sup_cedula', '$sup_nombre', '$sup_telefono', '$sup_direccion', '$usu_login'); ";
else
   $sql = "INSERT INTO  supervisor   (sup_cedula, sup_nombre, sup_telefono, sup_direccion)   VALUES('$sup_cedula', '$sup_nombre', '$sup_telefono', '$sup_direccion'); ";

   $result = @mysqli_query($conn, $sql);
   if ($result){
      echo json_encode(array('success'=>true));
   } else {
      echo json_encode(array('msg'=>'Some errors occured.'));
   }
 } catch (Exception $e) {
   echo json_encode(array('errorMsg'=>'Some errors occured.' + $e));
 }

 ?>

 

