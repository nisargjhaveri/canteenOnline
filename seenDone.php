<?php
	include_once("const.php");
	
	if(isset($_GET['seen']) && $_GET['seen']!=0){
		echo 'seen';
		$hackDB=mysqli_connect(db_host,db_user,db_pass,db_name);
		if (mysqli_connect_errno()){
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		$hackQuery="UPDATE `Order` SET `seen`=1 WHERE `Id`=".$_GET['Id']."";
		$result=mysqli_query($hackDB,$hackQuery);
	}
	else if(isset($_GET['done']) && $_GET['done']!=0){
		echo 'done';
		$hackDB=mysqli_connect(db_host,db_user,db_pass,db_name);
		if (mysqli_connect_errno()){
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		$hackQuery="UPDATE `Order` SET `done`=1 WHERE `Id`=".$_GET['Id']."";
		$result=mysqli_query($hackDB,$hackQuery);
	}
	else{
		print_r($_GET);
	}
	
?>
