<?php 
session_start();
include 'config.php';

$id=$_POST['nik'];
$nama=$_POST['namaROM'];
$email=$_POST['emailROM'];
$rsc=$_POST['rsc'];

$sqlRegion = mysql_query("SELECT ith_user.usersubgroup_id FROM ith_user WHERE user_nik = '$id'");
$getData = mysql_fetch_array($sqlRegion);
$userGroupId = $getData['usergroup_id'];

if($region =='' || $region ==NULL){
    $region = $userGroupId;
}else{
    $region = $region;
}

$data = mysql_query("SELECT ith_user.usergroup_id FROM ith_user WHERE user_nik = '$id'");
$tampung = mysql_fetch_array($data);
$region = $tampung['usergroup_id'];

$sql = mysql_query("UPDATE ith_user SET udept_id='GENERAL MANAGER', userlevel_id='100', nik_atasan='', nama_atasan='DIREKSI', email_atasan='',
        nama_jabatan ='G.M.OPERATION', user_divheadname='', user_deptheadname='', email_divhead='', userrsc_code='$rsc', usergroup_id='', usersubgroup_id='', 
        departemen_id='' WHERE user_nik='$id'");
        
//Update table ith_usergroup_region
mysql_query("UPDATE ith_usergroup_region SET status_vacant = 'Yes' WHERE usergroup_kd = '$region'");       

header("location:rom.php");

if($sql){
    $_SESSION['success']=' Regional Manager ' .$nama. ' berhasil dipromosikan ';
}else{
    $_SESSION['error'] = "Mysql Error : ".mysql_error();
}
exit;

?>