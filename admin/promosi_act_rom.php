<?php 
session_start();
include 'config.php';

$id=$_POST['nik'];
$nama=$_POST['namaAM'];
$email=$_POST['emailAM'];
$rsc=$_POST['rsc'];
$region=$_POST['region'];

//validation insert status region
$cekRegion = mysql_query("SELECT ith_usergroup_region.status_vacant,ith_usergroup_region.usergroup_aliasname  FROM ith_usergroup_region
                            WHERE ith_usergroup_region.usergroup_kd ='$region'");
$getStatusRegion = mysql_fetch_array($cekRegion);
$statusVacant = $getStatusRegion['status_vacant'];
$nameAlias = $getStatusRegion['usergroup_aliasname'];

if(strlen($region) > 4){
    $udeptUserGroup = substr($region,-2,2);
}else{
    $udeptUserGroup = substr($region,-2);
}
$getLastChar = str_replace(-1,"",$udeptUserGroup);
$udeptId = "REGIONAL_MANAGER_".$getLastChar;
$namaJabatan = "ROM".$getLastChar."(".$nameAlias.")";

//Untuk mencari DivHead
$sqlDiv = mysql_query("SELECT user_nik, user_realname, user_email FROM ith_user WHERE userdepartemen_id = 'GM OPERATION' AND userlevel_id = '1000' ");
$CekNamaDiv = mysql_fetch_array($sqlDiv);
$nikDiv = $CekNamaDiv['user_nik'];
$namaDiv = $CekNamaDiv['user_realname'];
$emailDiv = $CekNamaDiv['user_email'];

//FOR userunit_id AM (Area Manager)
$userUnitAM = mysql_query("SELECT ith_userunit.userunit_id FROM ith_userunit
                            WHERE ith_userunit.userrsc_code = '$rsc' AND ith_userunit.userunit_name LIKE 'STORE%'");
$getUserUnitAM = mysql_fetch_array($cekRegion);
$userUnitId = $getUserUnitAM['userunit_id'];


if($statusVacant == 'Yes'){
    $sql = mysql_query("UPDATE ith_user SET user_realname='$nama', user_email='$email', udept_id='$udeptId', userlevel_id='8', nik_atasan='$nikDiv', nama_atasan='$namaDiv', email_atasan='$emailDiv',
            nama_jabatan ='$namaJabatan', user_divheadname='DIREKSI', user_deptheadname='$namaDiv', email_divhead='$emailDiv', userrsc_code='$rsc', usergroup_id='$region', usersubgroup_id='', 
            departemen_id='5', lantai='$lantai', handphone='$noHp', telpon='$telephone', userunit_id='$userUnitId'
            WHERE user_nik='$id'");
            
    //Update table ith_usergroup_region
    mysql_query("UPDATE ith_usergroup_region SET status_vacant = 'Yes' WHERE usergroup_kd = '$region'");        
}else{
    $_SESSION['area']='Area ini belum kosong, silahkan pilih yang area lain...';
}

header("location:am.php");

if($sql){
    $_SESSION['success']=' Area Manager ' .$nama. ' berhasil dipromosi ';
}else{
    $_SESSION['error'] = "Mysql Error : ".mysql_error();
}
exit;

?>