<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;

echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>

<center>
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE' bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white'>
<tbody>
<tr>
<td class='FieldCaptionTD'><B>LP</B></td>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=1&kier=$kier'><B>$ZLNRZAMPL1</B>$kier_img[1]</A></td>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=2&kier=$kier'><B>$suplayer</B>$kier_img[2]</A></td>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=3&kier=$kier'><B>$datestarted</B>$kier_img[3]</A></td>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=4&kier=$kier'><B>$dateplaced</B>$kier_img[4]</a></td>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=5&kier=$kier'><B>$HDSTAN</B>$kier_img[5]</A></td>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=6&kier=$kier'><B>$RPNUSER</B>$kier_img[6]</A></td>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=7&kier=$kier'><B>$DAN</B>$kier_img[7]</A></td>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=8&kier=$kier'><B>$DA1</B>$kier_img[8]</A></td>
</tr>";

if (!$db->Open()) $db->Kill();

if(!isset($sort)) $sort=9;

	switch ($sort)
		{
		case 1:
		 $sortowanie=" ORDER BY `OrderID` $kier_sql";
		 break;
		case 2:
		 $sortowanie=" ORDER BY `Company` $kier_sql";
		 break;
		case 3:
		 $sortowanie=" ORDER BY ds $kier_sql";
		 break;
		case 4:
		 $sortowanie=" ORDER BY datep $kier_sql";
		 break;
		case 5:
		 $sortowanie=" ORDER BY `Status` $kier_sql";
		 break;
		case 6:
		 $sortowanie=" ORDER BY `PlacedBy` $kier_sql";
		 break;
		case 7:
		 $sortowanie=" ORDER BY `Name` $kier_sql";
		 break;
		case 8:
		 $sortowanie=" ORDER BY `Address1` $kier_sql";
		 break;
		case 9:
		 $sortowanie=" ORDER BY `OrdersTbl`.`OrderID` $kier_sql";
		 break;
		default:
		 $sortowanie=" ORDER BY `OrderID` ASC";
		 break;
		}


if(!isset($nr_zam_o)){
    $sql =("SELECT `OrdersTbl`.`OrderID`, `SuppliersTbl`.`Company`, `DeliveryAddressesTbl`.`Name`, `DeliveryAddressesTbl`.`Address1`, `StatusTbl`.`Status`, `OrdersTbl`.`PlacedBy`, DATE_FORMAT(`OrdersTbl`.`DateStarted`, '%Y/%m/%d') as ds, DATE_FORMAT(`OrdersTbl`.`DatePlaced`, '%Y/%m/%d') as datep, `OrdersTbl`.`InvoiceNo` FROM ((`SuppliersTbl` INNER JOIN `OrdersTbl` ON `SuppliersTbl`.`SupplierID` = `OrdersTbl`.`SupplierID`) LEFT JOIN `DeliveryAddressesTbl` ON `OrdersTbl`.`DeliveryAddress` = `DeliveryAddressesTbl`.`DeliveryAddressID`) INNER JOIN `StatusTbl` ON `OrdersTbl`.`StatusID` = `StatusTbl`.`StatusID` WHERE `OrdersTbl`.`StatusID` = 2");
}else{
   $sql =("SELECT `OrdersTbl`.`OrderID`, `SuppliersTbl`.`Company`, `DeliveryAddressesTbl`.`Name`, `DeliveryAddressesTbl`.`Address1`, `StatusTbl`.`Status`, `OrdersTbl`.`PlacedBy`, DATE_FORMAT(`OrdersTbl`.`DateStarted`, '%Y/%m/%d') as ds, DATE_FORMAT(`OrdersTbl`.`DatePlaced`, '%Y/%m/%d') as datep, `OrdersTbl`.`InvoiceNo` FROM ((`SuppliersTbl` INNER JOIN `OrdersTbl` ON `SuppliersTbl`.`SupplierID` = `OrdersTbl`.`SupplierID`) LEFT JOIN `DeliveryAddressesTbl` ON `OrdersTbl`.`DeliveryAddress` = `DeliveryAddressesTbl`.`DeliveryAddressID`) INNER JOIN `StatusTbl` ON `OrdersTbl`.`StatusID` = `StatusTbl`.`StatusID` WHERE `OrdersTbl`.`StatusID` = 2");

}
	$q=$sql.$sortowanie;

  if (!$db->Query($q)) $db->Kill();
$licz=1;
    while ($row=$db->Row())
    {
    
    echo "<tr>
        <td class='DataTD'><B>$licz</B></td>
		<td class='DataTD'><A HREF='order1.php?order=$row->OrderID'><B>$row->OrderID</B></A></td>
        <td class='DataTD'><A HREF='order1.php?order=$row->OrderID'>$row->Company</A></td>
        <td class='DataTD'>$row->ds</td>
        <td class='DataTD'>$row->datep</td>
        <td class='DataTD'>$row->Status</td>
        <td class='DataTD'>$row->PlacedBy</td>
       <td class='DataTD'>$row->Name</td>
       <td class='DataTD'>$row->Address1</td>
    	<td class='DataTD'><A HREF='order1.php?order=$row->OrderID'><IMG SRC='images/edit.png' BORDER='0' ALT='Edit'></A></td>

      </tr>";
     $licz++;			
   } // koniec pentli


echo "</table>
</td></tr>
</table> 

</td></tr></table></form></center>
";
include_once("./footer.php");
?>