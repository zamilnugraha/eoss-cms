<?php 
session_start();

include 'config.php';

$id = $_POST['nik'];
$nama = $_POST['namaROM'];
$rsc=$_POST['rsc'];
$region=$_POST['region'];

//Untuk mencari DivHead
$sqlDiv = mysql_query("SELECT user_nik, user_realname, user_email FROM ith_user WHERE userdepartemen_id = 'GM OPERATION' AND userlevel_id = '1000' ");
$CekNamaDiv = mysql_fetch_array($sqlDiv);
$nikDiv = $CekNamaDiv['user_nik'];
$namaDiv = $CekNamaDiv['user_realname'];
$emailDiv = $CekNamaDiv['user_email'];

//untuk get last char
$dataRegion = mysql_query("SELECT ith_usergroup_region.usergroup_name FROM ith_usergroup_region
                            WHERE ith_usergroup_region.usergroup_kd ='$region'");
$getStatusRegion = mysql_fetch_array($dataRegion);
$regional = $getStatusRegion['usergroup_name'];
$udeptUserGroup = substr($regional, 10,2);

$udeptId = "REGIONAL_MANAGER_".$udeptUserGroup;

//untuk nama jabatan
if($deputi =='Yes'){
    $namaJabatan = "ROM ". $udeptUserGroup. "DEPUTI"."(".$nameAlias.")";
}else{
    $namaJabatan = "ROM ". $udeptUserGroup."(".$nameAlias.")";
}


//validation insert status region
$cekRegion = mysql_query("SELECT ith_usergroup_region.status_vacant FROM ith_usergroup_region
                            WHERE ith_usergroup_region.usergroup_kd ='$region'");
$getStatusRegion = mysql_fetch_array($cekRegion);
$statusVacant = $getStatusRegion['status_vacant'];

if($statusVacant == 'Yes'){
    $sql = mysql_query("UPDATE ith_user SET nik_atasan='$nikDiv', nama_atasan='$namaDiv', userrsc_code='$rsc', nama_jabatan='$namaJabatan', udept_id='$udeptId', usergroup_id='$region',
                        email_atasan='$emailDiv' WHERE user_nik='$id'");
    //Update table ith_usergroup_region
    mysql_query("UPDATE ith_usergroup_region SET status_vacant = 'Yes' WHERE usergroup_kd = '$region'");

}else{
    $_SESSION['area']='Region ini belum kosong, silahkan pilih Region yang lain...';
}
                
header("location:rom.php");

if($sql){
    $_SESSION['success']='Regional Manager '.$nama.' berhasil dimutasi';
}else{
    $_SESSION['error'] = mysql_error();
}
exit;

?>