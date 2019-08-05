<?php
include_once("./config.php");
include_once("./header2.php");
uprstr($PU, 90);

$db = new CMySQL;	
if (!$db->Open()) $db->Kill();

// save new pay rate if Save button was pressed
$saveMessage = "";
if (array_key_exists('save', $_POST) && array_key_exists('newPayRate', $_POST)) {
	$newpayrate = floatval($_POST['newPayRate']);
	if ($newpayrate >= 0) {
		$empids = "";
		$i = 1;
		while (array_key_exists("empid$i", $_POST)) {
			if ($empids) $empids .= ",";
			$empid = intval(substr($_POST["empid$i"], 0, 10));
			$empids .= $empid;
			$i++;
		}
		if ($empids) {
			$q = "UPDATE nombers
				  SET daylyrate = ROUND($newpayrate * 8.5, 2)
				  WHERE ID in ($empids);";
			if (!$db->Query($q)) $db->Kill();
			$i--;			
			$saveMessage = "Updated pay rate for $i employee".(($i == 1) ? "" : "s")." to ".sprintf("%.2f", $newpayrate).".";
		}
	}
}

// build sort order and direction sql
if (array_key_exists('sort', $_GET))
	$sortorder = substr($_GET['sort'], 0, 1);
else
	$sortorder = "";
if (array_key_exists('sortdir', $_GET))
	$sortdir = substr($_GET['sortdir'], 0, 1);
else
	$sortdir = "";
$sortdirsql = "";
switch ($sortdir) {
	case 1: $sortdirsql = "ASC"; break;
	case 2: $sortdirsql = "DESC"; break;
	default: $sortdirsql = "ASC"; break;
}
$sortsql = "ORDER BY ";
switch ($sortorder) {
	case 1: $sortsql .= "n.pno $sortdirsql"; break;
	case 2: $sortsql .= "n.firstname $sortdirsql, n.surname $sortdirsql"; break;
	case 3: $sortsql .= "n.started $sortdirsql, n.firstname $sortdirsql, n.surname $sortdirsql"; break;
	case 4: $sortsql .= "ec.catname_account $sortdirsql, n.firstname $sortdirsql, n.surname $sortdirsql"; break;
	case 5: $sortsql .= "hourlyrate $sortdirsql, n.firstname $sortdirsql, n.surname $sortdirsql"; break;
	default: $sortsql .= "n.firstname $sortdirsql, n.surname $sortdirsql"; $sortorder = 2; break;
}

// set column sort direction
$newsortdir = array(1, 1, 1, 1, 1);
// next time the column heading is clicked it gets reverse sort order, other columns remain the same;
// takes into account the case the script is called with no sort order or sort direction tokens
if (((!$sortdir) || ($sortdir == 1)) && (array_key_exists($sortorder - 1, $newsortdir)))
	$newsortdir[$sortorder - 1] = 2;

// save filters
function saveFromPost($key, $length, &$a) {
	if (array_key_exists($key, $_GET))
		$a[$key] = mysql_real_escape_string(substr($_GET[$key], 0, $length));
	else
		$a[$key] = "";
}

$filters = array();
saveFromPost('fclno', 10, $filters);
saveFromPost('fname', 10, $filters);
saveFromPost('fstarted', 10, $filters);
saveFromPost('fcat', 10, $filters);
saveFromPost('fpayrate', 10, $filters);

// build filter sql and filter string for sorting by column header
$filtersql = "";
$filterslink = "";
if ($filters['fclno']) {
	$filtersql = "n.pno LIKE '".$filters['fclno']."%'";
	$filterslink = "fclno=".$filters['fclno'];
}
if ($filters['fname']) {
	if ($filtersql)
		$filtersql .= " AND ";
	$filtersql .= "(n.firstname LIKE '".$filters['fname']."%' OR n.knownas LIKE '".$filters['fname']."%')";
	if ($filterslink)
		$filterslink .= "&";
	$filterslink .= "fname=".$filters['fname'];
}
if ($filters['fstarted']) {
	if ($filtersql)
		$filtersql .= " AND ";
	$filtersql .= "n.started = '".$filters['fstarted']."'";
	if ($filterslink)
		$filterslink .= "&";
	$filterslink .= "fstarted=".$filters['fstarted'];
}
if ($filters['fcat']) {
	if ($filtersql)
		$filtersql .= " AND ";
	$filtersql .= "ec.catozn = '".$filters['fcat']."'";
	if ($filterslink)
		$filterslink .= "&";
	$filterslink .= "fcat=".$filters['fcat'];
}
if ($filters['fpayrate']) {
	if ($filtersql)
		$filtersql .= " AND ";
	$filtersql .= "(ROUND(n.daylyrate / 8.5, 2) LIKE REPLACE('".$filters['fpayrate']."', ',', '.'))";
	if ($filterslink)
		$filterslink .= "&";
	$filterslink .= "fpayrate=".$filters['fpayrate'];
}
if ($filterslink)
	$filterslink = "&".$filterslink;

