<?php
//if(!isset($id) && !isset($pw))
//{header("Location: index.html"); exit;}

//include("./inc/uprawnienia.php");
include_once("./header.php");
$tytul='Staff admin';

if (empty($_GET["letter"])) {
    $letter="A";
} else {
    $letter=$_GET["letter"];
}

//uprstr($PU,50);

echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>

<center>


<font CLASS='FormHeaderFont'>$tytul&nbsp;&nbsp;   &nbsp;&nbsp;
 <font size='+2' colour='#0000FF'>letter:<big><b> <u>$letter</u></b> </big></font>
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
<A HREF='$PHP_SELF?sort=$sort&letter=Z'>Z</a>
</font><BR>
 
<input class='Button'  type='Button' onclick='window.location=\"n_os.php\"' value='New employee'>
<input class='Button'  type='Button' onclick='window.location=\"t_lista.php\"' value='Browse all'>

<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
  <tr>
    <td class='ColumnTD' nowrap>&nbsp;</td>
    <td class='ColumnTD' nowrap>
		<A HREF='$PHP_SELF?sort=1'>NO</a>

	</td>
    <td class='ColumnTD' nowrap>
		<A HREF='$PHP_SELF?sort=2'>First name</a>

	</td>
    <td class='ColumnTD' nowrap>
		<A HREF='$PHP_SELF?sort=3'>Surname</a>

	</td>
    <td class='ColumnTD' nowrap>
		<A HREF='$PHP_SELF?sort=4'>Known as</a>

	</td>
	    <td class='ColumnTD' nowrap>
		<A HREF='$PHP_SELF?sort=5'>Status</a>

	</td>
	</tr>
";

if (!$db->Open()) $db->Kill();

if(!isset($sort)) $sort=1;

	switch ($sort)
		{
		case 1:
		 $sortowanie=" ORDER BY pno DESC";
		 break;
		case 2:
		 $sortowanie=" ORDER BY firstname ASC";
		 break;
		case 3:
		 $sortowanie=" ORDER BY surname ASC";
		 break;
		case 4:
		 $sortowanie=" ORDER BY knownas ASC";
		 break;
		case 5:
		 $sortowanie=" ORDER BY status ASC";
		 break;

		default:
		 $sortowanie=" ORDER BY nombers.pno DESC ";
		 break;
		}
if(!isset($letter)) $letter='%';
else $letter=$letter.'%';

if (!$db->Open()) $db->Kill();
$q = "SELECT ID, pno, firstname, surname, knownas, status FROM nombers WHERE status like 'OK' AND knownas LIKE '$letter'";
$q=$q.$sortowanie;

  if ($db->Query($q)) 
  {
    while ($row=$db->Row())
    {

     echo "
  <tr>
    <td CLASS='DataTD'>   
        <a CLASS='DataLink' href='hollid1.php?cln=$row->pno'><IMG SRC='images/hollidays.gif' WIDTH='16' HEIGHT='16' BORDER='0' ALT='EDIT'></a>
        <a CLASS='DataLink' href='ed_os_k.php?lp=$row->pno'><IMG SRC='images/plac.gif' WIDTH='16' HEIGHT='16' BORDER='0' ALT='EDIT'></a>
        <a CLASS='DataLink' href='ed_os.php?lp=$row->ID'><IMG SRC='images/edit.png' BORDER='0' ALT='EDIT'></a>
        <a CLASS='DataLink' href='del_os.php?lp=$row->ID' onclick='return confirm(\"Do you really want to change status to LEAVER?\")'><IMG SRC='images/drop.png' BORDER='0' ALT='EDIT'></a>
        </td>
	 <td class='DataTD'>$row->pno</td>
    <td class='DataTD'>$row->firstname</td>
    <td class='DataTD'>$row->surname</td>
    <td class='DataTD'>$row->knownas</td>
    <td class='DataTD'>$row->status</td>
	 </tr>
  ";
  } 
} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='3'>Brak dzialow</td>
  </tr>";
 $db->Kill();
}
echo "
  <tr>
    <td align='left' class='FooterTD' nowrap> &nbsp;</td>
    <td align='middle' class='FooterTD' colspan='5' nowrap>&nbsp;</td>
  </tr>
</table>

</center>
<BR>
</td></tr>
</table>
";
include_once("./footer.php");
?>