<?php
//if(!isset($id) && !isset($pw))
//{header("Location: index.html"); exit;}
//$ASN = substr("$towar->ASNAZWA",0,10);

include_once("./header.php");
include("./languages/$LANGUAGE.php");
include_once("./inc/mlfn.inc.php");
$nP="$PHP_SELF";
$numrows=15;

if(!isset($state))
{
	echo "	  <font class='FormHeaderFont'>UPDATE PRICES</font><BR><BR>
<TD ALIGN=JUSTIFY VALIGN=TOP border=0>

<center>
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE' bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white'>
<tbody>
<tr>
<td class='FieldCaptionTD'><B>LP</B></td>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?SID=$SID&sort=1'><B>$PRODUCT</B></A></td>
<td class='FieldCaptionTD'><B>$QPerUnit</B></td>
<td class='FieldCaptionTD'><B>$PPrice</B></td>
<td class='FieldCaptionTD'><B>$PricePerUnit</B></td>
</tr>";

if(!isset($sort)) $sort=1;

	switch ($sort)
		{
		case 1:
		 $sortowanie=" ORDER BY ProductName ASC";
		 break;

		default:
		 $sortowanie=" ORDER BY ProductName DESC ";
		 break;
		}

if (!$db->Open()) $db->Kill();

if(!isset($nr_zam_o)){
    $sql =("SELECT ProductsTbl.ProductID, ProductsTbl.ProductName, SuppliersTbl.SupplierID, SuppliersTbl.Company, SuppliersTbl.CompanyName, ProductSuppliersTbl.CatalogueNo, ProductSuppliersTbl.QuantityPerUnit, ProductCategoryTbl.CategoryType, SuppliersTbl.Address1, SuppliersTbl.Address2, SuppliersTbl.PostalCode, SuppliersTbl.CityRegion, SuppliersTbl.SupplierID, SuppliersTbl.WhoAreTheyAndWhatDoTheyDo, ProductSuppliersTbl.CatalogueNo, ProductSuppliersTbl.PageNo, ProductSuppliersTbl.QuantityPerUnit, ProductSuppliersTbl.Measure, ProductSuppliersTbl.UnitsPerPack, ProductSuppliersTbl.PackPrice, PackPrice/UnitsPerPack AS PricePerUnit, ProductSuppliersTbl.ProductSupplierID 
	FROM ProductsTbl RIGHT JOIN ( ProductCategoryTbl INNER JOIN ( SuppliersTbl INNER JOIN ProductSuppliersTbl ON SuppliersTbl.SupplierID = ProductSuppliersTbl.SupplierID ) ON ProductCategoryTbl.ProductCategory =  SuppliersTbl.SupplierCategory ) ON ProductsTbl.ProductID = ProductSuppliersTbl.ProductID WHERE ProductSuppliersTbl.SupplierID=$SID");
}else{
   $sql =("SELECT ProductsTbl.ProductID, ProductsTbl.ProductName, SuppliersTbl.SupplierID, SuppliersTbl.Company, SuppliersTbl.CompanyName, ProductSuppliersTbl.CatalogueNo, ProductSuppliersTbl.QuantityPerUnit,  ProductCategoryTbl.CategoryType, SuppliersTbl.Address1, SuppliersTbl.Address2, SuppliersTbl.PostalCode, SuppliersTbl.CityRegion, SuppliersTbl.SupplierID, SuppliersTbl.WhoAreTheyAndWhatDoTheyDo, ProductSuppliersTbl.CatalogueNo, ProductSuppliersTbl.PageNo, ProductSuppliersTbl.QuantityPerUnit, ProductSuppliersTbl.Measure, ProductSuppliersTbl.UnitsPerPack, ProductSuppliersTbl.PackPrice, PackPrice/UnitsPerPack AS PricePerUnit, ProductSuppliersTbl.ProductSupplierID
   FROM ProductsTbl RIGHT JOIN ( ProductCategoryTbl INNER JOIN ( SuppliersTbl INNER JOIN ProductSuppliersTbl ON SuppliersTbl.SupplierID = ProductSuppliersTbl.SupplierID ) ON ProductCategoryTbl.ProductCategory =  SuppliersTbl.SupplierCategory ) ON ProductsTbl.ProductID = ProductSuppliersTbl.ProductID WHERE ProductSuppliersTbl.SupplierID=$SID ");

}

$user0=("select nazwa FROM hd_users where lp = '$id' LIMIT 1");
if (!$db->Query($user0)) $db->Kill();
$username=$db->Row();

	$q=$sql.$sortowanie;

  if (!$db->Query($q)) $db->Kill();
      $prd=$db->Row();
      echo "<form action='$PHP_SELF' method='post' name='order0'>

      <tr><td class='DataTD' colspan='7' >$Cat of: <FONT SIZE=+2 COLOR=#FF0000>
	  <B>$prd->Company</B> - $prd->Address1, $prd->Address2, $prd->PostalCode $prd->CityRegion</FONT><input name='_SupplierID' type='hidden' value='$prd->SupplierID'></td></tr>
 
	  <tr><td class='DataTD' colspan='7' ><FONT SIZE=+1 COLOR=#FF0000>
	  <I>$prd->WhoAreTheyAndWhatDoTheyDo</I></FONT></td></tr>

		  	 ";

  if (!$db->Query($q)) $db->Kill();
  $licz=0;
    while ($row=$db->Row())
    {
    
    echo "<tr>
        <td class='DataTD'><B>$licz</B></td>

			<input name='_prdSup[$licz]' type='hidden' value='$row->ProductSupplierID'>

		<td class='DataTD'><A HREF='prod1_ed.php?prod=$row->ProductID'><B>$row->ProductName</B></A></td>
        <td class='DataTD'><input name='_qpu[$licz]' type='input' onChange=\"this.form._PPU$licz.value=this.form._PP$licz.value / this.value;\" size='5' value='$row->QuantityPerUnit'></td>
        <td class='DataTD'>$w <input TYPE='input' name='_PP[$licz]' onChange=\"this.form._PPU$licz.value=this.value / this.form._qpu$licz.value;\" size='5' value='$row->PackPrice'></td>
        <td class='DataTD'>$w <input TYPE='input' name='_PPU[$licz]' size='5' onFocus=\"this.value=this.form._PPU$licz.value / this.form._qpu$licz.value;\" value='$row->PricePerUnit'></td>
      </tr>";
     $licz++;			
   } // koniec pentli


echo "    <tr>
      <td align='right' colspan='7'>
			<input name='state' type='hidden' value='1'><input name='licznik' type='hidden' value='$licz'>
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
/*
	if (!$db->Open())$db->Kill();
    $query =("INSERT INTO OrdersTbl (OrderID, SupplierID, DateStarted, PlacedBy, DeliveryAddress, DeliveryNotes, StatusID )
							VALUES (NULL, '$_SupplierID', '$dateS', '$_PlacedBy', '$_DeliveryAddressID', '$_DeliveryNotes', 1 )");
    $result = mysql_query($query);
	$oid=mysql_insert_id();
//echo $query."<BR>";
//echo $oid."<BR>";

  for ($i = 0; $i <= $licznik+1; $i++) {
    if ($_qto[$i] > 0) {
	echo "Po: ".$_qto[$i]."<BR><BR>";
	
    $query1[$i] =("INSERT INTO IndividualOrdersTbl (IndividualOrderID,OrderID, ProductSupplierID, CatalogueNo, 
							QuantityPerUnit, Measure, UnitsPerPack, PacksOrdered, PacksDelivered )
						VALUES (NULL, '$oid', '$_prdSup[$i]', '$_PP[$i]', 0, 0, 0, '$_qto[$i]', 0)");
	$result1[$i] = mysql_query($query1[$i]);
	$oid1[$i]=mysql_insert_id();
//echo $query1[$i]."<BR>";
//echo $oid1[$i]."<BR>";
	}

  }

echo "<script language='javascript'>window.location=\"order1.php?order=$oid\"</script>";
*/
}
?>