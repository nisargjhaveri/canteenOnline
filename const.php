<?php
	define('db_host','localhost');
	define('db_name','hackCanteen');
	define('db_user','hack');
	define('db_pass','hackmess');
		
	session_start();
	if(!isset($login) && !isset($_SESSION['username'])){
		unset($username);
		unset($userlevel);
		$logged=0;
		header('location: login.php');
	}
	else if(isset($_SESSION['username'])){
		$username=$_SESSION['username'];
		$userlevel=$_SESSION['userlevel'];
		$logged=1;
	}
?>
