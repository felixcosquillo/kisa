 <?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
include '../db_connection.php'; 
 
$sqllogin="select ase_id ,ase_nombre  from asesor  where usu_login  ='$_POST[usuario]' ;";
$result = mysqli_query($conn, $sqllogin);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    echo json_encode($row);
} else {
  
    echo json_encode("ERROR: DATOS INCORRECTOS");	
}

 
mysqli_close($conn);

 
 ?>
 
 