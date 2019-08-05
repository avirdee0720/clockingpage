<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$db1 = new CMySQL;
$tytul="Regular's contact details";

uprstr($PU,50);

if (empty($_GET["letter"])) {
    $letter="A";
} else {
    $letter=$_GET["letter"];
}

echo "  <TD ALIGN=JUSTIFY VALIGN=TOP border=0>

<center>


<font CLASS='FormHeaderFont'>$tytul&nbsp;&nbsp;   &nbsp;&nbsp;

<table border='0' cellpadding='3' cellspacing='1' CLASS='FormTABLE'>
  <tr>
    <td CLASS='ColumnTD' nowrap>&nbsp;</td>
    <td CLASS='ColumnTD' nowrap>
                <A HREF='$PHP_SELF?sort=1'>NO</a>

        </td>
    <td CLASS='ColumnTD' nowrap>
                <A HREF='$PHP_SELF?sort=2'>Known AS</a>

        </td>
    <td CLASS='ColumnTD' nowrap>
                <A HREF='$PHP_SELF?sort=3'>Surname</a>

        </td>
    <td CLASS='ColumnTD' nowrap>
                <A HREF='$PHP_SELF?sort=4'>Category</a>

        </td>
            <td CLASS='ColumnTD' nowrap>
Home Phone

        </td>
         </td>
            <td CLASS='ColumnTD' nowrap>
Mobile

        </td>
	</tr>
";

if (!$db->Open()) $db->Kill();

if(!isset($sort)) $sort=1;

        switch ($sort)
                {
                case 1:
                 $sortowanie=" ORDER BY `pno` DESC";
                 break;
                case 2:
                 $sortowanie=" ORDER BY `knownas` ASC";
                 break;
                case 3:
                 $sortowanie=" ORDER BY `surname` ASC";
                 break;
                case 4:
                 $sortowanie=" ORDER BY `cat` ASC";
                 break;

                default:
                 $sortowanie=" ORDER BY nombers.pno DESC ";
                 break;
                }
if(!isset($letter)) $letter='%';
else $letter=$letter.'%';


//$row->homephone
//$row->mobilephone


if (!$db->Open()) $db->Kill();
$q = "SELECT `n`.`ID`, `n`.`pno`, `n`.`firstname`, `n`.`surname`, `n`.`knownas`, `n`.`status`, `n`.`cat`, `n`.`started`, `details`.`homephone` , `details`.`mobilephone`, `cat`.`catname` FROM `nombers` n CROSS JOIN  `staffdetails` details ON `n`.`pno` = `details`.`no` LEFT JOIN  `emplcat` cat ON `n`.`cat` = `cat`.`catozn` WHERE `status` LIKE 'OK' and cat<>'c'"; 
$q=$q.$sortowanie;

$colour_odd = "DataTD"; 
$colour_even = "DataTDGrey"; 
$row_count=0;
if ($db->Query($q)) 
  {
	$ileich=$db->Rows();
    while ($row=$db->Row())
    {
	$clocking = $row->pno;
	if(!isset($row->started) || $row->started == "0000-00-00" || $row->started == "") {$HowManyDaysFromStart =  "NONE"; }
	else {$HowManyDaysFromStart =  datediff( "d", $row->started, date("Y-m-d", time()), false ) ; }

		if (!$db1->Open()) $db1->Kill();
		$opis="SELECT `no` FROM `staffdetails` WHERE `no`=$clocking";
		if (!$db1->Query($opis)) $db1->Kill(); 
		$rows=$db1->Rows();
		if($rows < 1) {  $obraz="<a CLASS='DataLink' href='hr_add.php?cln=$clocking'><IMG SRC='images/zoom.png' WIDTH='16' HEIGHT='16' BORDER='0' TITLE='Staff details'></A>";  }
		else { $obraz="<a CLASS='DataLink' href='hr_data.php?cln=$clocking'><IMG SRC='images/report.png' WIDTH='16' HEIGHT='16' BORDER='0' TITLE='Staff details'></A>";} 

			$row_count++;
			$row_color = (($row_count % 2) == 0) ? $colour_even : $colour_odd;
			echo "<tr>
			<td CLASS='$row_color'>$obraz </td>
			<td CLASS='$row_color'><a CLASS='DataLink' href='hr_data.php?cln=$clocking'><B>$row->pno</B></a></td>
			<td CLASS='$row_color'>$row->knownas</td>
			<td CLASS='$row_color'>$row->surname</td>
			<td CLASS='$row_color'>$row->catname </td>
			<td CLASS='$row_color'>$row->homephone</td>
			<td CLASS='$row_color'>$row->mobilephone</td>
			</tr>";
		unset($obraz);

  } 
} else {
echo " 
  <tr>
    <td CLASS='DataTD'></td>
    <td CLASS='DataTD' colspan='3'>Brak dzialow</td>
  </tr>";
 $db->Kill();
}
echo "
  <tr>
    <td align='left' CLASS='FooterTD' nowrap> &nbsp;</td>
    <td align='middle' CLASS='FooterTD' colspan='5' nowrap>&nbsp;Total: $ileich </td>
  </tr>
</table>";
echo "</center>
<BR>
</td></tr>
</table>
";
include_once("./footer.php");
?>
