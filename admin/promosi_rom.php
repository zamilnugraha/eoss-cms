<?php 
include 'header.php';
?>
<h3><span class="glyphicon glyphicon-briefcase"></span>  Promosi Regional Manager</h3>
<a class="btn" href="rom.php"><span class="glyphicon glyphicon-arrow-left"></span>  Kembali</a>
<?php
$nik=mysql_real_escape_string($_GET['user_nik']);
$det=mysql_query("SELECT * FROM ith_user WHERE user_nik='$nik'")or die(mysql_error());
while($d=mysql_fetch_array($det)){
?>					
	<form action="promosi_act_am.php" method="post">
		<table class="table">
			<tr>
				<td>NIK</td>
				<td><input type="text" class="form-control" name="nik" value="<?php echo $d['user_nik'] ?>" readonly></td>
			</tr>
			<tr>
				<td>Nama Regional Manager</td>
				<td><input type="text" class="form-control" name="namaROM" value="<?php echo $d['user_realname'] ?>" readonly></td>
			</tr>
			<tr>
				<td>Email Regional Manager</td>
				<td><input type="text" class="form-control" name="emailROM" value="<?php echo $d['user_email'] ?>" readonly></td>
			</tr>
			<tr>
				<td>RSC Store</td>
				<td>
					<select class="form-control" name="rsc">
						<?php 
						$brg=mysql_query("SELECT * FROM ith_userrsc");
						while($b=mysql_fetch_array($brg)){
							?>	
							<option <?php if($d['userrsc_code']==$b['userrsc_code']){echo "selected"; } ?> value="<?php echo $b['userrsc_code']; ?>"><?php echo $b['userrsc_name'] ?></option>
							<?php 
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" class="btn btn-info" value="Simpan"></td>
			</tr>
		</table>
	</form>
	<?php 
}
?>
<?php include 'footer.php'; ?>