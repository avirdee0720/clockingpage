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
<td class='FieldCaptionTD'><A HREF='zl_htp.php?sort=2'><B>$ZLNRZAMDE1</B></A></td>
<td class='FieldCaptionTD'><A HREF='zl_htp.php?sort=3'><B>$ZLNRPOZ</B></A></td>
<td class='FieldCaptionTD'><A HREF='zl_htp.php?sort=1'><B>$ZLNRZAMPL1</B></A></td>
<td class='FieldCaptionTD'><A HREF='zl_htp.php?sort=4'><B>$ZLNRK</B></a></td>
<td class='FieldCaptionTD'><A HREF='zl_htp.php?sort=6'><B>$DSNAZWA</B></A></td>
<td class='FieldCaptionTD'><A HREF='zl_htp.php?sort=5'><B>$ZLOBJ</B></A></td>
<td class='FieldCaptionTD'><B>$ZLTNZ</B></td>
<td class='FieldCaptionTD'><B>$ZLDOSTMD</B></td>
<td class='FieldCaptionTD'><B>$ZLKONS</B></td>
<td class='FieldCaptionTD'><B>$ZLTP1</B></td>
<td class='FieldCaptionTD'><B>$ZLTGZ2</B></td>
<td class='FieldCaptionTD'><B>$ZLTGZ3</B></td>
<td class='FieldCaptionTD'><B>$ZLTGZ4</B></td>
<td class='FieldCaptionTD'><B>$ZLKTERM</B></td>
<td class='FieldCaptionTD'><B>$ZLKPARTNER</B></td>
<td class='FieldCaptionTD'<B>$ZLKDATADO</B></td>
<td class='FieldCaptionTD'<B>$RPNDATE</B></td>
<td class='FieldCaptionTD'<B>$DSUWAGI</B></td>
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
		 $sortowanie=" ORDER BY nazwa ASC";
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

$sdb = new CMySQL;
if (!$sdb->Open()) $sdb->Kill();

    $sql =("SELECT  zl_zlec.lp, zl_zlec.nr_zam_pl, zl_zlec.nr_zam_o, zl_zlec.nr_poz, zl_zlec.nr_kom, zl_zlec.obj, zl_zlec.nazwa, zl_zlec.w_z_e, zl_zlec.kurs, zl_zlec.w_z_p, zl_zlec.tn_zam, zl_zlec.data_wp, zl_zlec.id_wpr, zl_zlec.data_popr, zl_zlec.id_popr, zl_zlec.data, zl_zlec.dostMD, zl_zlec.konserwacja, zl_zlec.TP, zl_zlec.ktermin, zl_zlec.kpartner, zl_zlec.kdata, zl_zlec.uwagi FROM zl_zlec WHERE zak<>'t' ");

	$q=$sql.$sortowanie;
//        SUM(zl_tech.tn_wys) AS Stn_wys
  if (!$db->Query($q)) $db->Kill();
$licz=1;

    while ($row=$db->Row())
    {
        $sql2 =("SELECT SUM(zl_tech.g_przyg) AS Sg_przyg, SUM(zl_tech.g_mont) AS Sg_mont, SUM(zl_tech.g_kons) AS Sg_kons FROM zl_tech WHERE zl_tech.id_zlec='$row->lp'");
        if (!$sdb->Query($sql2)) $sdb->Kill();
		$godziny=$sdb->Row();
    echo "<tr>
        <td class='DataTD'><B>$licz</B></td>
        <td class='DataTD'>$row->nr_zam_o</td>
        <td class='DataTD'>$row->nr_poz</td>
		<td class='DataTD'><A HREF='zl_1.php?idzl=$row->lp'><B>$row->nr_zam_pl</B></A></td>
        <td class='DataTD'>$row->nr_kom</td>
        <td class='DataTD'>$row->nazwa</td>
        <td class='DataTD'>$row->obj</td>
        <td class='DataTD8'>".number_format($row->tn_zam,0,',',' ')."</td>
        <td class='DataTD'>$row->dostMD</td>
        <td class='DataTD'>$row->konserwacja</td>
        <td class='DataTD'>$row->TP</td>
        <td class='DataTD'>$godziny->Sg_przyg</td>
        <td class='DataTD'>$godziny->Sg_mont</td>
        <td class='DataTD'>$godziny->Sg_kons</td>
        <td class='DataTD'>$row->ktermin</td>
        <td class='DataTD'>$row->kpartner</td>
        <td class='DataTD'>$row->kdata</td>
        <td class='DataTD'>$row->data</td>
        <td class='DataTD'><small>$row->uwagi</small></td>
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