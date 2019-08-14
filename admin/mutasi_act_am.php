<?php 
session_start();

include 'config.php';
$id=$_POST['user_nik'];
$rsc=$_POST['rsc'];
$region=$_POST['region'];
$area=$_POST['area'];

$sqlUserSubGroup = mysql_query("SELECT ith_user.usersubgroup_id FROM ith_user WHERE user_nik = '$id'");
$getData = mysql_fetch_array($sqsqlUserSubGroupl);
$userSubGroupId = $getData['usersubgroup_id'];

if($area =='' || $area ==NULL){
    $area = $userSubGroupId;
}else{
    $area = $area;
}

//validation insert status area
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

$udeptId = "AREA_MANAGER_".$getLastCharRegion.".".$getLastCharArea;
$namaJabatan = "AREA_MANAGER ". $getLastCharRegion."-".$getLastCharArea;

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

if($statusVacant == 'Yes'){
    $sql = mysql_query("UPDATE ith_user SET nik_atasan='$nikAtasan', nama_atasan='$namaAtasan', email_atasan='$emailAtasan', userrsc_code='$rsc', udept_id='$udeptId', 
                        nama_jabatan='$namaJabatan', usergroup_id='$region', usersubgroup_id='$area'
                         WHERE user_nik='$id'");
    //Update table ith_usergroup_region
    mysql_query("UPDATE ith_usergroup_area SET status_vacant = 'Yes' WHERE usersubgroup_kd = '$area'");

}else{
    $_SESSION['area']='Area ini belum kosong, silahkan pilih yang area lain...';
}
                
header("location:am.php");

if($sql){
    $_SESSION['success']='Area Manager' + $nama + 'berhasil dimutasi';
}else{
    $_SESSION['error'] ="Mysql error : ".mysql_error();
}
?>