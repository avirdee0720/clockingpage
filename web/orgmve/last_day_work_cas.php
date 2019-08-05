<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;

uprstr($PU,90);

if (!isset($_POST['state'])) $state = 0; else $state = $_POST['state'];
if (!isset($_POST['ids'])) $ids = array(); else $ids = $_POST['ids'];
if (!isset($_POST['comments'])) $comments = array(); else $comments = $_POST['comments'];

// save comments
if ($state == 1) {
	foreach ($ids as $key => $value) {
		$q = "UPDATE staffdetails
			  SET comment6 = '".$comments[$key]."'
			  WHERE `no` = ".$value;
		if (!$db->Open()) $db->Kill();
		if (!$db->Query($q)) $db->Kill();
	}
}

$columns = 5;
for ($i = 1; $i <= $columns; $i++ ) {
	// disable showing the order by indicator by Brian's request
	//if (!isset($kier_img[$i])) $kier_img[$i] = "";
	$kier_img[$i] = "";
}

// retain the sort order that was there on saving comments action
if ($kier == 0) $prev_kier = 1; else $prev_kier = 0;

echo "
<br>
<center>
<font class='FormHeaderFont'>Last Day Worked - Casuals</font>

<form action='$PHP_SELF?sort=".$sort."&kier=".$prev_kier."' method='post'>

<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
	<tr>
		<td class='ColumnTD' nowrap>
			<a href='$PHP_SELF?sort=1&kier=$kier'>Knownas $kier_img[1]</a>
        </td>
		<td class='ColumnTD' nowrap>
			<a href='$PHP_SELF?sort=2&kier=$kier'>Surname $kier_img[2]</a>
		</td>
		<td class='ColumnTD' nowrap>
			<a href='$PHP_SELF?sort=3&kier=$kier'>Started $kier_img[3]</a>
		</td>
		<td class='ColumnTD' nowrap>
			<a href='$PHP_SELF?sort=4&kier=$kier'>Last worked $kier_img[4]</a>
		</td>
		<td class='ColumnTD' nowrap>
			<a href='$PHP_SELF?sort=5&kier=$kier'>Comments $kier_img[5]</a>
		</td>
	</tr>
";

if(!isset($sort) || ($sort < 1) || ($sort > 5)) $sort = 1;

switch ($sort) {
	case 1:
		$order_by = " ORDER BY n.knownas $kier_sql";
		break;
	case 2:
		$order_by = " ORDER BY n.surname $kier_sql";
		break;
	case 3:
		$order_by = " ORDER BY started_for_sort $kier_sql";
		break;
	case 4:
		$order_by = " ORDER BY last_day_worked_for_sort $kier_sql";
		break;
	case 5:
		$order_by = " ORDER BY comments $kier_sql";
		break;
}

if (!$db->Open()) $db->Kill();
// Find all employees who are casuals and still employed
$q = "
SELECT n.pno,
	   n.knownas,
	   n.surname,
	   DATE_FORMAT(n.started, '%d.%m.%Y') AS started,
	   n.started AS started_for_sort,
	   IFNULL(DATE_FORMAT(MAX(ino.date1), '%d.%m.%Y'), 'N/A') AS last_day_worked,
	   MAX(ino.date1) AS last_day_worked_for_sort,
	   sd.comment6 AS comments
  FROM nombers n
  LEFT JOIN `inout` ino
    ON n.pno = ino.`no`
  LEFT JOIN staffdetails sd
    ON n.pno = sd.`no`
 WHERE n.cat = 'c'
   AND n.`status` = 'OK'
   AND sd.decision NOT IN (3,4)
 GROUP BY n.pno, n.knownas, n.surname, started, comments
".$order_by;

$colour_odd = "DataTD2"; 
$colour_even = "DataTDGrey2";
$row_count=0;

if ($db->Query($q)) {
	$total = $db->Rows();
    while ($r = $db->Row()) {	
		$row_count++;
		$row_color = (($row_count % 2) == 0) ? $colour_even : $colour_odd;    
		echo "
			<tr>
				<td class='$row_color'>$r->knownas</td>
				<td class='$row_color'>$r->surname</td>
				<td class='$row_color'>$r->started</td>
				<td class='$row_color'>$r->last_day_worked</td>
				<td class='$row_color'><input class='Input' size='50' maxlength='250' name='comments[]' value='".$r->comments."'>
				<input name='ids[]' type='hidden' value='$r->pno'></td>
			</tr>
		";
	}
}

if (!isset($total)) $total = 0;
echo "
	<tr>
		<td align='middle' class='FooterTD' colspan='4' nowrap>Total: $total</td>
		<td align='middle' class='FooterTD'>
			<input name='state' type='hidden' value='1'>
			<input class='Button' name='Update' type='submit' value='$SAVEBTN'>
		</td>
	</tr>
</table>

</form>

</center>
";
include_once("./footer.php");

?>
