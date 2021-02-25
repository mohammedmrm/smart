<?php
header('Content-type:application/json;charset=windows-1256');
require_once("dbconnection.php");
error_reporting(0);
$device = $_REQUEST["id"];
$sql = "select * from reading where meter_no=? order by date Desc limit 1";
$result = getData($con,$sql,[$device]);
$result[0]['kwh'] = $result[0]['kwh'];
echo json_encode(["data"=>$result]);
?>