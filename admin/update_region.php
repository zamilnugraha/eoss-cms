<?php 
session_start();
include 'config.php';
$id_region=$_POST['usergroup_kd'];
$region=$_POST['region'];
$aliasRegion=$_POST['aliasRegion'];

$sql = mysql_query("UPDATE ith_usergroup_region set usergroup_name = '$region', usergroup_aliasname = '$aliasRegion' WHERE usergroup_kd='$id_region'");
header("location:region.php");
if($sql){
    $_SESSION['success']= "Data berhasil update.";
    }else{
        $_SESSION['error'] ="Mysql error :".mysql_error();
    }
?>