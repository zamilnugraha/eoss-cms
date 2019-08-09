<!DOCTYPE html>
<html>
<head>
	<title>E-USER MANAGEMENT SYSTEM</title>
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/js/jquery-ui/jquery-ui.css">
	<script type="text/javascript" src="assets/js/jquery.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap.js"></script>
	<script type="text/javascript" src="assets/js/jquery-ui/jquery-ui.js"></script>
	<?php include 'admin/config.php'; ?>
	<style type="text/css">
	.kotak{	
		margin-top: 100px;
	}

	.kotak .input-group{
		margin-bottom: 20px;
	}
	</style>
</head>

<div>
	<h1 align="center">E-USER MANAGEMENT SYSTEM</h1>	
	<h3 align="center">Welcome To The Electronic User Management System</h3>
</div>
<body>	
	<div class="container">
		<?php 
		if(isset($_GET['pesan'])){
			if($_GET['pesan'] == "gagal"){
				echo "<div style='margin-bottom:-55px' class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-warning-sign'></span>  Login Gagal !! Username dan Password Salah !!</div>";
			}else if($_GET['pesan'] == "logout"){
				echo "<div style='margin-bottom:-55px' class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-warning-sign'></span>  Anda telah berhasil logout !!</div>";
			}else if($_GET['pesan'] == "belum_login"){
				echo "<div style='margin-bottom:-55px' class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-warning-sign'></span>  Anda harus login untuk mengakses halaman admin !!</div>";
			}
		}

		?>
		<div class="panel panel-default">
			<form action="login_act.php" method="post">
				<div class="col-md-4 col-md-offset-4 kotak">
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
						<input type="text" class="form-control" placeholder="NIK..." name="username">
					</div>
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
						<input type="password" class="form-control" placeholder="Password..." name="password">
					</div>
					<div class="input-group">			
						<input type="submit" class="tombol_login" value="Login">
					</div>
				</div>
			</form>
		</div>
	</div>

	<style>
		.tombol_login{
			background: #2aa7e2;
			color: white;
			font-size: 11pt;
			width: 260%;
			border: none;
			border-radius: 3px;
			padding: 10px 49px;
		}
	</style>
</body>
</html>