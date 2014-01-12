<?php
	include_once('const.php');

	$hackDB=mysqli_connect(db_host,db_user,db_pass,db_name);
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
		
	if(isset($_POST['del'])){
		$hackQuery="DELETE FROM `ItemsAvail` WHERE `Id`='".$_POST['id']."'";
		$result=mysqli_query($hackDB,$hackQuery);
	}
	else if(isset($_POST['edit'])){
		$hackQuery="UPDATE `ItemsAvail` SET `ItemName`='".$_POST['item']."',`Price`='".$_POST["price"]."',`isVeg`='".(($_POST["isVeg"]==1)?1:0)."' WHERE `Id`='".$_POST['id']."';";	
		$result=mysqli_query($hackDB,$hackQuery);
	}
	if(isset($_POST['add'])){
		$hackQuery="INSERT INTO `ItemsAvail` (`Id`,`ItemName`,`Price`,`isVeg`,`CanteenId`) VALUES (NULL,'".$_POST['item']."','".$_POST["price"]."','".(($_POST["isVeg"]==1)?1:0)."','0')";	
		$result=mysqli_query($hackDB,$hackQuery);
	}
	
	header('location: MenuEdit.php');
	/*$hackDB=mysqli_connect(db_host,db_user,db_pass,db_name);
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}*/
	
?>
