<?php 
ob_start();
if(!isset($_SESSION['uname'])){
	header("location:../index.php");
}
ob_clean();
?>