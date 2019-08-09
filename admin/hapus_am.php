<?php 
include 'config.php';
$id=$_GET['user_nik'];
mysql_query(" update ith_user set user_status = 'Non Aktif' where user_nik='$id'");
header("location:store.php");

?>