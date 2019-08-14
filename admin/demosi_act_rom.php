<?php
session_start();
include 'config.php';

$nik=$_POST['nik'];
$namaStore=$_POST['namaROM'];
$email=$_POST['emailROM'];
$region=$_POST['region'];
$area=$_POST['area'];
$rsc=$_POST['rsc'];
$tgl = date('Y-m-d h:i');

$sqlUserSubGroup = mysql_query("SELECT ith_user.usersubgroup_id FROM ith_user WHERE user_nik = '$id'");
$getData = mysql_fetch_array($sqsqlUserSubGroupl);
$userSubGroupId = $getData['usersubgroup_id'];

if($area =='' || $area ==NULL){
    $area = $userSubGroupId;
}else{
    $area = $area;
}

//Untuk mencari data area
$sql  = mysql_query("SELECT DISTINCT
                        ITH_USER.user_nik,
                        ITH_USER.user_realname,
                        ITH_USER.user_email
                    FROM
                        ITH_USER
                    WHERE
                        ITH_USER.udept_id LIKE 'REGIONAL_MANAGER_%'
                        AND ITH_USER.usergroup_id = '$region'
                    GROUP BY
                        ITH_USER.usergroup_id,
                        ITH_USER.usersubgroup_id,
                        ITH_USER.USER_REALNAME
                    ORDER BY
                        ITH_USER.usergroup_id,
                        ITH_USER.usersubgroup_id,
                        ITH_USER.USER_REALNAME ASC");
$CekNamaAtasan = mysql_fetch_array($sql);
$nikAtasan =  $CekNamaAtasan['user_nik'];
$namaAtasan =  $CekNamaAtasan['user_realname'];
$emailAtasan = $CekNamaAtasan['user_email'];

//Untuk mencari DivHead
$sqlDiv = mysql_query("SELECT user_nik, user_realname, user_email FROM ith_user WHERE userdepartemen_id = 'GM OPERATION' AND userlevel_id = '1000' ");
$CekNamaDiv = mysql_fetch_array($sqlDiv);
$nikDiv = $CekNamaDiv['user_nik'];
$namaDiv = $CekNamaDiv['user_realname'];

//Untuk mencari nama Regional Asli
$groupName=mysql_query("SELECT ith_usergroup_region.usergroup_name FROM ith_usergroup_region WHERE usergroup_kd = '$region'");
$getUserGroupName = mysql_fetch_array($groupName);
$userGroupNames = $getUserGroupName['usergroup_name'];

//Untuk mencari nama Area Asli
$subGroupName=mysql_query("SELECT ith_usergroup_area.usersubgroup_name FROM ith_usergroup_area WHERE usersubgroup_kd = '$area' AND usergroup_kd = '$region'");
$getUserSubGroupName = mysql_fetch_array($subGroupName);
$userSubGroupNames = $getUserSubGroupName['usersubgroup_name'];

//validation insert status region
$cekRegion = mysql_query("SELECT ith_usergroup_area.status_vacant FROM ith_usergroup_area
                            WHERE ith_usergroup_area.usersubgroup_kd = '$area' AND ith_usergroup_area.usergroup_kd ='$region'");
$getStatusRegion = mysql_fetch_array($cekRegion);
$statusVacant = $getStatusRegion['status_vacant'];

//untuk get last char
$dataRegion = mysql_query("SELECT ith_usergroup_region.usergroup_name FROM ith_usergroup_region
                            WHERE ith_usergroup_region.usergroup_kd ='$region'");
$getStatusRegion = mysql_fetch_array($dataRegion);
$regional = $getStatusRegion['usergroup_name'];
$udeptUserGroup = substr($regional, 9,2);
$udeptUserSubGroup = substr($area, -2);

if($udeptUserSubGroup < 10){
    $getLastCharArea = str_replace('0',"",$udeptUserSubGroup);
}else{
    $getLastCharArea = $udeptUserSubGroup;
}

$udeptId = "AREA_MANAGER_".$udeptUserGroup.".".$getLastCharArea;
$namaJabatan = "AREA_MANAGER ". $udeptUserGroup."-".$getLastCharArea;

//FOR userunit_id AM (Area Manager)
$userUnitAM = mysql_query("SELECT ith_userunit.userunit_id FROM ith_userunit
                            WHERE ith_userunit.userrsc_code = '$rsc' AND ith_userunit.userunit_name LIKE 'STORE%'");
$getUserUnitAM = mysql_fetch_array($userUnitAM);
$userUnitId = $getUserUnitAM['userunit_id'];

if($statusVacant == 'Yes'){
    $save = mysql_query("UPDATE ith_user SET udept_id='$udeptId', userlevel_id='3', nik_atasan='$nikAtasan', nama_atasan='$namaAtasan', email_atasan='$emailAtasan', 
                            nama_jabatan='$namaJabatan', user_deptheadname='$namaDiv', usergroup_id='$region', usersubgroup_id='$area', userrsc_code='$rsc', userunit_id='$userUnitId' 
                        WHERE user_nik='$nik'");
    
    //Update table ith_usergroup_region
    mysql_query("UPDATE ith_usergroup_region SET status_vacant = 'Yes' WHERE usergroup_kd = '$region'");

}else{
    $_SESSION['area']="Area ini belum kosong, silahkan pilih yang area lain...";
}
header("location:rom.php");

if($save){
    $_SESSION['success']= "Data berhasil disimpan.";
}else{
    $_SESSION['error'] = mysql_error();
}
ob_flush();
?>