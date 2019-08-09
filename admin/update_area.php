<?php 
session_start();
include 'config.php';

$id=$_POST['usergroup_id'];
$id_region=$_POST['usergroup_kd'];
$id_area=$_POST['usersubgroup_kd'];
$area=$_POST['area'];

$sql = mysql_query("UPDATE ith_usergroup_area set usergroup_kd = '$id_region', usersubgroup_kd = '$id_area', usersubgroup_name = '$area' WHERE usergroup_id='$id'");
header("location:area.php");
if($sql){
    $_SESSION['success']= "Data berhasil update.";
}else{
    $_SESSION['error'] ="Mysql error :".mysql_error();
}
?>