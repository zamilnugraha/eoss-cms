<?php include 'header.php'; ?>

<h3><span class="glyphicon glyphicon-briefcase"></span>  Data Region</h3>
<button style="margin-bottom:20px" data-toggle="modal" data-target="#myModalRegion" class="btn btn-info col-md-2"><span class="glyphicon glyphicon-plus"></span>Tambah Region</button>
<br/>
<br/>

<?php 
$per_hal=10;
$jumlah_record=mysql_query("SELECT COUNT(*) from ith_usergroup_region");
$jum=mysql_result($jumlah_record, 0);
$halaman=ceil($jum / $per_hal);
$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $per_hal;
?>

<form action="cari_act_region.php" method="get">
	<div class="input-group col-md-5 col-md-offset-7">
		<span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-search"></span></span>
		<input type="text" class="form-control" placeholder="Cari region di sini .." aria-describedby="basic-addon1" name="cari">	
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
		<th class="col-md-4">Regional</th>
		<th class="col-md-4">Nama Alias Regional</th>
		<th class="col-md-1">Opsi</th>
	</tr>
	<?php 
	if(isset($_GET['cari'])){
		$cari=mysql_real_escape_string($_GET['cari']);
		$brg=mysql_query("select * from ith_usergroup_region where usergroup_name like '%$cari%' or usergroup_aliasname like '%$cari%'");
	}else{
		$brg=mysql_query("select * from ith_usergroup_region limit $start, $per_hal");
	}
	$no=$start + 1;
	while($b=mysql_fetch_array($brg)){

		?>
		<tr>
			<td><?php echo $b['usergroup_name'] ?></td>
			<td><?php echo $b['usergroup_aliasname'] ?></td>
			<td>
				<a href="edit_region.php?usergroup_kd=<?php echo $b['usergroup_kd']; ?>"><span class="glyphicon glyphicon-edit" title="Edit"></a>
				<a onclick="if(confirm('Apakah anda yakin ingin menghapus data ini ??')){ location.href='hapus_region.php?usergroup_kd=<?php echo $b['usergroup_kd']; ?>' }"><span class="glyphicon glyphicon-trash" title="Hapus"></a>
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
	<li><a href="region.php?page=1">First</a></li>
	<li><a href="region.php?page=<?php echo $link_prev; ?>">&laquo;</a></li>
	<?php
		}
	?>
	
	<!-- LINK NUMBER -->
	<?php
        $sql2 = mysql_query("SELECT COUNT(*) AS jumlah FROM ith_usergroup_region");
        $get_jumlah = mysql_fetch_array($sql2);
        
        $jumlah_page = ceil($get_jumlah['jumlah'] / $per_hal); // Hitung jumlah halamannya
        $jumlah_number = 3; // Tentukan jumlah link number sebelum dan sesudah page yang aktif
        $start_number = ($page > $jumlah_number)? $page - $jumlah_number : 1; // Untuk awal link number
        $end_number = ($page < ($jumlah_page - $jumlah_number))? $page + $jumlah_number : $jumlah_page; // Untuk akhir link number
        
        for($i = $start_number; $i <= $end_number; $i++){
          $link_active = ($page == $i) ? 'class="active"' : '';
        ?>
          <li <?php echo $link_active; ?>><a href="region.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
        <?php
        }
        ?>
        
        <!-- LINK NEXT AND LAST -->
        <?php
        if($page == $jumlah_page){ // Jika page terakhir
        ?>
          <li class="disabled"><a href="#">&raquo;</a></li>
          <li class="disabled"><a href="#">Last</a></li>
        <?php
        }else{ // Jika Bukan page terakhir
          $link_next = ($page < $jumlah_page)? $page + 1 : $jumlah_page;
        ?>
          <li><a href="region.php?page=<?php echo $link_next; ?>">&raquo;</a></li>
          <li><a href="region.php?page=<?php echo $jumlah_page; ?>">Last</a></li>
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
<div id="myModalRegion" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Tambah Region Baru</h4>
			</div>
			<div class="modal-body">
				<form action="tmb_region_act.php" method="post">
					<div class="form-group">
						<label>Nama Region</label>
						<input name="region" type="text" class="form-control" placeholder="Nama Region .." Required>
					</div>
					<div class="form-group">
						<label>Nama Alias Region</label>
						<input name="aliasRegion" type="text" class="form-control" placeholder="Nama Alias Region .." Required>
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



<?php 
include 'footer.php';

?>