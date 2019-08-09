<?php include 'config.php'; ?>
<?php
    $sql="SELECT ith_usergroup_area.usersubgroup_kd, ith_usergroup_area.usersubgroup_name,ith_usergroup_area.status_vacant FROM ith_usergroup_area 
            WHERE ith_usergroup_area.usergroup_kd ='".$_POST["prov"]."'";
    $q=mysql_query($sql);
    while($dataArea=mysql_fetch_array($q)){

        if($dataArea["status_vacant"] == "No"){
            $output = "Not Vacant";
        }else{
            $output = "Vacant";
        }
    ?>
        <option <?php if($_POST["prov"]==$dataArea['usergroup_kd'] && $dataArea['usersubgroup_kd']==$dataArea['usersubgroup_kd']) { echo "selected"; } ?> value="<?php echo $dataArea["usersubgroup_kd"] ?>"><?php echo $dataArea["usersubgroup_name"] ?>  (<?php echo $output;?>)</option><br>
    <?php
    }
?>