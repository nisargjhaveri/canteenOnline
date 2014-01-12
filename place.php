<?php
	include_once("const.php");

	if(!isset($_POST['username']) || $_POST['username']==null || $_POST['username']==''){
		echo "Invalid username. Error Code 1";
		exit(0);
	}
	$uname=$_POST['username'];
	
	$hackDB=mysqli_connect(db_host,db_user,db_pass,db_name);
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	mysqli_autocommit($hackDB, FALSE);
	mysqli_begin_transaction($hackDB);
	$hackQuery="INSERT INTO `Order` (`Id`, `username`, `time`) VALUES (NULL, '".$uname."', CURRENT_TIMESTAMP);";
	mysqli_query($hackDB,$hackQuery);
	$orderID=mysqli_insert_id($hackDB);
	
	foreach($_POST['quantity'] AS $itemID => $qty){
		if($qty!=null){
			$itemID=intval($itemID);
			$hackQuery="INSERT INTO `OrderDetail` (`Id`, `OrderId`, `ItemId`, `Qty`) VALUES (NULL, '".$orderID."', '".$itemID."', '".$qty."');";
			mysqli_query($hackDB,$hackQuery);
		}
	}
	mysqli_commit($hackDB);
	mysqli_autocommit($hackDB, FALSE);
	
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="MessUI.css">
	<script></script>
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
		<div id="left">
			 Juice Canteen Confirmed Order
		</div>
		<div id= 'order'>
		<p style="position:relative; left:38%; top:30px; font-family:'Trebuchet MS', Helvetica, sans-serif; font-size: 25px;">Order No <?php echo $orderID; ?></p>
		<table id ='cnfrm' style="Sfont-size: 25px;">
		<tr><th style="width:50px;">Item</th>
		<th>Qty.</th>
		<th>Sub Total</th>
		</tr>
		<?php
			$hackQuery="SELECT `ItemsAvail`.`ItemName`,`ItemsAvail`.`Price`,`OrderDetail`.`Qty` AS `Qty` FROM `ItemsAvail`,`OrderDetail`,`Order` WHERE `Order`.`Id`=`OrderDetail`.`OrderId` AND `ItemsAvail`.`Id`=`OrderDetail`.`ItemId` AND `OrderDetail`.`OrderId`=".$orderID.";";
			$result=mysqli_query($hackDB,$hackQuery);
			$total=0;
			while($row = mysqli_fetch_array($result)){
				echo "<tr><td style='width:50px;'>".$row['ItemName']."</td>
		<td>".$row['Qty']."</td><td>Rs. ".($row['Qty']*$row['Price'])."</td></tr>";
				$total+=$row['Price']*$row['Qty'];
			}
			mysqli_close($hackDB);
			
			//echo $total;
		?>
		<tr><td></td><th>Total:</th><td>Rs. <?php echo $total; ?></td></tr>
	</table>
	</div>
	</div>
</body>
<html>

