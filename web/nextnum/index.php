<?php
if (isset($_GET['nextnum'])) $nextnum = 1; else $nextnum = 0;
if ($nextnum == 1) {
	require_once("./inc/mysql.inc.php");
	$db = new CMySQL;
	if (!$db->Open()) $db->Kill();
	$q = "START TRANSACTION;";
	if (!$db->Query($q)) $db->Kill();
	try {
		$q = "SELECT get_next_in_number_series() AS next_value;";
		if (!$db->Query($q)) $db->Kill();
		$row = $db->Row();
		$next_value = $row->next_value;
		$q = "COMMIT;";
		if (!$db->Query($q)) $db->Kill();
	} catch (Exception $e) {
		$q = "ROLLBACK;";
		if (!$db->Query($q)) $db->Kill();
	}	
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="utf-8">
<title>Next in series</title>
<style>
h1 {
	font-family: Verdana, "Lucida Console";
	font-size: 30px;
	padding-left: 12px;
	padding-top: 39px;
}
h2 {
	font-family: Verdana, "Lucida Console";
	font-size: 20px;
}
.button {
	width: 130px;
    background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}
.button2 {
	width: 130px;
    background-color: #527a7a;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}
.button3 {
	width: 130px;
    background-color: #b3cccc;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}
input[type=text] {
    width: 200px;
    padding: 12px 20px;
    margin: 8px 0;    
	border: none;
	outline: none;
	text-decoration: none;
	font-family: Verdana, "Lucida Console";
	font-size: 20px;
}
</style>
</head>
<body>
<script>
function copyToClipboard() {
  var copyText = document.getElementById('nextinseries');
  copyText.select();
  document.execCommand('copy');
}
function printCode() {
     var printContents = '<h1>' + document.getElementById('nextinseries').value + '</h1>';
     var originalContents = document.body.innerHTML;
     document.body.innerHTML = printContents;
     window.print();
     document.body.innerHTML = originalContents;
}
</script>

<h2>Gimme next number</h2>
<form action="" method="get">
	<input type="submit" class="button" name="nextnum" value="Get <?php echo ($nextnum == 1 ? 'next' : 'one')?>">
	<?php
	if ($nextnum) {
		echo '<input type="text" id="nextinseries" value="'.$next_value.'" readonly><br>';
		echo '<button class="button2" type="button" onclick="printCode();">Print</button>';
		echo '<button class="button3" type="button" onclick="copyToClipboard();">Copy</button>';
	}
	?>
</form>
</body>
</html>
