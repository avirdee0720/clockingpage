<?php
include("./config.php");
include_once("./header.php");

$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$db1 = new CMySQL;
$db2 = new CMySQL;
$db3 = new CMySQL;
$tytul='Staff settings';

if (!isset($_POST['state'])) $state = 0; else $state = $_POST['state'];
for ($i = 1; $i <= 6000; $i++) {
    (!isset($_POST["newstatus_$i"])) ? $newstatus[$i] = "" : $newstatus[$i] = $_POST["newstatus_$i"];
}

//init $kier_img by Greg
for ($index = 0; $index <= 6; $index++ ) {
    if (!isset($kier_img[$index]))
        $kier_img[$index] = "";
}

uprstr($PU,50);

if (!isset($_GET['letter'])) {
    if (!isset($_POST['letter'])) $letter = "A";
    else $letter = $_POST['letter'];    
}
else $letter = $_GET['letter'];

if (!isset($_GET['sort'])) {
    if (!isset($_POST['sort'])) $sort = 0;
    else $sort = $_POST['sort'];    
}
else $sort = $_GET['sort'];

if (!isset($_GET['kier'])) {
    if (!isset($_POST['kier'])) $kier = 0;
    else $kier = $_POST['kier'];    
}
else $kier = $_GET['kier'];

if ($kier==0) { $kier_sql="DESC"; $kier=1; }
else { $kier_sql="ASC"; $kier=0; }


