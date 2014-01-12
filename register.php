!DOCTYPE html>
<html>
<head>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<title>Unauthorized Access: Canteen Order</title>
	<script>
			window.setTimeout(function(){
				window.location.href='login.php';
			},5000);

	</script>
<link rel="stylesheet" type="text/css" href="MessUI.css">
</head>
<body>
<div id="container">
	<table id="links" width='100%'>
		<tr>
			<td style="font-family:'Trebuchet MS', sans-serif, Helvetica; font-size: 20px;"><div style='display:inline;' class='button'  onclick='window.location.href="login.php";'>Log in</div></td>
		</tr>
	</table>
	<div id="left">
		  Juice Canteen Online
	</div>
	<div id="uAccess">
<?php
	$login=1;
	include_once('const.php');
	
	$hackDB=mysqli_connect(db_host,db_user,db_pass,db_name);
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$hackQuery="INSERT INTO `Users` (`Id`,`username`,`Name`,`password`,`userLevel`) VALUES (NULL,'".$_POST['username']."','".$_POST['name']."','".sha1($_POST['password'])."','user');";
	$result=mysqli_query($hackDB,$hackQuery);
	
	//if($result)echo "User Added";
	echo '<p>You have been registered. It\'ll take about 5 seconds.</p>';
	//header('location: login.php');
	
?>
</div>
</div>
</body>
</html>
