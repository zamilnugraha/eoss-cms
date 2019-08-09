<?php 
ob_start();
if(!isset($_SESSION['username'])){
	header("location:../index.php");
}
ob_clean();
?>