// build category selector
$cat_sel = "<select class='filter' name='fcat'><option";
if (!$filters['fcat'])
	$cat_sel .= " selected";
$cat_sel .= "></option>";
$q = "SELECT catozn, catname_account FROM emplcat ORDER BY catname_account;";
if (!$db->Query($q)) $db->Kill();
while ($row = $db->Row()) {
	$cat_sel .= "<option value='$row->catozn'";
	if ($filters['fcat'] && $filters['fcat'] == $row->catozn)
		$cat_sel .= " selected";
	$cat_sel .= ">$row->catname_account</option>";
}
$cat_sel .= "</select>";
?>
<div id="reportcontainer">
<?php
	if ($saveMessage) {
		echo "
			<div style='text-align: left; font-size: 14px; background-color: #ffff4d; margin-top: 20px;'>$saveMessage</div>
		";
	}
	echo "	
	<p id='reportheader'>
	Change hourly pay rates<br>
	</p>

	<table id='maintable'>
		<tr>
			<form name='filter' action='' method='get' target='_self'>
			<td><input type='text' class='filter' name='fclno' maxlength='10' value='".$filters['fclno']."'><input type='submit' value='OK'></td>
			<td><input type='text' class='filter' name='fname' maxlength='10' value='".$filters['fname']."'><input type='submit' value='OK'></td>
			<td><input type='date' class='filter' name='fstarted' value='".$filters['fstarted']."'><input type='submit' value='OK'></td>
			<td>$cat_sel<input type='submit' value='OK'></td>
			<td><input type='text' class='filter' name='fpayrate' maxlength='6' value='".$filters['fpayrate']."'><input type='submit' value='OK'></td>
			<input type='hidden' name='sort' value='2'>
			<input type='hidden' name='sortdir' value='1'>
			</form>
		</tr>
		<tr>
			<th><a href='?sort=1&sortdir=$newsortdir[0]".$filterslink."'>ClNo</a></th>
			<th><a href='?sort=2&sortdir=$newsortdir[1]".$filterslink."'>Name</a></th>
			<th><a href='?sort=3&sortdir=$newsortdir[2]".$filterslink."'>Started</a></th>
			<th><a href='?sort=4&sortdir=$newsortdir[3]".$filterslink."'>Category</a></th>
			<th><a href='?sort=5&sortdir=$newsortdir[4]".$filterslink."'>Pay rate</a></th>
		</tr>
		<form name='payrate' action='' method='post' target='_self'>
	";	
	
	$q = "SELECT n.id,
				 n.pno,
				 n.firstname,
				 n.surname,
				 n.knownas,
				 n.started,
				 ec.catname_account,
				 ROUND(n.daylyrate / 8.5, 2) AS hourlyrate
		  FROM nombers n
			INNER JOIN emplcat ec ON n.cat = ec.catozn
		  WHERE n.status LIKE 'OK'
		 ";
	if ($filtersql)
		$q .= " AND ".$filtersql;
	$q .= " ".$sortsql.";";
	if (!$db->Query($q)) $db->Kill();
	$count = 0;
	while ($row = $db->Row()) {
		$count++;
		echo "
			<tr>
				<td><input type='hidden' name='empid$count' value='$row->id'><a href='hr_data.php?cln=$row->pno'>$row->pno</a></td>
				<td>$row->firstname&nbsp;$row->surname&nbsp;($row->knownas)</td>
				<td>$row->started</td>
				<td>$row->catname_account</td>
				<td>$row->hourlyrate</td>
			</tr>
		";
	}
?>
	</table>
	<div id='reportcreationdate'>
		Count: <?php echo $count; ?>
	</div>	
	<div style="text-align:right; font-size: 14px;">
		New pay rate: <input type='number' name='newPayRate' step="0.01" min="0" style='width: 120px;'>
		<input type='submit' name='save' value='Save'>
	</div>
	</form>
</div>
</body>
</html>