<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;

if (!isset($_GET['SID'])) $SID = '0'; else $SID = $_GET['SID'];

if (!isset($_POST['state'])) $state = 0; else $state = $_POST['state'];

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
	echo "	  <A HREF='prod1.php'><font class='FormHeaderFont'>$TYTNZL</font></A><BR><BR>
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
<td class='FieldCaptionTD'><B>$Quantity</B></td>
<td class='FieldCaptionTD'><B>$TotalPrice</B></td>
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
    $sql =("SELECT `ProductsTbl`.`ProductID`,
       `ProductsTbl`.`ProductName`,
       `ProductsTbl`.`Colour`,
       `SuppliersTbl`.`SupplierID`,
       `SuppliersTbl`.`Company`,
       `SuppliersTbl`.`CompanyName`,
       `ProductSuppliersTbl`.`CatalogueNo`,
       `ProductSuppliersTbl`.`QuantityPerUnit`,
       `ProductCategoryTbl`.`CategoryType`,
       `SuppliersTbl`.`Address1`,
       `SuppliersTbl`.`Address2`,
       `SuppliersTbl`.`PostalCode`,
       `SuppliersTbl`.`Phone1`,
       `SuppliersTbl`.`Fax`,
       `SuppliersTbl`.`CityRegion`,
       `SuppliersTbl`.`SupplierID`,
       `SuppliersTbl`.`WhoAreTheyAndWhatDoTheyDo`,
       `ProductSuppliersTbl`.`CatalogueNo`,
       `ProductSuppliersTbl`.`PageNo`,
       `ProductSuppliersTbl`.`QuantityPerUnit`,
       `ProductSuppliersTbl`.`Measure`,
       `ProductSuppliersTbl`.`UnitsPerPack`,
       `ProductSuppliersTbl`.`PackPrice`,
       `PackPrice` / `UnitsPerPack` AS PricePerUnit,
       `ProductSuppliersTbl`.`ProductSupplierID`
  FROM    `ProductsTbl`
       RIGHT JOIN
          (   `ProductCategoryTbl`
           INNER JOIN
              (   `SuppliersTbl`
               INNER JOIN
                  `ProductSuppliersTbl`
               ON `SuppliersTbl`.`SupplierID` =
                     `ProductSuppliersTbl`.`SupplierID`)
           ON `ProductCategoryTbl`.`ProductCategory` =
                 `SuppliersTbl`.`SupplierCategory`)
       ON `ProductsTbl`.`ProductID` = `ProductSuppliersTbl`.`ProductID`
 WHERE `ProductSuppliersTbl`.`SupplierID` = '$SID'");
}else{
   $sql =("SELECT ProductsTbl.ProductID, ProductsTbl.ProductName, ProductsTbl,Colour, SuppliersTbl.SupplierID, SuppliersTbl.Company, SuppliersTbl.CompanyName, ProductSuppliersTbl.CatalogueNo, ProductSuppliersTbl.QuantityPerUnit,  ProductCategoryTbl.CategoryType, SuppliersTbl.Address1, SuppliersTbl.Address2, SuppliersTbl.PostalCode, SuppliersTbl.CityRegion, SuppliersTbl.SupplierID, SuppliersTbl.Phone1, SuppliersTbl.Fax, SuppliersTbl.WhoAreTheyAndWhatDoTheyDo, ProductSuppliersTbl.CatalogueNo, ProductSuppliersTbl.PageNo, ProductSuppliersTbl.QuantityPerUnit, ProductSuppliersTbl.Measure, ProductSuppliersTbl.UnitsPerPack, ProductSuppliersTbl.PackPrice, PackPrice/UnitsPerPack AS PricePerUnit, ProductSuppliersTbl.ProductSupplierID
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
	  <B>$prd->Company</B> - $prd->Address1, $prd->Address2, $prd->PostalCode $prd->CityRegion, <B>tel: $prd->Phone1</B></FONT><input name='_SupplierID' type='hidden' value='$prd->SupplierID'></td></tr>
      <tr><td class='DataTD' colspan='7' ><FONT SIZE=+1 COLOR=#FF0000>
	  <I>$prd->WhoAreTheyAndWhatDoTheyDo</I></FONT></td></tr>
	  <tr><td class='DataTD' colspan='7' >$RPNDATAOD: <FONT SIZE=+1 COLOR=#0033CC>
	  <B>$teraz</B> 
		  
		<input name='dateS' type='hidden' value='$teraz'>

	  </FONT> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$DA1: &nbsp;

	 <select class='Select' name='_DeliveryAddressID'>
		<option selected VALUE='1'>chose one...</option>";

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
	  <B>$username->nazwa</B> </FONT>
		  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<TEXTAREA NAME='_DeliveryNotes' ROWS='2' COLS='40'>Delivery notes write here...</TEXTAREA>
		  <input name='_PlacedBy' type='hidden' value='$username->nazwa'></td>	  </tr>
		  	 ";

  if (!$db->Query($q)) $db->Kill();
  $licz=0;
    while ($row=$db->Row())
    {
    $colour = $row->Colour;
    if ($colour != "" && $colour !="N/A" && $colour!= "n/a" && $colour!="0" && $colour!="NULL" && $colour!= "NA" && $colour!= "na") $colour="($colour)";
    else $colour = "";
    
     
    echo "<tr>
        <td class='DataTD'><B>$licz</B></td>

			<input name='_prdSup[$licz]' type='hidden' value='$row->ProductSupplierID'>

		<td class='DataTD'><A HREF='prod1_ed.php?prod=$row->ProductID'><B>$row->ProductName $colour</B></A></td>
        <td class='DataTD'>$row->QuantityPerUnit <input name='_qpu[$licz]' type='hidden' value='$row->QuantityPerUnit'></td>
        <td class='DataTD'>$w$row->PackPrice <input TYPE='hidden' name='_PP[$licz]' value='$row->PackPrice'><input TYPE='hidden' name='_PP$licz' value='$row->PackPrice'></td>
        <td class='DataTD'>$w".number_format($row->PricePerUnit,2,'.',' ')."</td>
        <td class='DataTD'><input class='Input' onChange=\"this.form._all$licz.value=this.value * this.form._PP$licz.value;\" maxlength='5' name='_qto[$licz]' size='5' value='0' 
			></td>
        <td class='DataTD'>$w <input class='Input' maxlength='5' name='_all$licz' size='5' value=''></td>
      </tr>";
     $licz++;			
   } // koniec pentli


echo "    <tr>
      <td align='right' colspan='7'>
			<input name='state' type='hidden' value='1'>
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
    $query =("INSERT INTO OrdersTbl (OrderID, SupplierID, DateStarted, PlacedBy, DeliveryAddress, DeliveryNotes, StatusID )
							VALUES (NULL, '$_SupplierID', '$dateS', '$_PlacedBy', '$_DeliveryAddressID', '$_DeliveryNotes', 1 )");
    $result = mysql_query($query);
	$oid=mysql_insert_id();
//echo $query."<BR>";
//echo $oid."<BR>";

  for ($i = 0; $i <= $licz+1; $i++) {
    if ($_qto[$i] > 0) {
	echo "Po: ".$_qto[$i]."<BR><BR>";
	
    $query1[$i] =("INSERT INTO IndividualOrdersTbl (IndividualOrderID,OrderID, ProductSupplierID, CatalogueNo, QuantityPerUnit, Measure, UnitsPerPack, PacksOrdered, PacksDelivered )	VALUES (NULL, '$oid', '$_prdSup[$i]', '$_PP[$i]', 0, 0, 0, '$_qto[$i]', 0)");
	$result1[$i] = mysql_query($query1[$i]);
	$oid1[$i]=mysql_insert_id();
//echo $query1[$i]."<BR>";
//echo $oid1[$i]."<BR>";
	}

  }

echo "<script language='javascript'>window.location=\"order1.php?order=$oid\"</script>";

}
?>