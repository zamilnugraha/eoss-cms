<?php include 'header.php'; ?>

<h3><span class="glyphicon glyphicon-briefcase"></span>  Data Store</h3>
<button style="margin-bottom:20px" data-toggle="modal" data-target="#myModal" class="btn btn-info col-md-2"><span class="glyphicon glyphicon-plus"></span>Tambah Store</button>
<br/>
<br/>

<?php 
$per_hal=10;
$jumlah_record=mysql_query("SELECT COUNT(*) from ith_user");
$jum=mysql_result($jumlah_record, 0);
$halaman=ceil($jum / $per_hal);
$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $per_hal;
?>

<form action="cari_act_store.php" method="get">
	<div class="input-group col-md-5 col-md-offset-7">
		<span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-search"></span></span>
		<input type="text" class="form-control" placeholder="Cari di sini .." aria-describedby="basic-addon1" name="cari">	
	</div>
</form>
<br/>
<table class="table table-hover">
	<?php
		if($_SESSION['success'] ==NULL && $_SESSION['error']==NULL){
	?>
	<div class="alert" style="display: none;">
		<span class="closebtn">&times;</span>  
		<strong>Danger !</strong>
		<?php
			echo $_SESSION['result'];
		?>
	</div>
	<?php }elseif($_SESSION['error'] !=NULL){ ?>
		<div class="alert">
		<span class="closebtn">&times;</span>  
		<strong>Danger !</strong>
		<?php
			echo $_SESSION['error'];
			unset($_SESSION['error']);
		?>
	<?php }elseif($_SESSION['success'] !=NULL){ ?>
		<div class="alert success">
		<span class="closebtn">&times;</span>  
		<strong>Success !</strong>
		<?php
			echo $_SESSION['success'];
			unset($_SESSION['success']);
		?>
	<?php } ?>
	<tr>
		<th class="col-md-1">NIK</th>
		<th class="col-md-3">Nama Store</th>
		<th class="col-md-1">Email</th>
		<th class="col-md-2">Nama Atasan</th>
		<th class="col-md-2">Nama Dept.Head</th>
		<th class="col-md-1">Status</th>
		<th class="col-md-1">Opsi</th>
	</tr>
	<?php 
	if(isset($_GET['cari'])){
		$cari=mysql_real_escape_string($_GET['cari']);
		$brg=mysql_query("SELECT DISTINCT
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
		AND ITH_USER.nama_jabatan = 'STORE'
		AND (ITH_USER.user_nik LIKE '%$cari%'
		OR ITH_USER.user_realname LIKE '%$cari%'
		OR ITH_USER.user_deptheadname LIKE '%$cari%'
		OR ITH_USER.nama_atasan LIKE '%$cari%')
		AND ITH_USER.user_status = 'AKTIF'
	GROUP BY
		ITH_USER.usergroup_id,
		ITH_USER.usersubgroup_id,
		ITH_USER.USER_REALNAME
	ORDER BY
		ITH_USER.usergroup_id,
		ITH_USER.usersubgroup_id,
		ITH_USER.USER_REALNAME ASC limit $start, $per_hal");
	}else{
		$brg=mysql_query("SELECT DISTINCT
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
		AND ITH_USER.user_status = 'AKTIF'
	GROUP BY
		ITH_USER.usergroup_id,
		ITH_USER.usersubgroup_id,
		ITH_USER.USER_REALNAME
	ORDER BY
		ITH_USER.usergroup_id,
		ITH_USER.usersubgroup_id,
		ITH_USER.USER_REALNAME ASC limit $start, $per_hal");
	}
	$no=$start + 1;
	while($b=mysql_fetch_array($brg)){

		?>
		<tr>
			<td><?php echo $b['user_nik'] ?></td>
			<td><?php echo $b['user_realname'] ?></td>
			<td><?php echo $b['user_email'] ?></td>
			<td><?php echo $b['nama_atasan'] ?></td>
			<td><?php echo $b['user_deptheadname'] ?></td>
			<td><?php echo $b['user_status'] ?></td>
			<td>
				<a href="det_store.php?user_nik=<?php echo $b['user_nik']; ?>"><span class="glyphicon glyphicon-arrow-up" title="Detail"></a>
				<a href="edit_store.php?user_nik=<?php echo $b['user_nik']; ?>"><span class="glyphicon glyphicon-edit" title="Edit"></a>
				<a onclick="if(confirm('Apakah anda yakin ingin menghapus data ini ??')){ location.href='hapus_store.php?id=<?php echo $b['id']; ?>' }"><span class="glyphicon glyphicon-trash" title="Edit"></a>
			</td>
		</tr>		
		<?php 
		 $no++;
	}
	?>
</table>
<ul class="pagination">		
	<?php
		if($page == 1){ // Jika page adalah page ke 1, maka disable link PREV
	?>
	<li class="disabled"><a href="#">First</a></li>
	<li class="disabled"><a href="#">&laquo;</a></li>
	<?php
		}else{ // Jika page bukan page ke 1
		$link_prev = ($page > 1)? $page - 1 : 1;
	?>
	<li><a href="store.php?page=1">First</a></li>
	<li><a href="store.php?page=<?php echo $link_prev; ?>">&laquo;</a></li>
	<?php
		}
	?>
	
	<!-- LINK NUMBER -->
	<?php
        // Buat query untuk menghitung semua jumlah data
        $sql2 = mysql_query("SELECT COUNT(*) AS jumlah FROM ith_user WHERE usergroup_id ='0006' AND user_status <> 'Non Aktif'");
        $get_jumlah = mysql_fetch_array($sql2);
        
        $jumlah_page = ceil($get_jumlah['jumlah'] / $per_hal); // Hitung jumlah halamannya
        $jumlah_number = 3; // Tentukan jumlah link number sebelum dan sesudah page yang aktif
        $start_number = ($page > $jumlah_number)? $page - $jumlah_number : 1; // Untuk awal link number
        $end_number = ($page < ($jumlah_page - $jumlah_number))? $page + $jumlah_number : $jumlah_page; // Untuk akhir link number
        
        for($i = $start_number; $i <= $end_number; $i++){
          $link_active = ($page == $i) ? 'class="active"' : '';
        ?>
          <li <?php echo $link_active; ?>><a href="store.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
        <?php
        }
        ?>
        
        <!-- LINK NEXT AND LAST -->
        <?php
        // Jika page sama dengan jumlah page, maka disable link NEXT nya
        // Artinya page tersebut adalah page terakhir 
        if($page == $jumlah_page){ // Jika page terakhir
        ?>
          <li class="disabled"><a href="#">&raquo;</a></li>
          <li class="disabled"><a href="#">Last</a></li>
        <?php
        }else{ // Jika Bukan page terakhir
          $link_next = ($page < $jumlah_page)? $page + 1 : $jumlah_page;
        ?>
          <li><a href="store.php?page=<?php echo $link_next; ?>">&raquo;</a></li>
          <li><a href="store.php?page=<?php echo $jumlah_page; ?>">Last</a></li>
        <?php
        }
    ?>
</ul>

<style>
	.alert {
		padding: 20px;
		background-color: #f44336;
		color: white;
		opacity: 1;
		transition: opacity 0.6s;
		margin-bottom: 15px;
	}

	.alert.success {background-color: #4CAF50;}
	.alert.info {background-color: #2196F3;}
	.alert.warning {background-color: #ff9800;}

	.closebtn {
		margin-left: 15px;
		color: white;
		font-weight: bold;
		float: right;
		font-size: 22px;
		line-height: 20px;
		cursor: pointer;
		transition: 0.3s;
	}

	.closebtn:hover {
	color: black;
	}
</style>

<script>
	var close = document.getElementsByClassName("closebtn");
	var i;

	for (i = 0; i < close.length; i++) {
	close[i].onclick = function(){
		var div = this.parentElement;
		div.style.opacity = "0";
		setTimeout(function(){ div.style.display = "none"; }, 20000);
		}
	}
</script>

<!-- modal input -->
<div id="myModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Tambah Store Baru</h4>
			</div>
			<div class="modal-body">
				<form action="tmb_store_act.php" method="post">
					<div class="form-group">
						<label>Kode Store</label>
						<input name="nik" type="text" class="form-control" placeholder="NIK .." Required>
					</div>
					<div class="form-group">
						<label>Nama Store</label>
						<input name="namaStore" type="text" class="form-control" placeholder="Nama Store .." Required>
					</div>
					<div class="form-group">
						<label>Email Store</label>
						<input name="emailStore" type="text" class="form-control" placeholder="Email Store .." Required>
					</div>
					<div class="form-group">
						<script type="text/javascript" src="jquery-1.4.2.min.js"></script>
								<label>RSC Store</label> 
								<select name="rsc" id="rsc" class="form-control">
									<option value="">- Pilih RSC Store -</option>
								
									<!-- looping data region -->
									<?php
										$sel_rsc="SELECT ith_userrsc.userrsc_code,ith_userrsc.userrsc_name FROM ith_userrsc";
										$q=mysql_query($sel_rsc);
										while($dataRsc=mysql_fetch_array($q)){
									?>
										<option value="<?php echo $dataRsc["userrsc_code"] ?>"><?php echo $dataRsc["userrsc_name"] ?></option>
								
									<?php
										}
									?>
								</select>
								<label>Region Store</label> 
								<select name="region" id="region" class="form-control">
									<option value="">- Pilih Region Store -</option>
								</select>
								<script>
									$("#rsc").change(function(){
										var rsc_code = $("#rsc").val();
										$("#imgLoad").show("");
										$.ajax({
											type: "POST",
											dataType: "html",
											url: "region_store.php",
											data: "rsc_code=" + rsc_code,
											success: function(msg){
												if(msg == ''){
													alert('Tidak ada data region');
												}else{
													$("#region").html(msg);                                                     
												}
												$("#imgLoad").hide();
											}
										});    
									});
							</script>
							<label>Area Store</label> 
							<select name="area" id="area" class="form-control">
								<option value="">- Pilih Area Store -</option>
							</select>
							<script>
								$("#region").click(function(){
									var id_region = $("#region").val();
									$("#imgLoad").show("");
									$.ajax({
										type: "POST",
										dataType: "html",
										url: "areaStore.php",
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
					</div>
					<div class="form-group">
						<label>Ruangan/Lantai</label>
						<input name="lantai" type="number" class="form-control"  min="0" placeholder="Ruangan/lantai .." Required>
					</div>
					<div class="form-group">
						<label>No.Hp</label>
						<input name="noHp" type="number" class="form-control"  min="0" placeholder="No Hp .." Required>
					</div>
					<div class="form-group">
						<label>Telephone</label>
						<input name="tlp" type="number" class="form-control"  min="0" placeholder="Telephone .." Required>
					</div>
					<div class="form-group">
						<div class="col-sm-10 col-sm-offset-2">
							<?php echo $result; ?>    
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
						<input type="submit" class="btn btn-primary" value="Simpan">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<?php 
include 'footer.php';

?>