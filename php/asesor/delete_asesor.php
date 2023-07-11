 <?php 
header('Content-Type: application/json');
include '../db_connection.php'; 
$id =  $_REQUEST['id'] ;

$sql = "delete from asesor where usu_login='$id' ";

$result = mysqli_query($conn,$sql);
if ($result){
	echo json_encode(array('success'=>true));
} else {
	echo json_encode(array('msg'=>'Some errors occured.'));
}
 ?>
 