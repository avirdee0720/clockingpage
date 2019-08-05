<?php
//if(!isset($id) && !isset($pw))
//{header("Location: index.html"); exit;}
//$ASN = substr("$towar->ASNAZWA",0,10);

include_once("./header.php");
include("./languages/$LANGUAGE.php");
include_once("./inc/mlfn.inc.php");
$nP="$PHP_SELF";
$numrows=15;

echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>

<center>
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE' bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white'>
<tbody>
<tr>
<td class='FieldCaptionTD'><B>LP</B></td>
<td class='FieldCaptionTD'><A HREF='zl_lista.php?sort=1'><B>$ZLNRZAMPL1</B></A></td>
<td class='FieldCaptionTD'><A HREF='zl_lista.php?sort=2'><B>$ZLNRZAMDE1</B></A></td>
<td class='FieldCaptionTD'><A HREF='zl_lista.php?sort=3'><B>$ZLNRPOZ</B></A></td>
<td class='FieldCaptionTD'><A HREF='zl_lista.php?sort=4'><B>$ZLNRK</B></a></td>
<td class='FieldCaptionTD'><A HREF='zl_lista.php?sort=5'><B>$ZLOBJ</B></A></td>
<td class='FieldCaptionTD'><A HREF='zl_lista.php?sort=6'><B>$ZLWE</B></A></td>
<td class='FieldCaptionTD'><A HREF='zl_lista.php?sort=7'><B>$ZLWZ</B></A></td>
<td class='FieldCaptionTD'><A HREF='zl_lista.php?sort=8'><B>$ZLTNZ</B></A></td>
</tr>";

if (!$db->Open()) $db->Kill();

if(isset($sort))
{
	switch ($sort)
		{
		case 1:
		 $sortowanie=" ORDER BY nr_zam_pl ASC";
		 break;
		case 2:
		 $sortowanie=" ORDER BY nr_zam_o ASC";
		 break;
		case 3:
		 $sortowanie=" ORDER BY nr_poz ASC";
		 break;
		case 4:
		 $sortowanie=" ORDER BY nr_kom ASC";
		 break;
		case 5:
		 $sortowanie=" ORDER BY obj ASC";
		 break;
		case 6:
		 $sortowanie=" ORDER BY w_z_e ASC";
		 break;
		case 7:
		 $sortowanie=" ORDER BY w_z_p ASC";
		 break;
		case 8:
		 $sortowanie=" ORDER BY tn_zam ASC";
		 break;
		default:
		 $sortowanie=" ORDER BY hd_zestaw.Identyfikator ASC";
		 break;
		}
	} else {
		$sortowanie=" ORDER BY nr_zam_pl ASC";
	}

if(!isset($nr_zam_o)){
    $sql =("SELECT  lp, nr_zam_pl, nr_zam_o, nr_poz, nr_kom, obj, nazwa, w_z_e, kurs, w_z_p, tn_zam, uwagi, data_wp, id_wpr, data_popr, id_popr, data FROM zl_zlec WHERE zak<>'t' ");
}else{
   $sql =("SELECT  lp, nr_zam_pl, nr_zam_o, nr_poz, nr_kom, obj, nazwa, w_z_e, kurs, w_z_p, tn_zam, uwagi, data_wp, id_wpr, data_popr, id_popr, data FROM zl_zlec WHERE nr_zam_o='$nr_zam_o' ");

}
	$q=$sql.$sortowanie;

  if (!$db->Query($q)) $db->Kill();
$licz=1;
    while ($row=$db->Row())
    {
    
    echo "<tr>
        <td class='DataTD'><B>$licz</B></td>
		<td class='DataTD'><A HREF='zl_1.php?idzl=$row->lp'><B>$row->nr_zam_pl</B></A></td>
        <td class='DataTD'><A HREF='zl_1.php?idzl=$row->lp'>$row->nr_zam_o</A></td>
        <td class='DataTD'>$row->nr_poz</td>
        <td class='DataTD'><A HREF='zl_1.php?idzl=$row->lp'>$row->nr_kom</A></td>
        <td class='DataTD'><A HREF='zl_1.php?idzl=$row->lp'>$row->obj</A> </td>
       <td class='DataTD'>".number_format($row->w_z_e,2,',',' ')."</td>
        <td class='DataTD'>".number_format($row->w_z_p,2,',',' ')."</td>	
        <td class='DataTD'>".number_format($row->tn_zam,0,',',' ')."</td>
		<td class='DataTD'><A HREF='zl_ed_zl.php?idzl=$row->lp'><IMG SRC='images/edit.png' BORDER='0' ALT='Edit/Popraw'></A></td>
      </tr>
    <input name='zest' type='hidden' value='$row->lp'>";
     $licz++;			
   } // koniec pentli


/*  echo "<tr>
    <td align='middle' class='FooterTD' colspan='10' nowrap>
	<table><tr> 
	<td>".first($start,$numrows,$rown,$nP)."</td> 
	<td>".previous($start,$numrows,$rown,$nP)."</td> 
	<td>".next1($start,$numrows,$rown,$nP)."</td> 
	<td>".last($start,$numrows,$rown,$nP)."</td> 
</tr>
*/
echo "</table>
</td></tr>
</table> 

</td></tr></table></form></center>
";
include_once("./footer.php");
?>