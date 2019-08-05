<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;

if (!isset($_POST['state'])) $state = 0; else $state = $_POST['state'];
if (!isset($_GET['order'])) $order = '0'; else $order = $_GET['order'];
if (isset($_POST['order'])) $order = $_POST['order'];
if (!isset($_GET['SID'])) $SID = '0'; else $SID = $_GET['SID'];
if (!isset($_POST['_SupplierID'])) $_SupplierID = '0'; else $_SupplierID = $_POST['_SupplierID'];
if (!isset($_POST['dateS'])) $dateS = '0000-00-00 00:00'; else $dateS = $_POST['dateS'];
if (!isset($_POST['_DeliveryAddressID'])) $_DeliveryAddressID = '0'; else $_DeliveryAddressID = $_POST['_DeliveryAddressID'];
if (!isset($_POST['_DeliveryNotes'])) $_DeliveryNotes = '0'; else $_DeliveryNotes = $_POST['_DeliveryNotes'];
if (!isset($_POST['_PlacedBy'])) $_PlacedBy = '0'; else $_PlacedBy = $_POST['_PlacedBy'];
if (!isset($_POST['_prdSup'])) $_prdSup = array(); else $_prdSup = $_POST['_prdSup'];
if (!isset($_POST['_qpu'])) $_qpu = array(); else $_qpu = $_POST['_qpu'];
if (!isset($_POST['_PP'])) $_PP = array(); else $_PP = $_POST['_PP'];
if (!isset($_POST['_qto'])) $_qto = array(); else $_qto = $_POST['_qto'];
if (!isset($_POST['licznik'])) $licz = '0'; else $licz = $_POST['licznik'];

