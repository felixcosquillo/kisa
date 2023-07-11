 <?php 
header('Content-Type: application/json');
include '../db_connection.php'; 
 $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
 $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
 $offset = ($page-1)*$rows;
 $result = array(); 
 $rs = mysqli_query( $conn,"select count(*) from usuario");
 $row = mysqli_fetch_row($rs);
 $result["total"] = $row[0];
 $sql="select usu_login ,  usu_nombre  ,usu_rol from usuario limit $offset,$rows";
 $rs = mysqli_query( $conn,$sql); 
 $items = array();
 while($row = mysqli_fetch_object($rs)){
    array_push($items, $row);
 }
 $result["rows"] = $items;
 echo json_encode($result);
 ?>