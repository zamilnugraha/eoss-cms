<?php 
include 'config.php';
$id=$_GET['user_nik'];
mysql_query(" UPDATE ith_user SET user_status = 'Non Aktif' WHERE user_nik='$id'");
header("location:rom.php");

?>