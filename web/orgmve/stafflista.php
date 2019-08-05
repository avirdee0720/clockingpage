<?php
include("./config.php");
include_once("./header.php");

$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$db1 = new CMySQL;
$tytul='Staff admin';

//init $kier_img by Greg
for ($index = 0; $index <= 5; $index++ ) {
    if (!isset($kier_img[$index]))
        $kier_img[$index] = "";
}

uprstr($PU,50);

if (empty($_GET["letter"])) {
    $letter="A";
} else {
    $letter=$_GET["letter"];
}
    
echo "  <TD ALIGN=JUSTIFY VALIGN=TOP border=0>

<center>


<font CLASS='FormHeaderFont'>$tytul&nbsp;&nbsp;   &nbsp;&nbsp;
 <font size='+2' colour='#0000FF'>letter:<big><b> <u>$letter</u></b> </big></font>upr
<BR>
<A HREF='$PHP_SELF?sort=$sort&letter=A'>A</a>
<A HREF='$PHP_SELF?sort=$sort&letter=B'>B</a>
<A HREF='$PHP_SELF?sort=$sort&letter=C'>C</a>
<A HREF='$PHP_SELF?sort=$sort&letter=D'>D</a>
<A HREF='$PHP_SELF?sort=$sort&letter=E'>E</a>
<A HREF='$PHP_SELF?sort=$sort&letter=F'>F</a>
<A HREF='$PHP_SELF?sort=$sort&letter=g'>G</a>
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
<table border='0' cellpadding='3' cellspacing='1'>
<tr>
	<td align=\"center\"><input CLASS='Button'  type='Button' onclick='window.location=\"n_os.php\"' value='New employee'></td>
	<td align=\"center\"><input CLASS='Button' type='Button' onclick='window.location=\"stafflista_cas.php\"' value='Casual staff'></td>
	<td align=\"center\"><input CLASS='Button' type='Button' onclick='window.location=\"stafflista_reg.php\"' value='Regular staff'></td>
	<td align=\"center\"><input CLASS='Button' type='Button' onclick='window.location=\"stafflista_unp.php\"' value='Unpaid staff'></td>
</tr>
</table>

<table border='0' cellpadding='3' cellspacing='1' CLASS='FormTABLE'>
  <tr>

    <td CLASS='ColumnTD' nowrap>&nbsp;</td>
    <td CLASS='ColumnTD' nowrap>
                <A HREF='$PHP_SELF?sort=1&kier=$kier&letter=$letter'>NO  $kier_img[1]</a>

        </td>
    <td CLASS='ColumnTD' nowrap>
                <A HREF='$PHP_SELF?sort=2&letter=$letter&kier=$kier'>First name $kier_img[2]</a>

        </td>
    <td CLASS='ColumnTD' nowrap>
                <A HREF='$PHP_SELF?sort=3&letter=$letter&kier=$kier'>Surname $kier_img[3]</a>

        </td>
    <td CLASS='ColumnTD' nowrap>
                <A HREF='$PHP_SELF?sort=4&letter=$letter&kier=$kier'>Known AS $kier_img[4]</a>

        </td>
            <td CLASS='ColumnTD' nowrap>
                <A HREF='$PHP_SELF?sort=5&letter=$letter&kier=$kier'>Status $kier_img[5]</a>

        </td>
        </tr>
";

if (!$db->Open()) $db->Kill();

if(!isset($sort)) $sort=1;

        switch ($sort)
                {
                case 1:
                 $sortowanie=" ORDER BY pno  $kier_sql";
                 break;
                case 2:
                 $sortowanie=" ORDER BY firstname  $kier_sql";
                 break;
                case 3:
                 $sortowanie=" ORDER BY surname  $kier_sql";
                 break;
                case 4:
                 $sortowanie=" ORDER BY knownas  $kier_sql";
                 break;
                case 5:
                 $sortowanie=" ORDER BY status  $kier_sql";
                 break;

                default:
                 $sortowanie=" ORDER BY nombers.pno DESC ";
                 break;
                }
if(!isset($letter)) $letter='%';
else $letter=$letter.'%';

if (!$db->Open()) $db->Kill();
/*
$q = "SELECT `ID`, `pno`, `firstname`, `surname`, `knownas`, `status`, `cat`, `displ` FROM `nombers` LEFT JOIN  `staffdetails` ON `nombers`.`pno` = `staffdetails`.`no` WHERE `status` LIKE 'OK' AND `knownas` LIKE '$letter%' AND (
`staffdetails`.`decision` <> '4'
AND `staffdetails`.`decision` <> '3'
OR `staffdetails`.`decision` IS NULL
)";


$q = "SELECT `ID`, `pno`, `firstname`, `surname`, `knownas`, `status`, `cat`, `displ` FROM `nombers` LEFT JOIN  `staffdetails` ON `nombers`.`pno` = `staffdetails`.`no` WHERE `status` LIKE 'OK' AND `knownas` LIKE '$letter%'";
*/

$q = "SELECT `ID`, `pno`, `firstname`, `surname`, `knownas`, `status`, `cat`, `displ` FROM `nombers` LEFT JOIN  `staffdetails` ON `nombers`.`pno` = `staffdetails`.`no` WHERE `status` LIKE 'OK' AND `knownas` LIKE '$letter%' AND (
`staffdetails`.`decision` <> '4'
AND `staffdetails`.`decision` <> '3'
OR `staffdetails`.`decision` IS NULL
)";


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
		echo "<tr>
		<td CLASS='$row_color'>$obraz </td>
		<td CLASS='$row_color'><a CLASS='DataLink' href='hr_data.php?cln=$clocking'><B>$row->pno</B></a></td>
		<td CLASS='$row_color'>$row->firstname</td>
		<td CLASS='$row_color'>$row->surname</td>
		<td CLASS='$row_color'>$Bknownas</td>
		<td CLASS='$row_color'>$row->cat</td>
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
