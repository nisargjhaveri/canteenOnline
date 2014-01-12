<?php
	include_once("const.php");
	if($userlevel!='admin')header('location: UnauthorizedAccess.html');

	$hackDB=mysqli_connect(db_host,db_user,db_pass,db_name);
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
?>
<!DOCTYPE html>
<html>
<head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<title>The Canteen</title>
	<link rel="stylesheet" type="text/css" href="MessUI.css">
	<script>
		function clock (){
			var curr = new Date();
			var hours = curr.getHours();
			var mins = curr.getMinutes();
			var sec = curr.getSeconds();
			if( mins < 10)
			mins="0" + mins;
			if( sec <10)
			sec = "0" + sec;
			$('#clock').text(hours+':'+mins+':'+sec);
			time= setTimeout(function(){clock()},500);
		}
$(document).ready(function(){
	clock();
	$('.done').click(function(){
		$.get('seenDone.php?Id='+$(this).data('id')+'&done=1');
		$(this).parent().parent().parent().parent().parent().fadeOut();
	});
	$('.seen').click(function(){
		$.get('seenDone.php?Id='+$(this).data('id')+'&seen=1');
		$(this).parent().parent().parent().parent().parent().css("background-color","rgba(0,0,255,0.3)");
	});
	$('.cantn').each(function(){
		if($(this).data('seen')=='1')$(this).css("background-color","rgba(0,0,255,0.3)");
	});
});


//Nisarg
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
	console.log($('#latestOrder').text());
	$.ajax({
		success: function(data,status){
			if(data!=''){
				myData=data.split('___latest=');
				console.log(myData);
				if(typeof myData[1]=='undefined' || isNaN(parseInt(myData[1])) || parseInt(myData[1])==0)return;
				$('#latestOrder').text(myData[1]);
				$('#allOrder').prepend(myData[0]);
				$('.done').click(function(){
					$.get('seenDone.php?Id='+$(this).data('id')+'&done=1');
					$(this).parent().parent().parent().parent().parent().fadeOut();
				});
				$('.seen').click(function(){
					$.get('seenDone.php?Id='+$(this).data('id')+'&seen=1');
					$(this).parent().parent().parent().parent().parent().css("background-color","rgba(0,0,255,0.3)");
				});
				$('.cantn').each(function(){
					if($(this).data('seen')=='1')$(this).css("background-color","rgba(0,0,255,0.3)");
				});
			}
		},
		type:'GET',
		url:'MessBackContent.php?last='+$('#latestOrder').text()
	});
},1000);
</script>
</head>
<body>
	<div style="position:fixed; right: 30px;">
	<p id ='clock' style ="font-size:35px; color: #FFFFFF;"></p>
	</div>
	<div id="container">
		<table id="links" width='100%'>
			<tr>
				<tr><td colspan=2 align='right' style="font-family:'Trebuchet MS', sans-serif, Helvetica; font-size: 20px;text-align:right;padding-right:15px;">Welcome, <?php echo $_SESSION['Name']; ?></td></tr>
				<td style="font-family:'Trebuchet MS', sans-serif, Helvetica; font-size: 20px;"><div style='display:inline;' class='button' onclick='window.location.href="MessBack.php";'>Orders</div>
				<div class='button' style='display:inline;' onclick='window.location.href="MenuEdit.php";'>Edit Menu</div>
				<div class='button' style='display:inline;' onclick='window.location.href="RegisterAdmin.php";'>Add User</div>
				</td>
				<td style="text-align:right;font-family:'Trebuchet MS', sans-serif, Helvetica; font-size: 20px;"><div class='button' style='display:inline;' onclick='window.location.href="login.php?logout=1";'>Logout</div></td>
			</tr>
		</table>
	<div id="left" style='margin-bottom:20px;'>
			 Juice Canteen Online Order
	</div>
	<div id='allOrder'>
	<?php
		$hackQuery="SELECT `Order`.`Id`,`Order`.`time`,`Order`.`seen`,`Order`.`username` FROM `Order` WHERE `Order`.`done`!='1' ORDER BY `Order`.`Id` DESC;";
		$result=mysqli_query($hackDB,$hackQuery);
		$latest=0;
		while($row = mysqli_fetch_array($result)){
			if($latest<$row['Id'])$latest=$row['Id'];
			echo "<table class='cantn' data-seen='".$row['seen']."'>
			<tr><td style='font-weight: bold; font-size: 23px;'>Ordered by:</td><td style='font-weight: bold; font-size: 23px;' colspan='2'>".$row['username']."</td></tr>			
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
			echo "</td><td>".$total."</td></tr>
			<tr><td colspan=3><span class='timeAgo' data-time='".strtotime($row['time'])."'>0</span> minutes ago. <div style='width:60%;display:inline-block;text-align:right;'>
			<input type='button' data-id='".$row['Id']."' class='button seen' value='Seen'>
			<input type='button' data-id='".$row['Id']."' class='button done' value='Done'></td></tr>
			</table>";
		}
		mysqli_close($hackDB);
	?>
	</div>
	</div>
	<div id='latestOrder'><?php echo $latest; ?></div>
</body>
<html>
<!--seen/ done buttons, ordered time, current time>
