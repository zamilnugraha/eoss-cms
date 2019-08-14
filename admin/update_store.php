<?php 
include 'config.php';
$id=$_POST['user_nik'];
$nama=$_POST['namaStore'];
$email=$_POST['emailStore'];
$rsc=$_POST['rsc'];
$region=$_POST['region'];
$area=$_POST['area'];
$lantai=$_POST['lantai'];
$noHp=$_POST['noHp'];
$telephone=$_POST['telephone'];

$sql = mysql_query("SELECT ith_user.usersubgroup_id FROM ith_user WHERE user_nik = '$id'");
$getData = mysql_fetch_array($sql);
$userSubGroupId = $getData['usersubgroup_id'];

if($area =='' || $area ==NULL){
    $area = $userSubGroupId;
}else{
    $area = $area;
}

$save = mysql_query("UPDATE ith_user SET user_realname='$nama', user_email='$email', userrsc_code='$rsc', usergroup_id='$region', usersubgroup_id='$area', lantai='$lantai',
                handphone='$noHp', telpon='$telephone' WHERE user_nik='$id'");
                
header("location:store.php");

if($save){
    $_SESSION['success']= "Data berhasil diupdate.";
}else{
    $_SESSION['error'] = mysql_error();
}

?>