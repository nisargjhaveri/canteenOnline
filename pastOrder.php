<?php 
	include_once('const.php');
	$hackDB=mysqli_connect(db_host,db_user,db_pass,db_name);
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
?>

<html>
<head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<title></title>
	<link rel="stylesheet" type="text/css" href="MessUI.css">
	<script>
$(document).ready(function(){
	curTime=(new Date().getTime()/1000)-(new Date().getTimezoneOffset()*60);
	$('.timeAgo').each(function(){
		$(this).text(Math.floor((curTime-$(this).data('time'))/60));
	});
});
window.setInterval(function(){
	curTime=(new Date().getTime()/1000)-(new Date().getTimezoneOffset()*60);
	$('.timeAgo').each(function(){
		$(this).text(Math.floor((curTime-$(this).data('time'))/60));
	});
},1000);

</script>
</head>
<body>
	<div id="container">
		<table id="links" width='100%'>
			<tr><td colspan=2 align='right' style="font-family:'Trebuchet MS', sans-serif, Helvetica; font-size: 20px;text-align:right;padding-right:15px;">Welcome, <?php echo $_SESSION['Name']; ?></td></tr>
			<tr>
				<td style="font-family:'Trebuchet MS', sans-serif, Helvetica; font-size: 20px;"><div style='display:inline;' class='button' onclick='window.location.href="MessUI.php";'>Order Food</div>
				<div class='button' style='display:inline;' onclick='window.location.href="pastOrder.php";'>Past Orders</div></td>
				<td style="text-align:right;font-family:'Trebuchet MS', sans-serif, Helvetica; font-size: 20px;"><div class='button' style='display:inline;' onclick='window.location.href="login.php?logout=1";'>Logout</div></td>
			</tr>
	</table>
	
	<div id="left" style='margin-bottom:20px;'>
			 Past Orders
	</div>
		<?php
		$hackQuery="SELECT `Order`.`Id`,`Order`.`time`,`Order`.`seen`,`Order`.`username` FROM `Order` WHERE `Order`.`username`='".$username."' ORDER BY `Order`.`Id` DESC;";
		$result=mysqli_query($hackDB,$hackQuery);
		while($row = mysqli_fetch_array($result)){
			echo "<table class='cantn' data-seen='".$row['seen']."' data-done='".$row['done']."'>
			<tr>
			<th class='cth'>Order No.</th>
			<th class='cth'>Item</th>
			<th class='cth'>Total</th>
			</tr>
			<tr><td>".$row['Id']."</td><td>";
			$hackQuery2="SELECT `ItemsAvail`.`ItemName`,`ItemsAvail`.`Price`,`OrderDetail`.`Qty` AS `Qty` FROM `ItemsAvail`,`OrderDetail`,`Order` WHERE `Order`.`Id`=`OrderDetail`.`OrderId` AND `ItemsAvail`.`Id`=`OrderDetail`.`ItemId` AND `OrderDetail`.`OrderId`=".$row['Id'].";";
			$result2=mysqli_query($hackDB,$hackQuery2);
			$total=0;
			while($row2 = mysqli_fetch_array($result2)){
				echo $row2['ItemName'].' ('.$row2['Qty'].')'.'<br>';
				$total+=intval($row2['Qty'])*intval($row2['Price']);
			}
			echo "</td><td>Rs. ".$total."</td></tr>
			<tr><td colspan=3><span class='timeAgo' data-time='".strtotime($row['time'])."'>0</span> minutes ago. <div style='width:60%;display:inline-block;text-align:right;'>
			</td></tr>
			</table>";
		}
		mysqli_close($hackDB);
	?>
	</div>
</body>
</html>
