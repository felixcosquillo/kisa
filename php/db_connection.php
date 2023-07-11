<?php 
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$db = "kisa";
$conn = mysqli_connect($dbhost, $dbuser, $dbpass,$db) ; 
if (!$conn) {    
    echo json_encode(mysqli_connect_error());
}
?>

 
