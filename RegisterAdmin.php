<?php
	include_once("const.php");
	if($userlevel!='admin')header('location: UnauthorizedAccess.html');
?>
<!DOCTYPE html>
<html>
<head>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<title>Canteen Order Register</title>
	<script></script>
	<link rel="stylesheet" type="text/css" href="MessUI.css">
</head>
<body>
	<!--<button class="button" id="login">&lt; Login Page</button>-->
	<div id="container">
		<table id="links" width='100%'>
			<tr><td colspan=2 align='right' style="font-family:'Trebuchet MS', sans-serif, Helvetica; font-size: 20px;text-align:right;padding-right:15px;">Welcome, <?php echo $_SESSION['Name']; ?></td></tr>
			<tr>
				<td style="font-family:'Trebuchet MS', sans-serif, Helvetica; font-size: 20px;"><div style='display:inline;' class='button'  onclick='window.location.href="MessBack.php";'>&lt; See Orders</div></td>
				<td style="text-align:right;font-family:'Trebuchet MS', sans-serif, Helvetica; font-size: 20px;"><div class='button' style='display:inline;' onclick='window.location.href="login.php?logout=1";'>Logout</div></td>
			</tr>
		</table>
		<div id="left">
			 Juice Canteen Online Order
		</div>
		<form method='post' action='registerAdminPanel.php'>
		<table id="login">
			<tr>
				<td><font size="6">Username: </td><td><input type="text" name="username" placeholder="Enter Username" required style="font-size: 18px;" size="20" maxlength="30">
				</font></td>
			</tr>
			<tr>
				<td><font size="6">Name: </td><td><input type="text" name="name" placeholder="Enter Your Name" required style="font-size: 18px;" size="20" maxlength="30">
				</font></td>
			</tr>
			<tr>
				<td><font size="6">Password: </td><td><input type="password" name="password" placeholder="Enter Password" required style="font-size: 18px;" size="20" maxlength="30">
				</font></td>
			</tr>
			<tr>
				<td><font size="6">Account Type: </td><td><select name='type' style="font-size: 18px;"><option value='user'>User</option><option value='admin'>Admin</option></select>
				</font></td>
			</tr>
		</table>
		<table id="btn">
			<tr><td><input type="submit" name='login' class="button" id="login" value='Register'></td></tr>
		</table>
		</form>
	</div>
</body>
<html>
