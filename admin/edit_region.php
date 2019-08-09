<?php 
include 'header.php';
?>
<h3><span class="glyphicon glyphicon-briefcase"></span>  Edit Region</h3>
<a class="btn" href="region.php"><span class="glyphicon glyphicon-arrow-left"></span>  Kembali</a>
<?php
$id_region=mysql_real_escape_string($_GET['usergroup_kd']);
$det=mysql_query("SELECT * FROM ith_usergroup_region WHERE usergroup_kd='$id_region'") or die (mysql_error());
while($d=mysql_fetch_array($det)){
?>					
	<form action="update_region.php" method="post">
		<table class="table">
			<tr>
				<td></td>
				<td><input type="hidden" name="usergroup_kd" value="<?php echo $d['usergroup_kd'] ?>"></td>
			</tr>
			<tr>
				<td>Nama Region</td>
				<td><input type="text" class="form-control" name="region" value="<?php echo $d['usergroup_name'] ?>"></td>
			</tr>
			<tr>
				<td>Nama Alias Region</td>
				<td><input type="text" class="form-control" name="aliasRegion" value="<?php echo $d['usergroup_aliasname'] ?>"></td>
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