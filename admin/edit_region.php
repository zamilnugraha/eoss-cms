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
				<td>RSC Regional 1</td>
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
				<td>RSC Regional 2</td>
				<td>
					<select class="form-control" name="rsc2">
						<?php 
						$rsc2=mysql_query("SELECT * FROM ith_userrsc");
						while($c=mysql_fetch_array($rsc2)){
							?>	
							<option <?php if($d['userrsc_code2']==$c['userrsc_code']){echo "selected"; } ?> value="<?php echo $c['userrsc_code']; ?>"><?php echo $c['userrsc_name'] ?></option>
							<?php 
						}
						?>
					</select>
				</td>
			</tr>
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