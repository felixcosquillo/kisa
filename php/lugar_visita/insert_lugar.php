 <?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');

include '../db_connection.php'; 
$lug_nombre = $_POST['lug_nombre'];
$lug_direccion = $_POST['lug_direccion']; 
$ase_id = $_POST['ase_id'];
$lug_longitud = $_POST['lug_longitud'];
$lug_latitud = $_POST['lug_latitud'];
$lug_ruta = $_POST['lug_ruta'];
$lug_cliente= $_POST['lug_cliente'];
try {   
   $sql = "INSERT INTO  lugar_visita   (fecha, lug_nombre, lug_direccion,  ase_id,lug_latitud,lug_longitud,lug_ruta,lug_activo,lug_cliente)   VALUES(current_timestamp() , '$lug_nombre ', '$lug_direccion',  $ase_id ,$lug_latitud,$lug_longitud ,'$lug_ruta','1','$lug_cliente');    ";
 
   $result = @mysqli_query($conn, $sql);
   if ($result){
      echo json_encode(array('success'=>true));
   } else {
      echo json_encode(array('msg'=>'Some errors occured.' + $sql));
   }
 } catch (Exception $e) {
   echo json_encode(array('errorMsg'=>     $sql  ));
 }

 ?>

 

