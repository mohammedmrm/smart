<?php
header('Content-type:application/json');
session_start();
require_once("dbconnection.php");
$device = "1000000000";
$sql = "select * from  reading where meter_no=? order by date DESC limit 150";
$result = getData($con,$sql,[$device]);

$data = [];
$sub_array = [];
$rows = [];
$table['cols'] = [
  [
  'label' => 'Date Time',
  'type' => 'string'
 ],[
  'label' => 'ECG',
  'type' => 'number'
 ],[
  'label' => 'Average',
  'type' => 'number'
 ]

];
$sql = "select avg(kwh) as avg from reading where meter_no=? order by id DESC limit 150";
$avgres = getData($con,$sql,[$device]);
$avg = $avgres[0]['avg'];
foreach($result as $k=>$val){
     $sub_array[] =  array(
      "v" => date("H:s",strtotime($val['date'])),
     );
     $sub_array[] =  array(
      "v" => $val['kwh'],
      );
     $sub_array[] =  array(
      "v" => $avg,
      );
    $rows[] =  array(
     "c" => $sub_array
    );
    $sub_array=[];
}
$table['rows'] = $rows;
echo json_encode($table);
?>
