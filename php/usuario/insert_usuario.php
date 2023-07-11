 <?php 
header('Content-Type: application/json');
include '../db_connection.php'; 
$usu_login = $_REQUEST['usu_login'];
$usu_nombre = $_REQUEST['usu_nombre'];
$usu_password = $_REQUEST['usu_password'];
$usu_rol = $_REQUEST['usu_rol'];
try {
   $sql = "INSERT INTO  usuario (usu_login, usu_password, usu_nombre ,usu_rol) VALUES('$usu_login', '$usu_password', '$usu_nombre' , '$usu_rol'); ";
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

 

