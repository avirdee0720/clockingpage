<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$db1 = new CMySQL;
$tytul='Temporary Staff admin';

uprstr($PU,50);

if (empty($_GET["dir"])) {
    $dir="0";
} else {
    $dir = $_GET["dir"];
}

if (!$db->Open()) $db->Kill();

$dirtxt = " DESC";

if(!isset($sort)) $sort=1;
if ($dir == "1") {$dir = "0"; $dirtxt = " ASC";}
else  {$dir = "1"; $dirtxt = " DESC";}
        switch ($sort)
                {
                case 1:
                 $sortowanie=" ORDER BY ID $dirtxt";
                 break;
                case 2:
                 $sortowanie=" ORDER BY firstname $dirtxt";
                 break;
                case 3:
                 $sortowanie=" ORDER BY surname $dirtxt";
                 break;
                case 4:
                 $sortowanie=" ORDER BY knownas $dirtxt";
                 break;
                case 5:
                 $sortowanie=" ORDER BY cat $dirtxt";
                 break;
                 

                default:
                 $sortowanie=" ORDER BY temp_nombers.ID $dirtxt ";
                 break;
                }

echo "  <TD ALIGN=JUSTIFY VALIGN=TOP border=0>

<center>


<font CLASS='FormHeaderFont'>$tytul&nbsp;&nbsp;   &nbsp;&nbsp;
 <BR>
<input CLASS='Button'  type='Button' onclick='window.location=\"stafflista_temp_addedit.php\"' value='New Temporary employee'>
<table border='0' cellpadding='3' cellspacing='1' CLASS='FormTABLE'>
  <tr>
  
    <td CLASS='ColumnTD' nowrap>
                <A HREF='$PHP_SELF?sort=1&dir=$dir'> Temp NO</a>

        </td>
    <td CLASS='ColumnTD' nowrap>
                <A HREF='$PHP_SELF?sort=2&dir=$dir'>First name</a>

        </td>
    <td CLASS='ColumnTD' nowrap>
                <A HREF='$PHP_SELF?sort=3&dir=$dir'>Surname</a>

        </td>
    <td CLASS='ColumnTD' nowrap>
                <A HREF='$PHP_SELF?sort=4&dir=$dir'>Known AS</a>

        </td>
            <td CLASS='ColumnTD' nowrap>
                <A HREF='$PHP_SELF?sort=5&dir=$dir'>Category</a>

        </td>
          <td CLASS='ColumnTD' nowrap>&nbsp;</td>
          <td CLASS='ColumnTD' nowrap>&nbsp;</td>
        </tr>
";


if (!$db->Open()) $db->Kill();
$q = "SELECT `ID`, `pno`, `firstname`, `surname`, `knownas`, `status`, `cat` FROM `temp_nombers` WHERE `status` LIKE 'TEMP'";
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
	$Bknownas="$row->knownas";
		if (!$db1->Open()) $db1->Kill();
		
	$row_count++;
	$row_color = (($row_count % 2) == 0) ? $colour_even : $colour_odd;
		echo "<tr>
		<td CLASS='$row_color'>$row->ID</td>
		<td CLASS='$row_color'><a CLASS='DataLink' href='dailyappraisal.php?ID=$row->ID&edit=1'><B>$row->firstname</B></a></td>
		<td CLASS='$row_color'>$row->surname</td>
		<td CLASS='$row_color'>$Bknownas</td>
		<td CLASS='$row_color'>$row->cat</td>
		<td CLASS='$row_color'><a CLASS='DataLink' href='stafflista_temp_addedit.php?ID=$row->ID&edit=1'><IMG SRC='images/edit.gif' WIDTH='16' HEIGHT='16' BORDER='0' TITLE='Edit Temporary Staff details'></A></td>
		<td CLASS='$row_color'><a CLASS='DataLink' href='stafflista_temp_copy.php?ID=$row->ID&edit=1'><IMG SRC='images/jumpto.gif' WIDTH='16' HEIGHT='16' BORDER='0' TITLE='Copy to Normal Staff data'></A></td>
	
		</tr>";
		unset($obraz);
  } 
} else {
echo " 
  <tr>
    <td CLASS='DataTD'></td>
    <td CLASS='DataTD' colspan='4'>Brak dzialow</td>
  </tr>";
 $db->Kill();
}
echo "

  <tr>
    <td align='left' CLASS='FooterTD' nowrap> &nbsp;</td>
    <td align='middle' CLASS='FooterTD' colspan='6' nowrap>&nbsp;Total: $ileich </td>
  </tr>
</table>";
echo "</center>
<BR>
</td></tr>
</table>
";
include_once("./footer.php");
?>
