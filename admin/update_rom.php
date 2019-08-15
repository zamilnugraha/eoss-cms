<?php 
session_start();

include 'config.php';
$id=$_POST['nik'];
$nama=$_POST['namaROM'];
$email=$_POST['emailROM'];
$rsc=$_POST['rsc'];
$region=$_POST['region'];
$area=$_POST['area'];
$lantai=$_POST['lantai'];
$noHp=$_POST['noHp'];
$deputi=$_POST['deputi'];
$telephone=$_POST['telephone'];

$sqlRegion = mysql_query("SELECT ith_user.usersubgroup_id FROM ith_user WHERE user_nik = '$id'");
$getData = mysql_fetch_array($sqlRegion);
$userGroupId = $getData['usergroup_id'];

if($region =='' || $region ==NULL){
    $region = $userGroupId;
}else{
    $region = $region;
}

$sqls = mysql_query("SELECT ith_user.usersubgroup_id FROM ith_user WHERE user_nik = '$id'");
$getData = mysql_fetch_array($sqls);
$userSubGroupId = $getData['usersubgroup_id'];

//validation insert status region
$cekRegion = mysql_query("SELECT ith_usergroup_region.status_vacant FROM ith_usergroup_region
                            WHERE ith_usergroup_region.usergroup_kd ='$region'");
$getStatusRegion = mysql_fetch_array($cekRegion);
$statusVacant = $getStatusRegion['status_vacant'];

//untuk get last char
$dataRegion = mysql_query("SELECT ith_usergroup_region.usergroup_name FROM ith_usergroup_region
                            WHERE ith_usergroup_region.usergroup_kd ='$region'");
$getStatusRegion = mysql_fetch_array($dataRegion);
$regional = $getStatusRegion['usergroup_name'];
$udeptUserGroup = substr($regional, 9,2);
$udeptId = "REGIONAL_MANAGER_".$udeptUserGroup;

//untuk nama jabatan
if($deputi =='Yes'){
    $namaJabatan = "REGIONAL_MANAGER ". $udeptUserGroup. "DEPUTI"."(".$nameAlias.")";
}else{
    $namaJabatan = "REGIONAL_MANAGER ". $udeptUserGroup."(".$nameAlias.")";
}

if($statusVacant=='Yes' || $userSubGroupId == $area){
    $sql = mysql_query("UPDATE ith_user SET user_realname='$nama', udept_id='$udeptId', user_email='$email', userrsc_code='$rsc', usergroup_id='$region', 
                       nama_jabatan='$namaJabatan', lantai='$lantai', handphone='$noHp', telpon='$telephone' WHERE user_nik='$id'");
}else{
    $_SESSION['warning'] = 'Area ini belum kosong, silahkan pilih area lain...';
}
                
header("location:rom.php");

if($sql){
    $_SESSION['success']='Data berhasil updated.';
}else{
    $_SESSION['error'] = "Mysql Error : ".mysql_error();
}
exit;

?>