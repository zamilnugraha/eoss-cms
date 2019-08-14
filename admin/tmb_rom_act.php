<?php
session_start();
include 'config.php';

$nik=$_POST['nik'];
$namaStore=$_POST['namaROM'];
$email=$_POST['emailROM'];
$region=$_POST['region'];
$noHp=$_POST['noHp'];
$tlp=$_POST['tlp'];
$lantai=$_POST['lantai'];
$password = md5($nik);
$rsc=$_POST['rsc'];
$deputi=$_POST['deputi'];
$tgl = date('Y-m-d h:i');
$userUnitNames = $_POST['rscName'];

//Untuk mencari DivHead
$sqlDiv = mysql_query("SELECT user_nik, user_realname, user_email FROM ith_user WHERE userdepartemen_id = 'GM OPERATION' AND userlevel_id = '1000' ");
$CekNamaDiv = mysql_fetch_array($sqlDiv);
$nikDiv = $CekNamaDiv['user_nik'];
$namaDiv = $CekNamaDiv['user_realname'];
$emailDiv = $CekNamaDiv['user_email'];

//validation insert status region
$cekRegion = mysql_query("SELECT ith_usergroup_region.status_vacant FROM ith_usergroup_region
                            WHERE ith_usergroup_region.usergroup_kd ='$region'");
$getStatusRegion = mysql_fetch_array($cekRegion);
$statusVacant = $getStatusRegion['status_vacant'];
$nameAlias = $getStatusRegion['usergroup_aliasname'];

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

//FOR userunit_id ROM (Regional Manager)
$userUnitAM = mysql_query("SELECT ith_userunit.userunit_id FROM ith_userunit
                            WHERE ith_userunit.userrsc_code = '$rsc' AND ith_userunit.userunit_name LIKE 'STORE%'");
$getUserUnitAM = mysql_fetch_array($userUnitAM);
$userUnitId = $getUserUnitAM['userunit_id'];

if($statusVacant == 'Yes'){
    $save = mysql_query("INSERT INTO ith_user (user_id,user_password,user_nik,user_realname,user_email,userdepartemen_id,udept_id,user_regdate,user_joindate,
        user_lastlogindate,user_lastloginip,userstatus_id,userlevel_id,nik_atasan,nama_atasan,email_atasan,nama_jabatan,user_divheadname,user_deptheadname,
        lantai,email_divhead,departemen_id,departemen_id2,nama_departemen2,user_status,user_showpassword,telpon,handphone,userloginstatus_id,usergroup_id,
        usersubgroup_id,userrsc_code,userstoregroup_id,userunit_id)
    VALUES ('$nik','$password','$nik','$namaStore','$email','OPERATIONAL_STORE','$udeptId','$tgl','$tgl','','','1','8','$nikDiv',
        '$namaDiv','$emailDiv','$namaJabatan','DIREKSI','$namaDiv','$lantai','','5','','','AKTIF','$nik','$tlp','$noHp','1',
        '$region','','$rsc','','$userUnitId')");
    
    //Update table ith_usergroup_region
    mysql_query("UPDATE ith_usergroup_region SET status_vacant = 'No' WHERE usergroup_kd = '$region'");

}else{
    $_SESSION['region']="Region ini belum kosong, silahkan pilih yang region lain...";
}
header("location:rom.php");

if($save){
    $_SESSION['success']= "Data berhasil disimpan.";
}else{
    $_SESSION['error'] ="Mysql error : ".mysql_error();
}
?>