<?php
require_once("./inc/securitycheck.inc.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>ORGMVE login</title>
	<link rel='stylesheet' type='text/css' href='styles.css'>
	<style>
		div#bodycontainer {
			position: fixed;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -100%);
			font-family: Verdana;
			border-style: solid;
			border-width: 2px;
			border-color: grey;
			padding: 10px 10px 10px 10px;
		}
		
		div#logintext {
			display: block;
			text-align: center;
			font-size: 20px;
			font-weight: bold;
			padding: 25px 25px 15px 25px;
		}
		
		table#logintable {
			display: block;
			font-size: 16px;
			border-spacing: 3px;
		}
		
		td {
			padding-top: 5px;
		}
		
		input {
			padding-left: 3px;
		}
	</style>
</head>
<body>
<div id='devheaderhere'></div>
<div id='bodycontainer'>

<div id='logintext'>ORGMVE login</div>

<form method='post' action='login.php' name='Login'>
	<table id='logintable'>
		<tr>
			<td>Username</td>
			<td><input name='login' maxlength='80' value='' class='Input' autofocus='autofocus'></td>
		</tr>
		<tr>
			<td>Password</td>
			<td><input type='password' name='password' maxlength='80' value='' class='Input'></td>
		</tr>
		<tr>
			<td colspan='2' align='right'>
				<input name='DoLogin' type='submit' value='Enter' class='Button'>
			</td>
		</tr>
	</table>
</form> 

</div>
</body>
</html>