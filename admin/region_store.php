<?php include 'config.php'; ?>
<?php
    $sql="SELECT ith_usergroup_region.usergroup_kd, ith_usergroup_region.usergroup_aliasname FROM ith_usergroup_region
            WHERE ith_usergroup_region.userrsc_code ='".$_POST["rsc_code"]."' OR ith_usergroup_region.userrsc_code2 ='".$_POST["rsc_code"]."'";
    $q=mysql_query($sql);
    while($dataRegion=mysql_fetch_array($q)){
    ?>
        <option <?php if($_POST["rsc_code"]==$dataRegion['userrsc_code'] || $_POST["rsc_code"]==$dataRegion['userrsc_code2']) { echo "selected"; } ?> value="<?php echo $dataRegion["usergroup_kd"] ?>"><?php echo $dataRegion["usergroup_aliasname"] ?></option><br>
    <?php
    }
?>