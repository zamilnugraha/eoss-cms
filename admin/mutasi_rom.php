<?php
include 'header.php';
?>
<h3><span class="glyphicon glyphicon-briefcase"></span> Mutasi Regional Manager</h3>
<a class="btn" href="rom.php"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
<?php
$nik = mysql_real_escape_string($_GET['user_nik']);
$det = mysql_query("SELECT * FROM ith_user WHERE user_nik='$nik'") or die(mysql_error());
while ($d = mysql_fetch_array($det)) {
	?>
<form action="mutasi_act_am.php" method="post">
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
			<script type="text/javascript" src="jquery-1.4.2.min.js"></script>
			<td>RSC Regional Manager</td>
			<td>
				<select name="rsc" id="rsc" class="form-control">
					<option value="">- Pilih RSC Regional Manager -</option>

					<!-- looping data region -->
					<?php
						$sel_prov = "SELECT ith_userrsc.userrsc_code,ith_userrsc.userrsc_name FROM ith_userrsc";
						$q = mysql_query($sel_prov);
						while ($data_prov = mysql_fetch_array($q)) {
							?>
					<option <?php if ($d['userrsc_code'] == $data_prov['userrsc_code']) {
										echo "selected";
									} ?> value="<?php echo $data_prov["userrsc_code"] ?>"><?php echo $data_prov["userrsc_name"] ?></option>

					<?php
						}
						?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Region Regional Manager</td>
			<td>
				<select name="region" id="region" class="form-control">
					<option value="">- Pilih Regional ROM -</option>
				</select>
				<script>
					$("#rsc").change(function() {
						var rsc_code = $("#rsc").val();
						$("#imgLoad").show("");
						$.ajax({
							type: "POST",
							dataType: "html",
							url: "region_rom.php",
							data: "rsc_code=" + rsc_code,
							success: function(msg) {
								if (msg == '') {
									alert('Tidak ada data region');
								} else {
									$("#region").html(msg);
								}
								$("#imgLoad").hide();
							}
						});
					});
				</script>
			</td>
		</tr>
		<tr class="form-group">
			<td>Regional Manager Deputi..?</td>
			<td>
				<input type="radio" name="deputi" value="Yes" Required>Yes
				<input type="radio" name="deputi" value="No" Required>No
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