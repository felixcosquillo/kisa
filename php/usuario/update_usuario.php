 <?php 
header('Content-Type: application/json');
include '../db_connection.php'; 
$usu_login = $_REQUEST['usu_login'];
$usu_nombre = $_REQUEST['usu_nombre'];
$usu_password = $_REQUEST['usu_password'];
$usu_rol = $_REQUEST['usu_rol'];

try {
   $sql = " UPDATE   usuario  SET usu_password='$usu_password', usu_nombre= '$usu_nombre'  , usu_rol='$usu_rol' WHERE usu_login= '$usu_login' ; ";
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

 

