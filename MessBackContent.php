<?php
	include_once("const.php");
	if($userlevel!='admin')header('location: UnauthorizedAccess.html');
	
	if(!isset($_GET['last']) || $_GET['last']==null || $_GET['last']=='' || !is_int(intval($_GET['last']))){
		exit;
	}

	$hackDB=mysqli_connect(db_host,db_user,db_pass,db_name);
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	$hackQuery="SELECT `Order`.`Id`,`Order`.`time`,`Order`.`seen`,`Order`.`username` FROM `Order` WHERE `Order`.`Id`>".intval($_GET['last'])." AND `Order`.`done`!='1' ORDER BY `Order`.`Id` DESC;";
	$result=mysqli_query($hackDB,$hackQuery);
	$latest=0;
	while($row = mysqli_fetch_array($result)){
		if($latest<$row['Id'])$latest=$row['Id'];
		echo "<table class='cantn' data-seen='".$row['seen']."'>
		<tr><td style='font-weight: bold; font-size: 23px;'>Ordered by:</td><td style='font-weight: bold; font-size: 23px;' colspan='2'>".$row['username']."</td></tr>			
		<tr><th class='cth'>Order No.</th>
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
		echo "</td><td>".$total."</td></tr>
		<tr><td colspan=3><span class='timeAgo' data-time='".strtotime($row['time'])."'>0</span> minutes ago. <div style='width:60%;display:inline-block;text-align:right;'>
		<input type='button' data-id='".$row['Id']."' class='button seen' value='Seen'>
		<input type='button' data-id='".$row['Id']."' class='button done' value='Done'></td></tr>
		</table>";
	}
	mysqli_close($hackDB);
	echo "___latest=".$latest;
?>
