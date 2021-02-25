<?php
header('Content-type:application/json');
session_start();
require_once("dbconnection.php");
$kwh = rand(5,35);
   $sql = "insert into reading (meter_no,kwh) values(?,?)";
   $result = setData($con,$sql,["1000000000",$kwh]);
echo $msg;
?>