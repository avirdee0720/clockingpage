<?php
//if(!isset($id) && !isset($pw))
//{header("Location: index.html"); exit;}
//$ASN = substr("$towar->ASNAZWA",0,10);

include_once("./header.php");
include("./languages/$LANGUAGE.php");
include_once("./inc/mlfn.inc.php");
$nP="$PHP_SELF";
$numrows=15;
if(!isset($kier))$kier=0;
if($kier==0){
	$kier_sql="";
	$kier=1;
}else{
	$kier_sql="DESC";
	$kier=0;
}
echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>

<center>
<a HREF='zl_obiekty_ed.php?nowy=1'><IMG SRC='images/ins.png' BORDER='0' title='$OBJADD'>$OBJADD</a>
<a HREF='javascript:window.print()'><IMG SRC='images/print.png' BORDER='0' title='$PRINTBTN'>$PRINTBTN</a>
<hr>
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE' bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white'>
<tbody>
<tr>
<td class='FieldCaptionTD'><B>LP</B></td>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=1&kier=$kier'><B>$ZLNRPOZ</B></A></td>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=2&kier=$kier'><B>$ZLOBJ</B></A></td>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=3&kier=$kier'><B>$zl</B></A></td>
<td class='FieldCaptionTD'><B>$TYTED</B></td>
<td class='FieldCaptionTD'><B>$NEWBTN</B></td>
</tr>";

if (!$db->Open()) $db->Kill();

if(isset($sort))
{
	switch ($sort)
		{
		case 1:
		 $sortowanie=" ORDER BY nr_zam_o $kier_sql";
		 break;
		case 2:
		 $sortowanie=" ORDER BY obj $kier_sql";
		 break;
		case 3:
		 $sortowanie=" ORDER BY liczba_zlec $kier_sql";
		 break;
		
		}
	} else {
		$sortowanie=" ORDER BY nr_zam_o $kier_sql";
	}


    $sql =("SELECT zl_object.nr_zam_o, zl_object.obj, Count(zl_zlec.lp) AS liczba_zlec
FROM zl_zlec RIGHT JOIN zl_object ON zl_zlec.nr_zam_o = zl_object.nr_zam_o
GROUP BY zl_object.nr_zam_o, zl_object.obj ");

	$q=$sql.$sortowanie;

  if (!$db->Query($q)) $db->Kill();
$licz=1;
    while ($row=$db->Row())
    {
    
    echo "<tr>
        <td class='DataTD'><B>$licz</B></td>
	    <td class='DataTD'>$row->nr_zam_o</td>
        <td class='DataTD'>$row->obj </td>
       
        <td class='DataTD' align=center><A TITLE='Poka¿ zlecenia' HREF='zl_lista.php?nr_zam_o=$row->nr_zam_o'>".number_format($row->liczba_zlec,0,',',' ')."</a></td>
		<td class='DataTD'><A HREF='zl_obiekty_ed.php?nr_zam_o=$row->nr_zam_o&liczz=$row->liczba_zlec'><IMG SRC='images/edit.png' BORDER='0' title='$OBJED'></A></td>
		<td class='DataTD'><A HREF='zl_new.php?nr_zam_o=$row->nr_zam_o'><IMG SRC='images/ins.png' BORDER='0' title='$TYTNZL'></A></td>

		</tr>
    <input name='zest' type='hidden' value='$row->nr_zam_o'>";
     $licz++;			
   } // koniec pentli

echo "</table>
</td></tr>
</table> 

</td></tr></table></form></center>
";
include_once("./footer.php");
?>