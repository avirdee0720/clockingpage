<?php
//if(!isset($id) && !isset($pw))
//{header("Location: index.html"); exit;}

//$ASN = substr("$towar->ASNAZWA",0,10);
include_once("./header.php");
$tytul='Ilu kopi danego programu mamy w uzycu.';
$nP="$PHP_SELF";
include_once("./inc/mlfn.inc.php");

echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
<center>
<H3>$tytul</H3>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE' bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white'>
    <tbody>
<tr>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=1'><B>Program nazwa</B></A></td>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=2'><B>Kopii prg.</B></A></td>
</tr>";
//$db = new CMySQL;
if (!$db->Open()) $db->Kill();

switch ($sort)
		{
		case 1:
		 $sortowanie=" ORDER BY kopii ASC";
		 break;
		default:
		 $sortowanie=" ORDER BY hd_programyall.prg_nazwa, hd_program.id_zest";
		 break;
		}

    $sql =("SELECT Count(hd_program.id_nazwa) AS kopii, hd_programyall.prg_nazwa FROM hd_program INNER JOIN hd_programyall ON hd_program.id_nazwa = hd_programyall.id_prg GROUP BY hd_program.id_nazwa, hd_programyall.prg_nazwa HAVING (((Count(hd_program.id_nazwa))>1))");

	$q=$sql.$sortowanie;

  if (!$db->Query($q)) $db->Kill();

    while ($row=$db->Row())
    {

    echo "<tr>
        <td class='DataTD'><A HREF='zest.php'><B>$row->prg_nazwa</B></A></td>
        <td class='DataTD'><B>$row->kopii</B></td>
      </tr>";
			
   } // koniec pentli z zamowieniem

  echo "<tr>
    <td align='middle' class='FooterTD' colspan='9' nowrap>
	<table><tr> 
	<td>".first($start,$numrows,$rown,$nP)."</td> 
	<td>".previous($start,$numrows,$rown,$nP)."</td> 
	<td>".next1($start,$numrows,$rown,$nP)."</td> 
	<td>".last($start,$numrows,$rown,$nP)."</td> 
</tr></table>
</td></tr>
</table> 

</td></tr></table></form></center>
";
include_once("./footer.php");
?>