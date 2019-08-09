<?php 
include 'config.php';

$id=$_GET['usergroup_id'];
mysql_query("DELETE FROM ith_usergroup_area WHERE usergroup_id='$id'");
header("location:area.php");

?>