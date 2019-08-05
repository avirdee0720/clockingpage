<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;


echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>

<center>
Please chose supplier for the new order....<BR>
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE' bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white'>
<tbody>
<tr>
<td class='FieldCaptionTD'><B>LP</B></td>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=1&kier=$kier'><B>$Supp</B></A></td>
	<!-- <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=2&kier=$kier'><B>$categ</B></A></td> -->
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=3&kier=$kier'><B>$PRODUCT</B></A></td>
	<!--<td class='FieldCaptionTD'><B>$TYTED</B></td>
<td class='FieldCaptionTD'><B>$NEWBTN</B></td>
-->
</tr>";

if (!$db->Open()) $db->Kill();

if(isset($_GET['sort'])) 
{
	switch ($_GET['sort'])
		{
		case 1:
		 $sortowanie=" ORDER BY Company $kier_sql";
		 break;
		case 2:
		 $sortowanie=" ORDER BY SupplierCategory $kier_sql";
		 break;
		case 3:
		 $sortowanie=" ORDER BY ile $kier_sql";
		 break;
		
		}
	} else {
		$sortowanie=" ORDER BY Company $kier_sql";
	}


    $sql =("SELECT Company, CompanyName, SupplierCategory, SupplierCategory2, Address1, Address2, Address3, CityRegion, PostalCode, VATNo, ContactName, Phone1, Phone2, Fax, email, www, MethodOfPayment, AccountNo, DeliverySpeed, WhoAreTheyAndWhatDoTheyDo, ProductSuppliersTbl.SupplierID, Count(ProductSuppliersTbl.ProductSupplierID) AS ile FROM SuppliersTbl RIGHT JOIN ProductSuppliersTbl ON SuppliersTbl.SupplierID = ProductSuppliersTbl.SupplierID Where `SuppliersTbl`.Valid='8' GROUP BY ProductSuppliersTbl.SupplierID");

	$q=$sql.$sortowanie;

  if (!$db->Query($q)) $db->Kill();
$licz=1;
    while ($row=$db->Row())
    {
    
    echo "<tr>
        <td class='DataTD'><B>$licz</B></td>
	    <td class='DataTD'><A TITLE='$row->WhoAreTheyAndWhatDoTheyDo' HREF='order0.php?SID=$row->SupplierID'>$row->Company</A></td>
 	<!--       <td class='DataTD'>$row->SupplierCategory </td> -->
       
        <td class='DataTD' align=center><A TITLE='show prod.' HREF='prod2.php?SID=$row->SupplierID'>".number_format($row->ile,0,',',' ')."</a></td>
	<td class='DataTD'><A HREF='order0.php?SID=$row->SupplierID'><IMG SRC='images/ins.png' BORDER='0' title='NEW ORDER'></A></td>

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