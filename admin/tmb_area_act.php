<?php 
session_start();
include 'config.php';

$subArea=$_POST['subArea'];
$region=$_POST['region'];
$aliasRegion=$_POST['aliasRegion'];

$sql = mysql_query("INSERT INTO ith_usergroup_area (usersubgroup_kd, usergroup_kd, usersubgroup_name, userlevel_id, status_vacant) 
            VALUES ('$subArea','$region','$aliasRegion','3','Yes')");
header("location:area.php");
if($sql){
    $_SESSION['success']= "Data berhasil disimpan.";
}else{
    $_SESSION['error'] ="Mysql error :".mysql_error();
}
 ?>