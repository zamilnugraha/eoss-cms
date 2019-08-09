<?php 
include 'header.php';
?>
<h3><span class="glyphicon glyphicon-briefcase"></span>  Edit Area Manager</h3>
<a class="btn" href="rom.php"><span class="glyphicon glyphicon-arrow-left"></span>  Kembali</a>
<?php
	$ids=mysql_real_escape_string($_GET['user_nik']);
	$detw=mysql_query("SELECT * FROM ith_user WHERE user_nik='$ids'");
	$d=mysql_fetch_array($detw);
	$deputi = $d['nama_jabatan'];
	if(preg_match("/DEPUTI/", $deputi)) {
		$checked = 'Yes';
	} else {
		$checked = 'No';
	}
?>

<?php
$nik=mysql_real_escape_string($_GET['user_nik']);
$det=mysql_query("SELECT * FROM ith_user WHERE user_nik='$nik'")or die(mysql_error());
while($d=mysql_fetch_array($det)){
?>					
	<form action="update_rom.php" method="post">
		<table class="table">
			<tr>
				<td>NIK</td>
				<td><input type="text" class="form-control" name="nik" value="<?php echo $d['user_nik'] ?>" readonly></td>
			</tr>
			<tr>
				<td>Nama Area Manager</td>
				<td><input type="text" class="form-control" name="namaROM" value="<?php echo $d['user_realname'] ?>"></td>
			</tr>
			<tr>
				<td>Email Area Manager</td>
				<td><input type="text" class="form-control" name="emailROM" value="<?php echo $d['user_email'] ?>"></td>
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
				<script type="text/javascript" src="jquery-1.4.2.min.js"></script>
				<td>Region Store</td>
				<td>
					<select name="region" id="region" class="form-control">
						<option value="">- Pilih Region Store -</option>
					
						<!-- looping data region -->
						<?php
							$sel_prov="SELECT ith_usergroup_region.usergroup_kd,ith_usergroup_region.usergroup_aliasname, ith_usergroup_region.status_vacant 
											FROM ith_usergroup_region";
							$q=mysql_query($sel_prov);
							while($data_prov=mysql_fetch_array($q)){
								if($data_prov["status_vacant"] == "No"){
									$output = "Not Vacant";
								}else{
									$output = "Vacant";
								}
						?>
							<option <?php if($d['usergroup_id']==$data_prov['usergroup_kd']){echo "selected"; } ?> value="<?php echo $data_prov["usergroup_kd"] ?>"><?php echo $data_prov["usergroup_aliasname"] ?> (<?php echo $output;?>)</option>
					
						<?php
							}
						?>
					</select>
				</td> 
			</tr>
			<tr class="form-group">
				<td>Regional Manager Deputi..?</td>
				<td>
					<input type="radio" name="deputi" value="Yes" <?php if ($checked == 'Yes') {echo ' checked ';} ?> Required>Yes
					<input type="radio" name="deputi" value="No" <?php if ($checked == 'No') {echo ' checked ';} ?> Required>No
				</td>
			</tr>
			<tr style="display:none;">		
				<td>Area Store</td>
				<td>
					<select name="area" id="area" class="form-control">
						<option value="">- Pilih Area Store -</option>
					</select>
					<script>
						$("#region").change(function(){
							var id_region = $("#region").val();
							$("#imgLoad").show("");
							$.ajax({
								type: "POST",
								dataType: "html",
								url: "area_am.php",
								data: "prov="+id_region,
								success: function(msg){
									if(msg == ''){
										alert('Tidak ada data area');
									}else{
										$("#area").html(msg);                                                     
									}
									$("#imgLoad").hide();
								}
							});    
						});
					</script>
				</td> 				
			</tr>
			<tr>
				<td>Ruangan/Lantai</td>
				<td><input type="text" class="form-control" name="lantai" value="<?php echo $d['lantai'] ?>"></td>
			</tr>
			<tr>
				<td>No. Hp</td>
				<td><input type="text" class="form-control" name="noHp" value="<?php echo $d['handphone'] ?>"></td>
			</tr>
			<tr>
				<td>Telephone</td>
				<td><input type="text" class="form-control" name="telephone" value="<?php echo $d['telpon'] ?>"></td>
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