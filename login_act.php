<?php 
session_start();
include 'admin/config.php';
$uname=$_POST['username'];
$pass=$_POST['password'];
$pas=md5($pass);
$query=mysql_query("SELECT * FROM ith_user WHERE user_nik='$uname' AND user_password='$pas' AND user_status = 'AKTIF'") or die (mysql_error());
$Cek = mysql_num_rows($query);
$data = mysql_fetch_array($query);

if($Cek > 0){
	$_SESSION['username']=$uname;
	$_SESSION['usergroup_id'] = $data['usergroup_id'];
	$_SESSION['usersubgroup_id'] = $data['usersubgroup_id'];
	$_SESSION['user_realname']=$data['user_realname'];
	$_SESSION['status'] = "login";
	header("location:admin/index.php");
}else{
	header("location:index.php?pesan=gagal") or die (mysql_error());
}
 ?>