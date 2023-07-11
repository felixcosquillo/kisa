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
 $sql="select lv.lug_id,o.obs_id , s.sup_nombre , a.ase_nombre  ,
 lug_nombre, lv.lug_hora_inicio, lv.lug_hora_fin  , o.obs_fecha_hora  , o.obs_texto  from lugar_visita lv
 inner join asesor a on ( a.ase_id = lv.ase_id )
 inner join supervisor s on (a.sup_id  = s.sup_id  )
 inner join observacion o on ( lv.lug_id = o.lug_id  )";
 $rs = mysqli_query( $conn,$sql); 
 $items = array();
 while($row = mysqli_fetch_object($rs)){
    array_push($items, $row);
 }
 $result["rows"] = $items;
 echo json_encode($result);
 ?>