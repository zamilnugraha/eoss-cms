<?php
session_start();
include 'config.php';

$nik=$_POST['nik'];
$namaStore=$_POST['namaAM'];
$email=$_POST['emailAM'];
$region=$_POST['region'];
$area=$_POST['area'];
$noHp=$_POST['noHp'];
$tlp=$_POST['tlp'];
$lantai=$_POST['lantai'];
$password = md5($nik);
$rsc=$_POST['rsc'];
$tgl = date('Y-m-d h:i');
$userUnitNames = $_POST['rscName'];

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

$udeptUserGroup = substr($regional, 10,2);
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
    $save = mysql_query("INSERT INTO ith_user (user_id,user_password,user_nik,user_realname,user_email,userdepartemen_id,udept_id,user_regdate,user_joindate,
        user_lastlogindate,user_lastloginip,userstatus_id,userlevel_id,nik_atasan,nama_atasan,email_atasan,nama_jabatan,user_divheadname,user_deptheadname,
        lantai,email_divhead,departemen_id,departemen_id2,nama_departemen2,user_status,user_showpassword,telpon,handphone,userloginstatus_id,usergroup_id,
        usersubgroup_id,userrsc_code,userstoregroup_id,userunit_id)
    VALUES ('$nik','$password','$nik','$namaStore','$email','OPERATIONAL_STORE','$udeptId','$tgl','$tgl','','','1','3','$nikAtasan',
        '$namaAtasan','$emailAtasan','$namaJabatan','DIREKSI','$namaDiv','$lantai','','5','','','AKTIF','$nik','$tlp','$noHp','1',
        '$region','$area','$rsc','','$userUnitId')");
    
    //Update table ith_usergroup_region
    mysql_query("UPDATE ith_usergroup_area SET status_vacant = 'No' WHERE usersubgroup_kd = '$area'");

}else{
    $_SESSION['area']="Area ini belum kosong, silahkan pilih yang area lain...";
}
header("location:am.php");

if($save){
    $_SESSION['success']= "Data berhasil disimpan.";
}else{
    $_SESSION['error'] = mysql_error();
}
ob_flush();
?>