if($state==0)
{
	echo "	  <font class='FormHeaderFont'>$TYTED $ZLZL $order </font><BR><BR>
<TD ALIGN=JUSTIFY VALIGN=TOP border=0>

<center>
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE' bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white'>
<tbody>
<tr>
<td class='FieldCaptionTD'><B>&nbsp;</B></td>
<td class='FieldCaptionTD'><B>$PRODUCT</B></td>
<td class='FieldCaptionTD'><B>$QPerUnit</B></td>
<td class='FieldCaptionTD'><B>$PPrice</B></td>
<td class='FieldCaptionTD'><B>$PricePerUnit</B></td>
<td class='FieldCaptionTD'><B>$Quantity</B></td>
<td class='FieldCaptionTD'><B>$TotalPrice</B></td>
</tr>";

if (!$db->Open()) $db->Kill();

if(!isset($nr_zam_o)){
    $sql =("SELECT ProductsTbl.ProductID, ProductsTbl.ProductName, SuppliersTbl.SupplierID, SuppliersTbl.Company, SuppliersTbl.CompanyName, ProductSuppliersTbl.CatalogueNo, ProductSuppliersTbl.QuantityPerUnit, ProductCategoryTbl.CategoryType, SuppliersTbl.Address1, SuppliersTbl.Address2, SuppliersTbl.PostalCode, SuppliersTbl.CityRegion, SuppliersTbl.SupplierID, ProductSuppliersTbl.CatalogueNo, ProductSuppliersTbl.PageNo, ProductSuppliersTbl.QuantityPerUnit, ProductSuppliersTbl.Measure, ProductSuppliersTbl.UnitsPerPack, ProductSuppliersTbl.PackPrice, PackPrice/UnitsPerPack AS PricePerUnit, ProductSuppliersTbl.ProductSupplierID 
	FROM ProductsTbl RIGHT JOIN ( ProductCategoryTbl INNER JOIN ( SuppliersTbl INNER JOIN ProductSuppliersTbl ON SuppliersTbl.SupplierID = ProductSuppliersTbl.SupplierID ) ON ProductCategoryTbl.ProductCategory =  SuppliersTbl.SupplierCategory ) ON ProductsTbl.ProductID = ProductSuppliersTbl.ProductID WHERE ProductSuppliersTbl.SupplierID=$SID");
}else{
   $sql =("SELECT ProductsTbl.ProductID, ProductsTbl.ProductName, SuppliersTbl.SupplierID, SuppliersTbl.Company, SuppliersTbl.CompanyName, ProductSuppliersTbl.CatalogueNo, ProductSuppliersTbl.QuantityPerUnit,  ProductCategoryTbl.CategoryType, SuppliersTbl.Address1, SuppliersTbl.Address2, SuppliersTbl.PostalCode, SuppliersTbl.CityRegion, SuppliersTbl.SupplierID, ProductSuppliersTbl.CatalogueNo, ProductSuppliersTbl.PageNo, ProductSuppliersTbl.QuantityPerUnit, ProductSuppliersTbl.Measure, ProductSuppliersTbl.UnitsPerPack, ProductSuppliersTbl.PackPrice, PackPrice/UnitsPerPack AS PricePerUnit, ProductSuppliersTbl.ProductSupplierID
   FROM ProductsTbl RIGHT JOIN ( ProductCategoryTbl INNER JOIN ( SuppliersTbl INNER JOIN ProductSuppliersTbl ON SuppliersTbl.SupplierID = ProductSuppliersTbl.SupplierID ) ON ProductCategoryTbl.ProductCategory =  SuppliersTbl.SupplierCategory ) ON ProductsTbl.ProductID = ProductSuppliersTbl.ProductID WHERE ProductSuppliersTbl.SupplierID=$SID ");

}
    $sql1 =("SELECT OrdersTbl.OrderID, OrdersTbl.SupplierID, DATE_FORMAT(OrdersTbl.DateStarted, '%Y/%m/%d') as ds, DATE_FORMAT(OrdersTbl.DatePlaced, '%Y/%m/%d') as dp, OrdersTbl.PlacedBy, OrdersTbl.DeliveryAddress, OrdersTbl.InvoiceNo, OrdersTbl.DeliveryNotes, OrdersTbl.StatusID, SuppliersTbl.Company, DeliveryAddressesTbl.Name AS DELIVNAME, StatusTbl.Status FROM ((SuppliersTbl INNER JOIN OrdersTbl ON SuppliersTbl.SupplierID = OrdersTbl.SupplierID) LEFT JOIN DeliveryAddressesTbl ON OrdersTbl.DeliveryAddress = DeliveryAddressesTbl.DeliveryAddressID) INNER JOIN StatusTbl ON OrdersTbl.StatusID = StatusTbl.StatusID WHERE OrdersTbl.OrderID=$order ");
  if (!$db->Query($sql1)) $db->Kill();
      $ord=$db->Row();

$user0=("select nazwa FROM hd_users where lp = '$id' LIMIT 1");
if (!$db->Query($user0)) $db->Kill();
$usern=$db->Row();
$username=$usern->nazwa;

	$q=$sql;
  if (!$db->Query($sql)) $db->Kill();
      $prd=$db->Row();
      echo "<form action='$PHP_SELF' method='POST' name='order0'>

      <tr><td class='DataTD' colspan='7' >$Cat of: <FONT SIZE=+2 COLOR=#FF0000>
	  <B>$prd->Company</B> - $prd->Address1, $prd->Address2, $prd->PostalCode $prd->CityRegion</FONT>
	  <input name='_SupplierID' type='hidden' value='$prd->SupplierID'>
		  
	  </td></tr>
	  <tr><td class='DataTD' colspan='7' >$RPNDATAOD: <FONT SIZE=+1 COLOR=#0033CC>
	  <B>$ord->ds</B> 
		  
		<input name='dateS' type='hidden' value='$teraz'>

	  </FONT> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$DA1: &nbsp;

	 <select class='Select' name='_DeliveryAddressID'>
		<option selected VALUE='$ord->DeliveryAddress'>$ord->DELIVNAME</option>";

		$adres = new CMySQL;
			$qadr = "SELECT  DeliveryAddressID, Name, Address1 FROM DeliveryAddressesTbl order by Name";

			if (!$adres->Open()) $adres->Kill();
			  if ($adres->Query($qadr)) 
				{
			   while ($row=$adres->Row())
				{
		         echo "<option value='$row->DeliveryAddressID'>$row->Name : $row->Address1</option>";
			    }
				} else {
					echo " 
					  <tr>
				    <td class='DataTD'></td>
				    <td class='DataTD' colspan='3'>SQL Error in addresses.</td>
					  </tr>";
					 $adres->Kill();
				}

echo " </select>

	  </td></tr>
	  <tr><td class='DataTD' colspan='7' >$Cat of: <FONT SIZE=+1 COLOR=#0033CC>
	  <B>$username->nazwa</B> </FONT>		  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  <TEXTAREA NAME='_DeliveryNotes' ROWS='2' COLS='40'>$ord->DeliveryNotes</TEXTAREA>
	  <input name='_PlacedBy' type='hidden' value='$username'></td>	  </tr>
		  	 ";

  if (!$db->Query($q)) $db->Kill();
  $licz=0;
  $ordered = new CMySQL;
    while ($row=$db->Row())
    {
		if (!$ordered->Open()) $ordered->Kill();
		$ile =("SELECT PacksOrdered FROM IndividualOrdersTbl WHERE OrderID=$order AND ProductSupplierID=$row->ProductSupplierID");
		if (!$ordered->Query($ile)) $ordered->Kill();
		$jest=$ordered->Row();

    echo "<tr>
        <td class='DataTD'><B>$licz</B></td>
		<input name='_prdSup[$licz]' type='hidden' value='$row->ProductSupplierID'>

		<td class='DataTD'><A HREF='prod1_ed.php?prod=$row->ProductID'><B>$row->ProductName</B></A></td>
        <td class='DataTD'>$row->QuantityPerUnit <input name='_qpu[$licz]' type='hidden' value='$row->QuantityPerUnit'></td>
        <td class='DataTD'>$row->PackPrice <input TYPE='hidden' name='_PP[$licz]' value='$row->PackPrice'><input TYPE='hidden' name='_PP$licz' value='$row->PackPrice'></td>
        <td class='DataTD'>".number_format($row->PricePerUnit,2,'.',' ')."</td>
        <td class='DataTD'><input class='Input' onChange=\"this.form._all$licz.value=this.value * this.form._PP$licz.value;\" maxlength='5' name='_qto[$licz]' size='5' value='$jest->PacksOrdered' ></td>
        <td class='DataTD'>$w <input class='Input' maxlength='5' name='_all$licz' size='5' value=''></td>
      </tr>";
     $licz++;			
   } // koniec pentli


echo "    <tr>
      <td align='right' colspan='7'>
			<input name='state' type='hidden' value='1'>
	        <input name='order' type='hidden' value='$order'>
		    <input name='licznik' type='hidden' value='$licz'>
			<input class='Button' name='Nowy' type='submit' value='$SAVEBTN'>
			<input class='Button'  type='Button' onclick='javascript:history.back()' value='$BACKBTN'>
	</td> 
    </tr>
</FORM>

</table>
</td></tr>
</table> 

</td></tr></table></form></center>
";
include_once("./footer.php");
}
elseif($state==1)
{

        if (!$db->Open())$db->Kill();
    $delitems =("DELETE FROM IndividualOrdersTbl WHERE OrderID='$order'");
    $result = mysql_query($delitems);
//echo $delitems."BR>";
	if (!$db->Open())$db->Kill();
    $query =("UPDATE OrdersTbl SET PlacedBy='$_PlacedBy', DeliveryAddress='$_DeliveryAddressID', DeliveryNotes='$_DeliveryNotes', StatusID=1 WHERE OrderID = '$order' LIMIT 1");
    $result = mysql_query($query);
	$oid=$order;
//echo $query."BR>";
  for ($i = 0; $i <= $licz+1; $i++) {
    if ($_qto[$i] > 0) {
	
    $query1[$i] =("INSERT INTO IndividualOrdersTbl (IndividualOrderID,OrderID, ProductSupplierID, CatalogueNo, QuantityPerUnit, Measure, UnitsPerPack, PacksOrdered, PacksDelivered ) VALUES (NULL, '$order', '$_prdSup[$i]', '$_PP[$i]', 0, 0, 0, '$_qto[$i]', 0)");
    $result1[$i] = mysql_query($query1[$i]);
//echo $query1[$i]."BR>";
	}

  }

  echo "<script language='javascript'>window.location=\"order1.php?order=$order\"</script>";
		 
}
?>