<?php
require_once("./inc/securitycheck.inc.php");

$dataakt = date("d/m/Y H:i:s");

function EscapeSpaceAndDashes($str) {
	$str = str_replace(" ", "&nbsp;", $str);
	$str = str_replace("-", "&#x2011;", $str);
	return $str;
}


echo '
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Shop Staff</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
	<link rel="stylesheet type="text/css" href="style1.css">
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"
  		integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
		  crossorigin="anonymous">
	</script>
</head>
<body>
	<h1>Shop Staff</h1><br>
';

$tablecode = "
	<div class='grid-container'>
		<div class='grid-header-item'>Clocking no.</div>
		<div class='grid-header-item' id='name'>Name</div>
		<div class='grid-header-item'>Category</div>
		<div class='grid-header-item'>Dot</div>
		<div class='grid-header-item'>Location</div>
";

$db = new CMySQL;
if (!$db->Open()) $db->Kill();

$q = "
	SELECT name,
		   IP
	FROM ipaddress
	ORDER BY name
";

$locations = array();

if ($db->Query($q)) {
    while ($row = $db->Row()) {
		$locations[$row->IP] = $row->name;
	}
}

$q = "
	SELECT n.pno,
		   n.knownas,
		   n.surname,
		   UPPER(n.cat) AS category,
		   LOCATE('.', n.cattoname) AS has_dot,
		   (SELECT io.ipadr
		    FROM `inout` io
		    WHERE io.`no` = n.pno
			  AND io.date1 = CURDATE()
		    ORDER BY io.intime DESC
			LIMIT 1) AS ipadr
	FROM nombers n	
	WHERE n.`status` = 'OK'
	  AND n.pno NOT IN (5, 555)
	ORDER BY n.knownas, n.surname
";

if ($db->Query($q)) {
    while ($row = $db->Row()) {
       
		$clockin_no = $row->pno;
		$name = $row->knownas." ".$row->surname;
		$name = EscapeSpaceAndDashes($name);	
		$category = $row->category;
		$ipaddr = $row->ipadr;
		$checked = "";

		if ($row->has_dot) {
			$checked = "checked";
		} 
        $tablecode .= "
				<div class='grid-item'>$clockin_no</div>
				<div class='grid-item'>$name</div>
				<div class='grid-item' name='category'>$category</div>
				<div class='grid-item'>
					<label class='switch'>
  					<input type='checkbox' name='toggle' $checked value='$clockin_no'>
					<span class='slider round'></span>
					</label>
				</div>
				<div class='grid-item'>
			";
		if($ipaddr){
		$tablecode .= "
			<select name='location' id='$clockin_no'>
				";				
		$arrlength = count($locations);
	
		foreach($locations as $key => $value){
			$selected = "";
			if($key == $ipaddr){
				$selected = "selected";
			}
		$tablecode .= "<option value='".$key."' $selected>".$value."</option>";
		}
		
	} else{
		$tablecode .= "(not clocked in)";
	}
	
		$tablecode .= "
			  	</select>
				</div>
			";
    }
}

echo "
$tablecode<script src='main.js'></script>
</div>
</body>
</html>
";
?>