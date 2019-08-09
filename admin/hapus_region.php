<?php 
session_start();
include 'config.php';
$id=$_GET['usergroup_kd'];
$sql = mysql_query(" DELETE FROM ith_usergroup_region WHERE usergroup_kd='$id'");
header("location:region.php");

if($sql){
    $_SESSION['success']= "Data berhasil dihapus.";
    }else{
        $_SESSION['error'] ="Mysql error :".mysql_error();
    }

?>