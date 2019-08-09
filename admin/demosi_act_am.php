<?php 
session_start();

include 'config.php';
$id=$_POST['user_nik'];
$nama=$_POST['namaAM'];
$namaJabatan=$_POST['namaJabatan'];

    $sql = mysql_query("UPDATE ith_user SET user_realname='$nama', user_email='', userdepartement_id='OPERATIONAL_STORE', udept_id='$namaJabatan', userlevel_id='1', nik_atasan='', nama_atasan='', email_atasan='',
            nama_jabatan ='$namaJabatan', user_divheadname='', user_deptheadname='', email_divhead='', 
            departement_id='5', userunit_id='' WHERE user_nik='$id'");
            
    //Update table ith_usergroup_region
    mysql_query("UPDATE ith_usergroup_area SET status_vacant = 'No' WHERE usersubgroup_kd = '$area'");        

header("location:am.php");

if($sql){
    $_SESSION['success']='Area Manager'.$nama.'berhasil didemosikan';
}else{
    $_SESSION['error'] = "Mysql Error : ".mysql_error();
}
exit;

?>