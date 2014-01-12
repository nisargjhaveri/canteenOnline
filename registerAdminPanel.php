<?php
	$login=1;
	include_once('const.php');
	
	$hackDB=mysqli_connect(db_host,db_user,db_pass,db_name);
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$hackQuery="INSERT INTO `Users` (`Id`,`username`,`Name`,`password`,`userLevel`) VALUES (NULL,'".$_POST['username']."','".$_POST['name']."','".sha1($_POST['password'])."','".$_POST['type']."');";
	$result=mysqli_query($hackDB,$hackQuery);
	
	//if($result)echo "User Added";
	header('location: login.php');
	
?>
