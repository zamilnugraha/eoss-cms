<?php 
include 'header.php';
?>
<h3><span class="glyphicon glyphicon-briefcase"></span>  Demosi Area Manager</h3>
<a class="btn" href="am.php"><span class="glyphicon glyphicon-arrow-left"></span>  Kembali</a>
<?php
$nik=mysql_real_escape_string($_GET['user_nik']);
$det=mysql_query("SELECT * FROM ith_user WHERE user_nik='$nik'")or die(mysql_error());
while($d=mysql_fetch_array($det)){
?>					
	<form action="demosi_act_am.php" method="post">
		<table class="table">
			<tr>
				<td>NIK</td>
				<td><input type="text" name="user_nik" value="<?php echo $d['user_nik'] ?>" disabled="disabled"></td>
			</tr>
			<tr>
				<td>Nama Area Manager</td>
				<td><input type="text" class="form-control" name="namaAM" value="<?php echo $d['user_realname'] ?>" disabled="disabled"></td>
			</tr>
			<tr>
				<td>Jabatan Demosi</td>
				<td>
					<select class="form-control" name="namaJabatan">	
                        <option value="">- Pilih jabatan -</option>
                        <option value="RESTAURANT MANAGER">RESTAURANT MANAGER</option>
                        <option value="ASST. RESTAURANT MANAGER">ASST. RESTAURANT MANAGER</option>
                        <option value="SHIFT LEADER">SHIFT LEADER</option>
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