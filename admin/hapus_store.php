<?php
session_start();
include 'config.php';
$id=$_GET['user_nik'];
$sql = mysql_query(" UPDATE ith_user SET user_status = 'Non Aktif' WHERE user_nik='$id'");
header("location:store.php");

if($save){
    $_SESSION['success']= "Data berhasil disimpan.";
}else{
    $_SESSION['error'] = mysql_error();
}
exit;
?>