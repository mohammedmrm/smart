<?php
header('Content-type:application/json;charset=windows-1256');
require_once("dbconnection.php");
$d_id = "1000000000";//$_REQUEST['id'];
$sql = "select * from meters where id=?";
$result = getData($con,$sql,[$d_id]);
echo json_encode(['data'=>$result]);
?>