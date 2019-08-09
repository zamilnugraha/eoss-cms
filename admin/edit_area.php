<?php 
include 'header.php';
?>
<h3><span class="glyphicon glyphicon-briefcase"></span>  Edit Region</h3>
<a class="btn" href="region.php"><span class="glyphicon glyphicon-arrow-left"></span>  Kembali</a>
<?php
$id_area=mysql_real_escape_string($_GET['usergroup_id']);
$det=mysql_query("SELECT * FROM ith_usergroup_area WHERE usergroup_id='$id_area'") or die (mysql_error());
while($d=mysql_fetch_array($det)){
?>					
	<form action="update_area.php" method="post">
		<table class="table">
			<tr>
				<td></td>
				<td><input type="hidden" name="usergroup_id" value="<?php echo $d['usergroup_id'] ?>"></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="hidden" name="usergroup_kd" value="<?php echo $d['usergroup_kd'] ?>"></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="hidden" name="usersubgroup_kd" value="<?php echo $d['usersubgroup_kd'] ?>"></td>
			</tr>
			<tr>
				<td>Nama Area</td>
				<td><input type="text" class="form-control" name="area" value="<?php echo $d['usersubgroup_name'] ?>"></td>
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