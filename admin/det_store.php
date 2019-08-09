<?php 
include 'header.php';
?>

<h3><span class="glyphicon glyphicon-briefcase"></span>  Detail Store</h3>
<a class="btn" href="store.php"><span class="glyphicon glyphicon-arrow-left"></span>  Kembali</a>

<?php
$kode_store=mysql_real_escape_string($_GET['user_nik']);
$det=mysql_query("SELECT DISTINCT
					ITH_USER.user_nik,
					ITH_USER.user_realname,
					ITH_USER.user_email,
					ITH_USER.usergroup_id,
					ITH_USERGROUP.usergroup_name,
					ITH_USER.usersubgroup_id,
					ITH_USERGROUP.usersubgroup_name,
					ITH_USER.userdepartemen_id,
					ITH_USER.udept_id,
					ITH_USER.nik_atasan,
					ITH_USER.nama_atasan,
					ITH_USER.user_deptheadname,
					ITH_USER.nama_jabatan,
					ITH_USER.departemen_id,
					ITH_USER.user_status,
					ITH_DEPARTEMEN.nama_departemen,
					ITH_USER.userlevel_id,
					ITH_USERLEVEL.userlevel_name
				FROM
					ITH_USER
				JOIN ITH_USERGROUP ON ITH_USERGROUP.usergroup_kd = ITH_USER.usergroup_id
				JOIN ITH_DEPARTEMEN ON ITH_DEPARTEMEN.kode_departemen = ITH_USER.departemen_id
				JOIN ITH_USERLEVEL ON ITH_USERLEVEL.userlevel_id = ITH_USER.userlevel_id
				WHERE
					ITH_USER.udept_id = 'STORE'
				AND ITH_USER.user_nik = '$kode_store'
				GROUP BY
					ITH_USER.usergroup_id,
					ITH_USER.usersubgroup_id,
					ITH_USER.USER_REALNAME
				ORDER BY
					ITH_USER.usergroup_id,
					ITH_USER.usersubgroup_id,
					ITH_USER.USER_REALNAME ASC ")or die(mysql_error());
while($d=mysql_fetch_array($det)){
	?>					
	<table class="table">
		<tr>
			<td>Kode Store</td>
			<td><?php echo $d['user_nik'] ?></td>
		</tr>
		<tr>
			<td>Nama Store</td>
			<td><?php echo $d['user_realname'] ?></td>
		</tr>
		<tr>
			<td>Email Store</td>
			<td><?php echo $d['user_email'] ?></td>
		</tr>
		<tr>
			<td>Regional Store</td>
			<td><?php echo $d['usergroup_name']; ?></td>
		</tr>
		<tr>
			<td>Area Store</td>
			<td><?php echo $d['usersubgroup_name'] ?></td>
		</tr>
		<tr>
			<td>Nama Departement</td>
			<td><?php echo $d['userdepartemen_id'] ?></td>
		</tr>
		<tr>
			<td>NIK Atasan Store</td>
			<td><?php echo $d['nik_atasan'] ?></td>
		</tr>
		<tr>
			<td>Nama Atasan</td>
			<td><?php echo $d['nama_atasan'] ?></td>
		</tr>
		<tr>
			<td>Jabatan</td>
			<td><?php echo $d['nama_jabatan'] ?></td>
		</tr>
	</table>
	<?php 
}
?>
<?php include 'footer.php'; ?>