<?php 
include 'header.php';
?>

<?php 
	session_start();
	if($_SESSION['status']!="login"){
		header("location:../index.php?pesan=belum_login");
	}
?>
    
<div class="col-md-10">
	<h1 align="center">E-USER MANAGEMENT SYSTEM</h1>	
    <h3 align="center">Welcome To The Electronic User Management System</h3>


    <h1 align="center">
        <span class="glyphicon glyphicon-user">
        <span class="glyphicon glyphicon-user">
        <span class="glyphicon glyphicon-user">
        <span class="glyphicon glyphicon-user">
        <span class="glyphicon glyphicon-user">
    </h1>
</div>
<div class="pull-right">
	<div id="kalender">
    </div>
</div>

<?php 
include 'footer.php';
?>