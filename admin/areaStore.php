<?php include 'config.php'; ?>
<?php
    $sql="SELECT ith_usergroup_area.usersubgroup_kd, ith_usergroup_area.usersubgroup_name FROM ith_usergroup_area WHERE ith_usergroup_area.usergroup_kd ='".$_POST["prov"]."'";
    $q=mysql_query($sql);
    while($dataArea=mysql_fetch_array($q)){
    ?>
        <option <?php if($dataArea['usergroup_kd']==$dataArea['usergroup_kd']){echo "selected"; } ?> value="<?php echo $dataArea["usersubgroup_kd"] ?>"><?php echo $dataArea["usersubgroup_name"] ?></option><br>
    <?php
    }
?>