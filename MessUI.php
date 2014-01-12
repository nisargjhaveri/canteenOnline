<?php
	include_once("const.php");
?>
<!DOCTYPE html>
<html>
<head>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<title>Canteen Order</title>
	<script>
	$(document).ready(function()
	{
			$('input').keyup(function(){
				total = 0;
				$('.qty').each(function(){
					if(!isNaN(parseInt($(this).val())))
					{
						total = total + parseInt($(this).val())*$(this).data('price');
					}
				});
				$('#totalA').text(total);
			});
	});	
	
	function conf(){
		document.getElementById('alertBack').style.display='block';
		document.getElementById('alertData').style.display='inline-block';
		innerH='<h3>You have ordered</h3><table align="center" class="jMenu"><tr><th>Item</th><th>Price</th><th>Quantity</th></tr>';
		total=0;
		$('.qty').each(function(){
			if(!isNaN(parseInt($(this).val())))
			{
				innerH+="<tr><td class='"+$(this).data('class')+" itemName'>"+$(this).data('name')+"</td>"
				innerH+="<td class='itemPrice'>Rs. "+$(this).data('price')+"</td>"
				innerH+="<td>"+$(this).val()+"</td></tr>"
				total = total + parseInt($(this).val())*$(this).data('price');
			}
		});
		innerH+="<tr><td colspan='3' style='padding-top:25px;'>Total Amount: Rs. "+total+"</td></tr>"
		innerH+="</table>";
		innerH+="<input id='can' type='button' class='button' value='Cancel' onclick='hideConf()' /><input type='button' class='button' value='Submit' onclick='submitOrder()' />";
		innerH+="</table>";
		document.getElementById('alertData').innerHTML=innerH;
		document.getElementById('can').focus();
		return false;
	}
	function hideConf(){
		document.getElementById('alertBack').style.display='none';
		document.getElementById('alertData').style.display='none';
		document.getElementById('tot').focus();
	}
	function submitOrder(){
		document.getElementById('subForm').submit();
	}
	</script>
<link rel="stylesheet" type="text/css" href="MessUI.css">
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
		 Juice Canteen Online Order
	</div>
	<div id="right">
		<form action='place.php' method='POST'id='subForm' onsubmit='return conf();'>
			<br><br>
			<!--<div id='uname' style='margin-left:10%;'><span style='font-weight:bold'>Roll No </span><input type='text' name='username' id='username' placeholder='Enter your RollNo' required /></div>-->
			<input type='hidden' name='username' value='<?php echo $username; ?>'>
			<div id="JuiceMenu">
				<table class="jMenu">
					<tr><th style='padding-left:5px;text-align:left;'>Item</th>
					<th>Price</th>
					<th>Quantity</th></tr>
				<?php
					$hackDB=mysqli_connect(db_host,db_user,db_pass,db_name);
					if (mysqli_connect_errno()){
						echo "Failed to connect to MySQL: " . mysqli_connect_error();
					}
					$hackQuery="SELECT * FROM `ItemsAvail` WHERE `CanteenId`='0'";
					$result=mysqli_query($hackDB,$hackQuery);
					while($row = mysqli_fetch_array($result)){
						if($row['isVeg'])$class="veg";
						else $class='nonveg';
						echo "<tr class='oneItem'> 
							<td class='".$class." itemName'>".$row["ItemName"]."</td>
							<td class='itemPrice'>Rs. ".$row["Price"]."</td>
							<td style='text-align:center;'><input size='2' class='qty' type='number' name='quantity[".$row['Id']."]' data-class='".$class."' data-name='".$row["ItemName"]."' data-price='".$row["Price"]."' min='0' max='20'></td>
						</tr>";
						//print_r($row);
					}
					mysqli_close($hackDB);
				?>
				</table>
				<div id="jTotal">
					<p>Total Amount: Rs.<span id='totalA'>0</span></p>
					<input type='submit' class='button' value='Order' id = 'tot'>
				</div> 
			</div>
		</form>
	</div>
</div>
<div id='alertBack'>
	<div id='alertData'>
	</div>
</div>
</body>
<html>