if($state==0) {
    
echo "  <TD ALIGN=JUSTIFY VALIGN=TOP border=0>

<center>
<form action='$PHP_SELF' method='post' name='staffsettings'>

<font CLASS='FormHeaderFont'>$tytul&nbsp;&nbsp;   &nbsp;&nbsp;
 <font size='+2' colour='#0000FF'>letter:<big><b> <u>$letter</u></b> </big></font>upr
<BR>
<A HREF='$PHP_SELF?sort=$sort&letter=A'>A</a>
<A HREF='$PHP_SELF?sort=$sort&letter=B'>B</a>
<A HREF='$PHP_SELF?sort=$sort&letter=C'>C</a>
<A HREF='$PHP_SELF?sort=$sort&letter=D'>D</a>
<A HREF='$PHP_SELF?sort=$sort&letter=E'>E</a>
<A HREF='$PHP_SELF?sort=$sort&letter=F'>F</a>
<A HREF='$PHP_SELF?sort=$sort&letter=G'>G</a>
<A HREF='$PHP_SELF?sort=$sort&letter=H'>H</a>
<A HREF='$PHP_SELF?sort=$sort&letter=I'>I</a>
<A HREF='$PHP_SELF?sort=$sort&letter=J'>J</a>
<A HREF='$PHP_SELF?sort=$sort&letter=K'>K</a>
<A HREF='$PHP_SELF?sort=$sort&letter=L'>L</a>
<A HREF='$PHP_SELF?sort=$sort&letter=M'>M</a>
<A HREF='$PHP_SELF?sort=$sort&letter=N'>N</a>
<A HREF='$PHP_SELF?sort=$sort&letter=O'>O</a> 
<A HREF='$PHP_SELF?sort=$sort&letter=P'>P</a>
<A HREF='$PHP_SELF?sort=$sort&letter=R'>R</a>  
<A HREF='$PHP_SELF?sort=$sort&letter=S'>S</a>  
<A HREF='$PHP_SELF?sort=$sort&letter=T'>T</a>  
<A HREF='$PHP_SELF?sort=$sort&letter=U'>U</a>  
<A HREF='$PHP_SELF?sort=$sort&letter=W'>W</a>   
<A HREF='$PHP_SELF?sort=$sort&letter=V'>V</a>
<A HREF='$PHP_SELF?sort=$sort&letter=Q'>Q</a>
<A HREF='$PHP_SELF?sort=$sort&letter=X'>X</a>
<A HREF='$PHP_SELF?sort=$sort&letter=Y'>Y</a>
<A HREF='$PHP_SELF?sort=$sort&letter=Z'>Z</a>
</font><BR>

<table border='0' cellpadding='3' cellspacing='1' CLASS='FormTABLE'>
  <tr>

    <td CLASS='ColumnTD' nowrap>
                <A HREF='$PHP_SELF?sort=1&kier=$kier&letter=$letter'>NO $kier_img[1]</a>

        </td>
    <td CLASS='ColumnTD' nowrap>
                <A HREF='$PHP_SELF?sort=2&letter=$letter&kier=$kier'>Firstname $kier_img[2]</a>

        </td>
    <td CLASS='ColumnTD' nowrap>
                <A HREF='$PHP_SELF?sort=3&letter=$letter&kier=$kier'>Surname $kier_img[3]</a>

        </td>
    <td CLASS='ColumnTD' nowrap>
                <A HREF='$PHP_SELF?sort=4&letter=$letter&kier=$kier'>Known As $kier_img[4]</a>

        </td>
            <td CLASS='ColumnTD' nowrap>
                <A HREF='$PHP_SELF?sort=5&letter=$letter&kier=$kier'>Category $kier_img[5]</a>

        </td>
            <td CLASS='ColumnTD' nowrap>
                <A HREF='$PHP_SELF?sort=6&letter=$letter&kier=$kier'>Status $kier_img[6]</a>

        </td>
        </tr>
";

if (!$db->Open()) $db->Kill();

if(!isset($sort)) $sort=1;

        switch ($sort)
                {
                case 1:
                 $sortowanie=" ORDER BY pno $kier_sql";
                 break;
                case 2:
                 $sortowanie=" ORDER BY firstname $kier_sql";
                 break;
                case 3:
                 $sortowanie=" ORDER BY surname $kier_sql";
                 break;
                case 4:
                 $sortowanie=" ORDER BY knownas $kier_sql";
                 break;
                case 5:
                 $sortowanie=" ORDER BY cat $kier_sql";
                 break;
                case 6:
                 $sortowanie=" ORDER BY status $kier_sql";
                 break;

                default:
                 $sortowanie=" ORDER BY nombers.pno ASC";
                 break;
                }

if (!$db->Open()) $db->Kill();

$q = "SELECT `ID`, `pno`, `firstname`, `surname`, `knownas`, `status`, `cat`, `displ`, `decision`
FROM `nombers`
LEFT JOIN  `staffdetails` ON `nombers`.`pno` = `staffdetails`.`no`
WHERE `knownas` LIKE '$letter%'";

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
	// brackets
	 if( $row->displ == 0) {
		 $Bknownas="$row->knownas";
	} else {

	switch ($row->displ)
		{
		case 1:
		// [ brackets
		 $Bknownas="[$row->knownas]";
		 break;
		case 2:
		// ( brackets
		 $Bknownas="($row->knownas)";
		 break;
		case 3:
		//capitals
		 $str = strtoupper("$row->knownas");
		 $Bknownas="$str ";
		 break;
		
		default:
		 $Bknownas="$row->knownas";
		 break;
		}
	}
	/// brackets end
		if (!$db1->Open()) $db1->Kill();
		$opis="SELECT `no` FROM `staffdetails` WHERE `no`=$clocking";
		if (!$db1->Query($opis)) $db1->Kill(); 
		$rows=$db1->Rows();
		if($rows < 1) {  $obraz="<a CLASS='DataLink' href='hr_add.php?cln=$clocking'><IMG SRC='images/zoom.png' WIDTH='16' HEIGHT='16' BORDER='0' TITLE='Staff details'></A>";  }
		else { $obraz="<a CLASS='DataLink' href='hr_data.php?cln=$clocking'><IMG SRC='images/report.png' WIDTH='16' HEIGHT='16' BORDER='0' TITLE='Staff details'></A>";} 

	$row_count++;
	$row_color = (($row_count % 2) == 0) ? $colour_even : $colour_odd;
                if ($row->status == "OK") $selected = "selected "; else $selected = " ";
		echo "<tr>
		<td CLASS='$row_color'><a CLASS='DataLink' href='hr_data.php?cln=$clocking'><B>$row->pno</B></a></td>
		<td CLASS='$row_color'>$row->firstname</td>
		<td CLASS='$row_color'>$row->surname</td>
		<td CLASS='$row_color'>$Bknownas</td>
		<td CLASS='$row_color'>$row->cat</td>
                <td CLASS='$row_color'><select class='Select' name='newstatus_$row->pno'>
                    <option "; if ($row->status == "OK") echo "selected "; echo " value='OK'>OK</option>
                    <option "; if ($row->status == "LEAVER") echo "selected "; echo " value='LEAVER'>LEAVER</option>
                </select></td>
                        
                        </td>
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
echo "
<input name='state' type='hidden' value='1'>
<input name='sort' type='hidden' value='$sort'>
<input name='letter' type='hidden' value='$letter'>
<input name='kier' type='hidden' value='$kier'>
<input class='Button' name='Save status' type='submit' value='$SAVEBTN'>
</FORM>
</center>
<BR>
</td></tr>
</table>
";

} //if state = 0

elseif($state == 1) {
    
    for ($i = 0; $i <= 6000; $i++) {
        if ($newstatus[$i] != "") {
            if (!$db2->Open()) $db2->Kill();
            $q2 = "SELECT `status` FROM `nombers` WHERE `pno` = '$i'";
            $db2->Query($q2);
            $row2=$db2->Row();
            if ($row2->status != $newstatus[$i]) {
                $q3 = ("UPDATE `nombers` SET `status`='$newstatus[$i]' WHERE `pno` = '$i' AND `status` = \"$row2->status\"");
                //echo $q3;
                if (!$db3->Open()) $db3->Kill();
                mysql_query($q3);
            }
        }
    }
    echo "<script language='javascript'>window.location=\"staffsettings.php?letter=$letter&sort=$sort&kier=$kier\"</script>";
    
}

include_once("./footer.php");

?>
