<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;

if (!isset($_GET['order'])) $order = '0'; else $order = $_GET['order'];

echo "
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE' bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white'>
<tbody>
<tr>
<td class='FieldCaptionTD'><A HREF='prod1.php'><font class='FormHeaderFont'>
							$OBJADD $PRODUCT</font></A></td>
<td class='FieldCaptionTD'><A HREF='./d_order.php?order=$order' 
							onclick='return confirm(\"This will change status to canceled!\")'><font class='FormHeaderFont'>
							$DELBTN</font></A></td>
<td class='FieldCaptionTD'><A HREF='prtordr.php?order=$order' onclick='return confirm(\"This will change status to ...\")'>
							<font class='FormHeaderFont'>
							$PRINTBTN</font></A></td>
<td class='FieldCaptionTD'><A HREF='c_order.php?order=$order' onclick='return confirm(\"Is this order completed?\")'>
							<font class='FormHeaderFont'>
							$Complete</font></A></td>
</tr>
</tbody>
</table>
<BR>
<TD ALIGN=JUSTIFY VALIGN=TOP border=0>

<center>
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE' bordercolorlight='black' border='0' >
<tbody>
";

if (!$db->Open()) $db->Kill();

    $sql1 =("SELECT OrdersTbl.OrderID, OrdersTbl.SupplierID, DATE_FORMAT(OrdersTbl.DateStarted, '%Y/%m/%d') as ds, DATE_FORMAT(OrdersTbl.DatePlaced, '%Y/%m/%d') as dp, OrdersTbl.PlacedBy, OrdersTbl.DeliveryAddress, OrdersTbl.InvoiceNo, OrdersTbl.DeliveryNotes, OrdersTbl.StatusID, SuppliersTbl.Company, DeliveryAddressesTbl.Name, StatusTbl.Status FROM ((SuppliersTbl INNER JOIN OrdersTbl ON SuppliersTbl.SupplierID = OrdersTbl.SupplierID) LEFT JOIN DeliveryAddressesTbl ON OrdersTbl.DeliveryAddress = DeliveryAddressesTbl.DeliveryAddressID) INNER JOIN StatusTbl ON OrdersTbl.StatusID = StatusTbl.StatusID WHERE OrdersTbl.OrderID=$order ");

  if (!$db->Query($sql1)) $db->Kill();
      $prd=$db->Row();
      echo "<tr><td class='DataTD' colspan='6' >$ZLNRZAMPL: <FONT SIZE=+2 COLOR=#FF0000><B>$prd->OrderID</B></FONT>
	  &nbsp;-&nbsp;<A HREF='ed_order0.php?order=$order&SID=$prd->SupplierID'><font class='FormHeaderFont'>$TYTED $ZLZL</font></td></tr>
	  <tr>
        <td class='DataTD' colspan='2'>$suplayer: <B>$prd->Company</B></td>
		<td class='DataTD' colspan='2'>$datestarted: <B>$prd->ds</B></td>
        <td class='DataTD' colspan='2'>$dateplaced: <B>$prd->dp</B></td>
	</tr>
	<tr>
        <td class='DataTD' colspan='2'>$USERFULL: $prd->PlacedBy</td>
        <td class='DataTD' colspan='2'>$DA1: $prd->Name</td>
        <td class='DataTD' colspan='2'>$HDSTAN: $prd->Status</td>
      </tr>
</tbody>
</table>
<BR>
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE' bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white'>
<tbody>
<tr>
<td class='FieldCaptionTD'><B>LP</B></td>
<td class='FieldCaptionTD'><B>$PRODUCT</B></td>
<td class='FieldCaptionTD'><B>$PPrice</B></td>
<td class='FieldCaptionTD'><B>$Quantity</B></td>
<td class='FieldCaptionTD'><B>$TotalPrice</B></td>
<td class='FieldCaptionTD'><B>&nbsp;</B></td>
</tr>";

    $sql =("SELECT IndividualOrdersTbl.IndividualOrderID, IndividualOrdersTbl.OrderID, IndividualOrdersTbl.ProductSupplierID, IndividualOrdersTbl.CatalogueNo, IndividualOrdersTbl.QuantityPerUnit, IndividualOrdersTbl.Measure, IndividualOrdersTbl.UnitsPerPack, ProductSuppliersTbl.PackPrice AS PP, IndividualOrdersTbl.PacksOrdered, IndividualOrdersTbl.PacksDelivered, ProductsTbl.ProductName, ProductsTbl.Colour AS Expr1, ProductSuppliersTbl.PackPrice*IndividualOrdersTbl.PacksOrdered AS TotalPrice FROM ProductsTbl INNER JOIN (IndividualOrdersTbl INNER JOIN ProductSuppliersTbl ON IndividualOrdersTbl.ProductSupplierID = ProductSuppliersTbl.ProductSupplierID) ON ProductsTbl.ProductID = ProductSuppliersTbl.ProductID WHERE IndividualOrdersTbl.OrderID=$order");

 $q=$sql;
  if (!$db->Query($q)) $db->Kill();
  $licz=1;
  $GrandTotal=0;
    while ($row=$db->Row())
    {
    $GrandTotal=$GrandTotal + $row->TotalPrice;
    echo "<tr>
        <td class='DataTD'><B>$licz</B></td>
		<td class='DataTD'><B>$row->ProductName</B></td>
        <td class='DataTD'>$row->PP</td>
        <td class='DataTD'>$row->PacksOrdered</td>
        <td class='DataTD'>$row->TotalPrice</td>
		<td class='DataTD'><A HREF='del1.php?order=$order&iid=$row->IndividualOrderID' onclick='return confirm(\"Do you want to delete this item?  $row->ProductSupplierID \")'><IMG SRC='images/drop.png' BORDER='0' title='$TYTNZL'></A></td>
      </tr>";
     $licz++;			
   } // koniec pentli


echo "<tr><td class='DataTD' colspan='6' > Total order: <B>$GrandTotal</B></td></tr></table>
</td></tr>
</table> 

</td></tr></table></form></center>
";
include_once("./footer.php");
?>