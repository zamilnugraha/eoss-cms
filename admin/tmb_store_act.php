<?php 
session_start();
include 'config.php';

$nik=$_POST['nik'];
$namaStore=$_POST['namaStore'];
$email=$_POST['emailStore'];
$region=$_POST['region'];
$area=$_POST['area'];
$noHp=$_POST['noHp'];
$tlp=$_POST['tlp'];
$lantai=$_POST['lantai'];
$password = md5($nik);
$rsc=$_POST['rsc'];
$tgl = date('Y-m-d h:i');

//Untuk mencari data area
$sql  = mysql_query("SELECT DISTINCT
                        ITH_USER.user_nik,
                        ITH_USER.user_realname,
                        ITH_USER.user_email
                    FROM
                        ITH_USER
                    WHERE
                        ITH_USER.udept_id LIKE 'AREA_MANAGER_%' AND 
                        usergroup_id = '$region' AND 
                        usersubgroup_id = '$area'
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

//Untuk mencari data DeptHead
$sqlDept = mysql_query("SELECT user_nik, user_realname FROM ith_user WHERE usergroup_id = '$region' AND userlevel_id = '8' ");
$CekNamaDept = mysql_fetch_array($sqlDept);
$nikDept = $CekNamaDept['user_nik'];
$namaDept = $CekNamaDept['user_realname'];

//Untuk mencari DivHead
$sqlDiv = mysql_query("SELECT user_nik, user_realname, user_email FROM ith_user WHERE userdepartemen_id = 'GM OPERATION' AND userlevel_id = '1000' ");
$CekNamaDiv = mysql_fetch_array($sqlDiv);
$nikDiv = $CekNamaDiv['user_nik'];
$namaDiv = $CekNamaDiv['user_realname'];
$emailDiv = $CekNamaDiv['user_email'];

//Untuk mencari nama Regional Asli
$groupName=mysql_query("SELECT ith_usergroup_region.usergroup_name FROM ith_usergroup_region WHERE usergroup_kd = '$region'");
$getUserGroupName = mysql_fetch_array($groupName);
$userGroupNames = $getUserGroupName['usergroup_name'];

//Untuk mencari nama Area Asli
$subGroupName=mysql_query("SELECT ith_usergroup_area.usersubgroup_name FROM ith_usergroup_area WHERE usersubgroup_kd = '$area' AND usergroup_kd = '$region'");
$getUserSubGroupName = mysql_fetch_array($subGroupName);
$userSubGroupNames = $getUserSubGroupName['usersubgroup_name'];

$save = mysql_query("INSERT INTO ith_user ( 
        user_id,
        user_password,
        user_nik,
        user_realname,
        user_email,
        userdepartemen_id,
        udept_id,
        user_regdate,
        user_joindate,
        user_lastlogindate,
        user_lastloginip,
        userstatus_id,
        userlevel_id,
        nik_atasan,
        nama_atasan,
        email_atasan,
        nama_jabatan,
        user_divheadname,
        user_deptheadname,
        lantai,
        email_divhead,
        departemen_id,
        departemen_id2,
        nama_departemen2,
        user_status,
        user_showpassword,
        telpon,
        handphone,
        userloginstatus_id,
        usergroup_id,
        usersubgroup_id,
        userrsc_code,
        userstoregroup_id,
        userunit_id)
    VALUES (
        '$nik',
        '$password',
        '$nik',
        '$namaStore',
        '$email',
        'OPERATIONAL_STORE',
        'STORE',
        '$tgl',
        '$tgl',
        '',
        '',
        '1',
        '1',
        '$nikAtasan',
        '$namaAtasan',
        '$emailAtasan',
        'STORE',
        '$namaDiv',
        '$namaDept',
        '$lantai',
        '$emailDiv',
        '5',
        '',
        '',
        'AKTIF',
        '$nik',
        '$tlp',
        '$noHp',
        '1',
        '$region',
        '$area',
        '$rsc',
        '',
        '')");

//QUERY INSERT ITH_USERGROUP_STORE
$save2 = mysql_query("INSERT INTO ith_usergroup_store (usergroup_kd, usersubgroup_kd, usersubgroup2_kd, usersubgroup2_name, userlevel_id)
            VALUES('$region', '$area', '$nik', '$namaStore', '1')");

//QUERY INSERT ITH_USERGROUP
$save3 = mysql_query("INSERT INTO ith_usergroup (usergroup_kd, usersubgroup_kd, usersubgroup2_kd, userlevel_id, usergroup_name, usersubgroup_name, usersubgroup2_name)
            VALUES('$region', '$area', '$nik', '1', '$userGroupNames', '$userSubGroupNames', '$namaStore')");

header("location:store.php");

if($save && $save2 && $save3){
    $_SESSION['success']= "Data berhasil disimpan.";
}else{
    $_SESSION['error'] = mysql_error();
}
exit;
?>