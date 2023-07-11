 <?php 
header('Content-Type: application/json');
include '../db_connection.php'; 
$sup_id = $_REQUEST['id'];
$sup_cedula = $_REQUEST['sup_cedula'];
$sup_nombre = $_REQUEST['sup_nombre'];
$sup_telefono = $_REQUEST['sup_telefono'];
$sup_direccion = $_REQUEST['sup_direccion'];
$usu_login = $_REQUEST['usu_login'];

try {
   $sql = "UPDATE  supervisor   SET sup_cedula='$sup_cedula', sup_nombre='$sup_nombre', sup_telefono='$sup_telefono', sup_direccion='$sup_direccion', usu_login='$usu_login'   WHERE sup_id='$sup_id ';
    ";
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

 

