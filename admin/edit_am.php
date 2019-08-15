<?php
include 'header.php';
?>
<h3><span class="glyphicon glyphicon-briefcase"></span> Edit Area Manager</h3>
<a class="btn" href="am.php"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
<?php
$kode_store = mysql_real_escape_string($_GET['user_nik']);
$det = mysql_query("SELECT * FROM ith_user WHERE user_nik='$kode_store'") or die(mysql_error());
while ($d = mysql_fetch_array($det)) {
	?>
<form action="update_am.php" method="post">
	<table class="table">
		<tr>
			<td>NIK</td>
			<td><input type="text" name="user_nik" value="<?php echo $d['user_nik'] ?>" readonly></td>
		</tr>
		<tr>
			<td>Nama Area Manager</td>
			<td><input type="text" class="form-control" name="namaAM" value="<?php echo $d['user_realname'] ?>"></td>
		</tr>
		<tr>
			<td>Email Area Manager</td>
			<td><input type="text" class="form-control" name="emailAM" value="<?php echo $d['user_email'] ?>"></td>
		</tr>
		<tr>
			<script type="text/javascript" src="jquery-1.4.2.min.js"></script>
			<td>RSC Area Manager</td>
			<td>
				<select name="rsc" id="rsc" class="form-control">
					<option value="">- Pilih RSC Area Manager -</option>

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
			<td>Region Area Manager</td>
			<td>
				<select name="region" id="region" class="form-control">
					<option value="">- Pilih Area Area Manager -</option>
				</select>
				<script>
					$("#rsc").change(function() {
						var rsc_code = $("#rsc").val();
						$("#imgLoad").show("");
						$.ajax({
							type: "POST",
							dataType: "html",
							url: "region_am.php",
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
		<tr>
			<td>Area AM</td>
			<td>
				<select name="area" id="area" class="form-control">
					<option value="">- Pilih Area AM -</option>
				</select>
				<script>
					$("#region").click(function() {
						var id_region = $("#region").val();
						$("#imgLoad").show("");
						$.ajax({
							type: "POST",
							dataType: "html",
							url: "area_am.php",
							data: "prov=" + id_region,
							success: function(msg) {
								if (msg == '') {
									alert('Tidak ada data area');
								} else {
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