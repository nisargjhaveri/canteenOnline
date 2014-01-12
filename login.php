<?php
	$login=1;
	include_once('const.php');
	
	if(isset($_POST['login'])){
		$hackDB=mysqli_connect(db_host,db_user,db_pass,db_name);
		if (mysqli_connect_errno()){
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		$hackQuery="SELECT * FROM `Users` WHERE `username`='".$_POST['username']."' AND `password`='".sha1($_POST['password'])."';";
		$result=mysqli_query($hackDB,$hackQuery);
		if(mysqli_num_rows($result) > 0) {
			session_regenerate_id();
			$user = mysqli_fetch_assoc($result);
			$_SESSION['username']=$user['username'];
			$_SESSION['userlevel']=$user['userLevel'];
			$_SESSION['Name']=$user['Name'];
			$username=$_SESSION['username'];
			$userlevel=$_SESSION['userlevel'];
			$logged=1;
		}
		else {
			//Error
		?>
<!DOCTYPE html>
<html>
<head>
	<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
	<title>Canteen Order Login</title>
	<script></script>
	<link rel='stylesheet' type='text/css' href='MessUI.css'>
</head>
<body>
	<div id='container'>
		<div id='left'>
			 Juice Canteen Online Order
		</div>
		<div style='text-align:right;'><input type='button' class='button' id='register' value='Register' style='margin-top:40px;margin-right:40px;' onclick='window.location.href="Register.html"' /></div>
		<form method='post' action='login.php'>
		<table id='login'>
			<tr><td style='color:red;'>Username or Password incorrect</td></tr>
			<tr>
				<td><font size='6'>Username:</td><td><input type='text' name='username' placeholder='Enter Username' required style='font-size: 18px;' size='20' maxlength='30'>
				</font></td>
			</tr>
			<tr>
				<td><font size='6'>Password:</td><td style="text-align:center;"><input type='password' name='password' placeholder='Enter Password' required style='font-size: 18px;' size='20' maxlength='30'>
				</font></td>
			</tr>
		</table>
		<table id='btn'>
			<tr><td><input type='submit' name='login' class='button' id='login' value='Log In'></td></tr>
			<tr><td></td></tr>
		</table>
		</form>
	</div>
</body>
</html>
<?php
exit();
		}
	}
	if(isset($_GET['logout'])){
		unset($_SESSION['username']);
		unset($_SESSION['userlevel']);
		unset($_SESSION['Name']);
		unset($username);
		unset($userlevel);
		$logged=0;
		header('location:logout.html');
	}
	
	if(isset($username)){
		//echo "You are already logged in as ".$username;
		if($userlevel=='user'){
			header('location: MessUI.php');
		}
		else {
			header('location: MessBack.php');
		}
		exit;
	}
	else {
		//Login Form
	?>
<!DOCTYPE html>
<html>
<head>
	<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
	<title>Canteen Order Login</title>
	<script></script>
	<link rel='stylesheet' type='text/css' href='MessUI.css'>
</head>
<body>
	<div id='container'>
		<div id='left'>
			 Juice Canteen Online Order
		</div>
		<div style='text-align:right;'><input type='button' class='button' id='register' value='Register' style='margin-top:40px;margin-right:40px;' onclick='window.location.href="Register.html"' /></div>
		<form method='post' action='login.php'>
		<table id='loginTable'>
			<tr>
				<td><font size='6'>Username: <input type='text' name='username' placeholder='Enter Username' required style='font-size: 18px;' size='20' maxlength='30'>
				</font></td>
			</tr>
			<tr>
				<td><font size='6'>Password: <input type='password' name='password' placeholder='Enter Password' required style='font-size: 18px;' size='20' maxlength='30'>
				</font></td>
			</tr>
		</table>
		<table id='btn'>
			<tr><td><input type='submit' name='login' class='button' id='login' value='Log In'></td></tr>
			<tr><td></td></tr>
		</table>
		</form>
	</div>
</body>
</html>
<?php
	}
	
	//INSERT INTO `hackCanteen`.`Users` (`Id`, `username`, `Name`, `password`, `userLevel`) VALUES (NULL, 'nisargjhaveri', 'Nisarg Jhaveri', '62f0411ab6818352086d07c773efed6c1ba556b1', 'admin');
?>
