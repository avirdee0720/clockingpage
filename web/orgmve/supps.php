<?php
include_once("./config.php");
include_once("./header.php");
include("./suppdisp.php");
//include_once("./inc/mlfn.inc.php");
$PHP_SELF = $_SERVER['PHP_SELF'];

if (isset($_GET['kier'])) $kier = $_GET['kier'];

$db = new CMySQL;
$numrows=15;

if($kier==0){
	$kier_sql="";
	$kier=1;
}else{
	$kier_sql="DESC";
	$kier=0;
}
echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>

<center>
<a HREF='n_sup.php'><IMG SRC='images/ins.png' BORDER='0' title='$OBJADDSUPP'>$OBJADDSUPP</a> 
<a HREF='prod1.php'><IMG SRC='images/ins.png' BORDER='0' title='$OBJADD'>$OBJADD $PRODUCT</a>
<a HREF='javascript:window.print()'><IMG SRC='images/print.png' BORDER='0' title='$PRINTBTN'>$PRINTBTN</a>
<hr>
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE' bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white'>
<tbody>
<tr>
<td class='FieldCaptionTD'><B>LP</B></td>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=1&kier=$kier'><B>$Supp</B></A></td>
	<!-- <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=2&kier=$kier'><B>$categ</B></A></td> -->
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=3&kier=$kier'><B>$PRODUCT</B></A></td>
<td class='FieldCaptionTD'><B>$TYTED</B></td>
<td class='FieldCaptionTD'><B>U P</B></td>
<td class='FieldCaptionTD'><B>WWW</B></td>
<td class='FieldCaptionTD'><B>Info</B></td>
</tr>";

if (!$db->Open()) $db->Kill();

if(isset($sort))
{
	switch ($sort)
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
    $wwwlink = ltrim($row->www, "#");
    
    $doWysw=$db->Fix("<table><tr><td > $Company </td>       <td>  $row->Company &nbsp;</td></tr><tr><td > $CompanyName </td><td>  $row->CompanyName &nbsp;</td>  </tr> <tr>  <td > $SupplierCategory </td> <td >$row->SupplierCategory </td></td><tr><td > $Address1 </td><td>  $row->Address1 &nbsp;</td></tr><tr><td > $Address2 </td><td>  $row->Address2 </td></tr><tr><td > $Address3 </td><td>  $row->Address3 </td></tr><tr><td > $CityRegion </td><td>  $row->CityRegion </td></tr><tr><td > $PostalCode </td><td>  $row->PostalCode </td></tr><tr><td > $VAT </td><td>  $row->VATNo </td></tr><tr><td > $ContactName </td><td>  $row->ContactName </td></tr><tr><td > $Phone1 </td><td>  $row->Phone1 </td></tr><tr><td > $Phone2 </td><td>  $row->Phone2 </td></tr><tr><td > $Fax </td><td>  $row->Fax </td></tr><tr><td > $email </td><td>  $row->email </td></tr><tr><td > $www </td><td>  $row->www </td></tr><tr><td > $MethodOfPayment </td><td>  $row->MethodOfPayment </td></tr><tr><td > $AccountNo </td><td>  $row->AccountNo </td></tr><tr><td > $DeliverySpeed </td><td>  $row->DeliverySpeed </td></tr><tr><td > $WhoAreTheyAndWhatDoTheyDo </td><td>  $row->WhoAreTheyAndWhatDoTheyDo </td> </tr></TABLE>");
    echo "<tr>
        <td class='DataTD'><B>$licz</B></td>
	    <td class='DataTD'><A TITLE='$row->WhoAreTheyAndWhatDoTheyDo' HREF='order0.php?SID=$row->SupplierID'>$row->Company</A></td>
 	<!--       <td class='DataTD'>$row->SupplierCategory </td> -->
       
        <td class='DataTD' align=center><A TITLE='TEL: $row->Phone1, FAX: $row->Fax, $row->WhoAreTheyAndWhatDoTheyDo ' HREF='prod2.php?SID=$row->SupplierID' ALT=''>".number_format($row->ile,0,',',' ')."</a></td>
	<td class='DataTD'><A HREF='supp1.php?SID=$row->SupplierID&liczz=$row->ile'><IMG SRC='images/edit.png' BORDER='0' title='edit'></A></td>
	<td class='DataTD'><A HREF='u-prices1.php?SID=$row->SupplierID&liczz=$row->ile'><IMG SRC='images/edit.png' BORDER='0' title='edit'></A></td>
	<td class='DataTD'><A HREF='$wwwlink' target='_Blank'>www</A></td>
	<td class='DataTD'><a href=\"javascript:void(0);\" onmouseover=\"return overlib('$doWysw', '', CAPTION,'$row->CompanyName', RELX,60, RELY,0);\" onclick=\"return nd();\"><IMG SRC=\"images/info.gif\" BORDER='0'></a>
</td>
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