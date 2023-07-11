 <?php 

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');

include '../db_connection.php'; 
$id =  $_REQUEST['id'] ;

$sql = "delete from lugar_visita where lug_id='$id' ";

$result = mysqli_query($conn,$sql);
if ($result){
	echo json_encode(array('success'=>true));
} else {
	echo json_encode(array('msg'=>'Some errors occured.'));
}
 ?>
 