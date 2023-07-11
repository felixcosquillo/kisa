 <?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
 include 'db_connection.php';
 
$sqllogin="SELECT usu_login,  usu_nombre	FROM  usuario where usu_rol='ASESOR' and usu_login ='$_POST[usuario]' and usu_password='$_POST[password]';";
$result = mysqli_query($conn, $sqllogin);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    echo json_encode($row);
} else {
  
    echo json_encode("ERROR: DATOS INCORRECTOS");	
}

 
mysqli_close($conn);

 
 ?>
 
 