<?php 
session_start();
include 'config.php';


$query = "SELECT usergroup_kd, (usergroup_kd + 1) AS RomNext FROM ith_usergroup_region ORDER BY usergroup_kd DESC";
$hasil = mysql_query($query);
$data = mysql_fetch_array($hasil);
$kode = $data['usergroup_kd'];

$kodeUrut = $kode +1;
    if($kodeUrut < 10 == true){
        $id = "000".$kodeUrut;
    }else if($kodeUrut > 10 && $kodeUrut < 100){
        $id="00".$kodeUrut;
    }else{
        $id="0".$kodeUrut;
    }

$region=$_POST['region'];
$aliasRegion=$_POST['aliasRegion'];

$sql = mysql_query("INSERT INTO ith_usergroup_region (usergroup_kd, usergroup_name, userlevel_id, usergroup_aliasname, status_vacant) 
            VALUES ('$id','$region','8','$aliasRegion', 'Yes')");
header("location:region.php");
if($sql){
$_SESSION['success']= "Data berhasil disimpan.";
}else{
    $_SESSION['error'] ="Mysql error :".mysql_error();
}

 ?>