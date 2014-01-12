<?php
	include_once('const.php');
	if($userlevel!='admin')header('location: UnauthorizedAccess.html');
?>
<html>
<head>
	<title>Edit Menu</title>
	<link rel="stylesheet" type="text/css" href="MessUI.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script>
		function hideConf(){
		document.getElementById('alertBack').style.display='none';
		document.getElementById('alertData').style.display='none';
		document.getElementById('tot').focus();
	}
		$(document).ready(function(){
			$('.edit').click(function(){
				var ft = $(this).parent().siblings().first();
				var it= ft.text();
				var nt = $(this).data('price');
				var ty = $(this).data('veg');
				document.getElementById('alertBack').style.display='block';
				document.getElementById('alertData').style.display='inline-block';
				innerH='<h3 style="position:relative; top:30px;">You want to edit the following item:</h3><form method="post" action="editMenu.php"> <table align="center" style="position:relative; top:35px; left: 10px;" class="jMenu"><tr><td><b>Item Name</b><input type="text" value="'+it+'" name ="item"></td><td><b>Price:</b><input style="text-align:center;" size=4; type="text" value='+nt+' name ="price"></td><td><b>Veg?</b><input type="checkbox" '+((ty==1)?'checked':'')+' name ="isVeg" value=1></td></tr>';
				innerH+="<tr><td align='center'><input type='hidden' name='edit' /><input type='hidden' name='id' value='"+$(this).data('id')+"'/><input style='position:relative; top:35px; left: 20px;' id='can' type='button' class='button' value='Cancel' onclick='hideConf()' /></td><td align='center'><input  style='position:relative; top:35px;' type='submit' class='button' value='Submit' </td><td></td></tr>";
				innerH+="</table></form>";
				document.getElementById('alertData').innerHTML=innerH;
				document.getElementById('can').focus();
				return false;
			});
			$('#add').click(function(){
				document.getElementById('alertBack').style.display='block';
				document.getElementById('alertData').style.display='inline-block';
				innerH='<h3 style="position:relative; top:30px;">You want to edit the following item:</h3><form method="post" action="editMenu.php"> <table align="center" style="position:relative; top:35px; left: 10px;" class="jMenu"><tr><td><b>Item Name</b><br><input type="text" name ="item"></td><td><b>Price:</b><br><input style="text-align:center;" size=4; type="text"  name ="price"></td><td><b>Veg?</b><br><input type="checkbox" name ="isVeg" value=1></td></tr>';
				innerH+="<tr><td align='center'><input type='hidden' name='add' /><input style='position:relative; top:35px; left: 20px;' id='can' type='button' class='button' value='Cancel' onclick='hideConf()' /></td><td align='center'><input  style='position:relative; top:35px;' type='submit' class='button' value='Submit' </td><td></td></tr>";
				innerH+="</table></form>";
				document.getElementById('alertData').innerHTML=innerH;
				document.getElementById('can').focus();
				return false;
			});
			$('.remove').click(function(){
				var ft = $(this).parent().siblings().first();
				var it= ft.text();
				var nt = ft.next().text();
				document.getElementById('alertBack').style.display='block';
				document.getElementById('alertData').style.display='inline-block';
				innerH='<h3 style="position:relative; top:30px;">You want to delete the following item:</h3><form method="post" action="editMenu.php"> <table align="center" class="jMenu" style="position:relative; top:35px; left: 10px;"t><tr><th>Item</th><th>Price</th></tr><tr><td align="center">'+it+'</td><td align="center">'+nt+'</td></tr>';
				innerH+="<tr><td align='center'><input type='hidden' name='del' /><input type='hidden' name='id' value='"+$(this).data('id')+"'/><input style='position:relative; top:35px; left:20px;' id='can' type='button' class='button' value='Cancel' onclick='hideConf()' /></td><td align='center'><input style='position:relative; top:35px; left:20px;' type='submit' class='button' value='Confirm'</td></tr>";
				innerH+="</table></form>";
				document.getElementById('alertData').innerHTML=innerH;
				document.getElementById('can').focus();
				return false;
			});
			
	});</script>
</head>
<body>
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
		<div id="left">
			 Juice Canteen Online Order
		</div>
		<div id="JuiceMenu">
		<table class="j1">
			<tr><td colspan=3 style='text-align:right'><input type='button' class='button' id='add' value='Add Item'/></td></tr>
			<tr><th class='j11'>Item</th>
			<th class='j11'>Price</th>
			<th class='j11'>Edit/Remove</th></tr>
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
					echo "<tr>
						<td>".$row["ItemName"]."</td>
						<td>Rs. ".$row["Price"]."</td>
						<td><input type='button' data-veg=".$row['isVeg']." data-price=".$row["Price"]." data-id=".$row['Id']." class='button edit' value='Edit'>
						<input type='button' data-id=".$row['Id']." class='button remove' value='Remove' ></td></tr>";
					//print_r($row);
				}
				mysqli_close($hackDB);
			?>
		</table>
	</div>
	<div id='alertBack'>
	<div id='alertData'>
	</div>
</div>
</body>
<html>
