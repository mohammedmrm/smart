<?php
header('Content-type:application/json;charset=windows-1256');
require_once("script/dbconnection.php");
//error_reporting(0);
$kwh  = $_REQUEST['kwh']; //ECG


$username = $_REQUEST['u']; //usersname
$password = $_REQUEST['p']; //password

$dev = $_REQUEST['meter_no']; //device id

$msg = 'error';
try{
// checking usernsme and password
if(empty($username) || empty($password)){
  $msg = "All Fields are required";
}else{

  $sql = "select * from users where email = ? or phone=? ";
  $result = getData($con,$sql,[$username,$username]);
  if(count($result) != 1 || !password_verify($password,$result[0]['password']) ){
    $msg = "Incorect Username Or Password";
  }else{
    $msg = 1;
    $_SESSION['login']=1;
    $_SESSION['username']=$result[0]['phone'];
    $_SESSION['userid']=$result[0]['id'];
    $_SESSION['role']=$result[0]['role'];
    $_SESSION['user_details']=$result[0];
  }
}
//if login ok continue
if($msg == 1){
   $sql = "insert into reading (meter_no,kwh) values(?,?)";
   $result = setData($con,$sql,[$dev,$kwh]);
   if($result == 1){
    $msg = "data recorded";
   }
   echo json_encode(['msg'=>$msg]);
}else{
  echo json_encode(['msg'=>$msg]);
}
}catch(PDOException $ex){
    $msg=["error"=>$ex];
}
?>