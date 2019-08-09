<?php 
session_start();

include 'config.php';
$id=$_POST['user_nik'];
$nama=$_POST['namaAM'];
$email=$_POST['emailAM'];
$rsc=$_POST['rsc'];
$region=$_POST['region'];
$area=$_POST['area'];
$lantai=$_POST['lantai'];
$noHp=$_POST['noHp'];
$telephone=$_POST['telephone'];

$sql = mysql_query("SELECT ith_user.usersubgroup_id FROM ith_user WHERE user_nik = '$id'");
$getData = mysql_fetch_array($sql);
$userSubGroupId = $getData['usersubgroup_id'];

//Untuk mencari data area
$sqlROM  = mysql_query("SELECT DISTINCT
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
$CekNamaAtasan = mysql_fetch_array($sqlROM);
$nikAtasan =  $CekNamaAtasan['user_nik'];
$namaAtasan =  $CekNamaAtasan['user_realname'];
$emailAtasan = $CekNamaAtasan['user_email'];

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

$udeptUserGroup = substr($regional, 10,2);
$udeptUserSubGroup = substr($area, -2);

if($udeptUserSubGroup < 10){
    $getLastCharArea = str_replace('0',"",$udeptUserSubGroup);
}else{
    $getLastCharArea = $udeptUserSubGroup;
}

$udeptId = "AREA_MANAGER_".$udeptUserGroup.".".$getLastCharArea;
$namaJabatan = "AREA_MANAGER ". $udeptUserGroup."-".$getLastCharArea;

if($statusVacant=='Yes' || $userSubGroupId == $area){
    $sql = mysql_query("UPDATE ith_user SET user_realname='$nama', udept_id='$udeptId', nama_jabatan='$namaJabatan', user_email='$email', userrsc_code='$rsc', usergroup_id='$region', 
                        nik_atasan='$nikAtasan', nama_atasan='$namaAtasan', email_atasan='$emailAtasan', usersubgroup_id='$area', lantai='$lantai', handphone='$noHp', telpon='$telephone' WHERE user_nik='$id'");
}else{
    $_SESSION['warning'] = 'Area ini belum kosong, silahkan pilih area lain...';
}
                
header("location:am.php");

if($sql){
    $_SESSION['success']='Data berhasil updated.';
}else{
    $_SESSION['error'] = "Mysql Error : ".mysql_error();
}
exit;

?>