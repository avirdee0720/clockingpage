<?php
if(!isset($id) && !isset($pw) && $PU>70)
{header("Location: index.html");exit;}

include_once("./header.php");
include("./languages/$LANGUAGE.php");
include_once("./inc/mlfn.inc.php");
$nP="$PHP_SELF";
$numrows=15;

$db = new CMySQL;

 if (!$db->Open())$db->Kill();
$supcattxt = "<select class='Select' name='_SupplierCategory'>" ;

$q = "SELECT * FROM `SupplierCategoryTbl`";

  if ($db->Query($q)) 
  {
    while ($r=$db->Row())
    {
	
			$supcattxt.= "<option value='$r->SupplierCategory' >$r->CategoryType</option>\n";
	  }
	}
$supcattxt .= " </select>";

if(!isset($state))
{
	echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><TR BGCOLOR='$kolorTlaRamki'>
		</tr></table><table width='100%' border=0><tr><td>

<center>
<form action='$PHP_SELF' method='get' name='zl_new'>
  <font class='FormHeaderFont'>$ZLTYTZBY1T</font> 
<table WIDTH=700 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
    <tr>
      <td class='FieldCaptionTD'>$Company</td> 
      <td class='DataTD'><input class='Input' maxlength='50' name='_Company' size='30' value=''>&nbsp;</td> 
    </tr>

    <tr>
      <td class='FieldCaptionTD'>$CompanyName</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_CompanyName' size='11' value=''>&nbsp;(np. 0.2357)</td> 
    </tr>
    <tr>
     <td class='FieldCaptionTD'>$SupplierCategory</td> 
     <td class='DataTD' colspan='3'>$supcattxt</td>
    </td>
	<tr>
      <td class='FieldCaptionTD'>$Address1</td> 
      <td class='DataTD'><input class='Input' maxlength='50' name='_Address1' size='50' value=''>&nbsp;</td> 
    </tr>

	<tr>
      <td class='FieldCaptionTD'>$Address2</td> 
      <td class='DataTD'><input class='Input' maxlength='50' name='_Address2' size='50' value=''></td> 
    </tr>

	<tr>
      <td class='FieldCaptionTD'>$Address3</td> 
      <td class='DataTD'><input class='Input' maxlength='50' name='_Address3' size='50' value=''></td> 
    </tr>

		
	<tr>
      <td class='FieldCaptionTD'>$CityRegion</td> 
      <td class='DataTD'><input class='Input' maxlength='50' name='_CityRegion' size='50' value='London'></td> 
    </tr>

	<tr>
      <td class='FieldCaptionTD'>$PostalCode</td> 
      <td class='DataTD'><input class='Input' maxlength='10' name='_PostalCode' size='10' value=''></td> 
    </tr>

	<tr>
      <td class='FieldCaptionTD'>$VAT</td> 
      <td class='DataTD'><input class='Input' maxlength='50' name='_VATNo' size='50' value=''></td> 
    </tr>
			<tr>
      <td class='FieldCaptionTD'>$ContactName</td> 
      <td class='DataTD'><input class='Input' maxlength='50' name='_ContactName' size='50' value=''></td> 
    </tr>

			<tr>
      <td class='FieldCaptionTD'>$Phone1</td> 
      <td class='DataTD'><input class='Input' maxlength='50' name='_Phone1' size='20' value=''></td> 
    </tr>			<tr>
      <td class='FieldCaptionTD'>$Phone2</td> 
      <td class='DataTD'><input class='Input' maxlength='50' name='_Phone2' size='20' value=''></td> 
    </tr>			<tr>
      <td class='FieldCaptionTD'>$Fax</td> 
      <td class='DataTD'><input class='Input' maxlength='50' name='_Fax' size='20' value=''></td> 
    </tr>			<tr>
      <td class='FieldCaptionTD'>$email</td> 
      <td class='DataTD'><input class='Input' maxlength='100' name='_email' size='40' value=''></td> 
    </tr>
				<tr>
      <td class='FieldCaptionTD'>$www</td> 
      <td class='DataTD'><input class='Input' maxlength='100' name='_www' size='50' value=''></td> 
    </tr><tr>
      <td class='FieldCaptionTD'>$MethodOfPayment</td> 
      <td class='DataTD'><input class='Input' maxlength='50' name='_MethodOfPayment' size='20' value=''></td> 
    </tr><tr>
      <td class='FieldCaptionTD'>$AccountNo</td> 
      <td class='DataTD'><input class='Input' maxlength='50' name='_AccountNo' size='30' value=''></td> 
    </tr><tr>
      <td class='FieldCaptionTD'>$DeliverySpeed</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_DeliverySpeed' size='11' value=''></td> 
    </tr><tr>
      <td class='FieldCaptionTD'>$WhoAreTheyAndWhatDoTheyDo</td> 
      <td class='DataTD'>
				<TEXTAREA NAME='_WhoAreTheyAndWhatDoTheyDo' ROWS='3' COLS='50'></TEXTAREA>
			</td> 
    </tr>
    <tr>
      <td align='right' colspan='2'>
			<input name='state' type='hidden' value='1'>
			<input class='Button' name='Nowy' type='submit' value='$SAVEBTN'>
			<input class='Button' name='Cancel' type='Button' value='$EXITBTN'>
			<input class='Button'  type='Button' onclick='javascript:history.back()' value='$BACKBTN'>
	</td> 
    </tr>
 
  </table>
</form>

</center>
<BR>
</td></tr>
</table>";
include_once("./footer.php");
}
elseif($state==1)
{

     if (!$db->Open())$db->Kill();
	 $_SupplierCategory2=$_SupplierCategory;
     $query =("INSERT INTO SuppliersTbl (SupplierID, Company, CompanyName, SupplierCategory, SupplierCategory2, Address1, Address2, Address3, CityRegion, PostalCode, VATNo, ContactName, Phone1, Phone2, Fax, email, www, MethodOfPayment, AccountNo, DeliverySpeed, WhoAreTheyAndWhatDoTheyDo, Valid) VALUES (NULL, '$_Company', '$_CompanyName', '$_SupplierCategory', '$_SupplierCategory2', '$_Address1', '$_Address2', '$_Address3', '$_CityRegion', '$_PostalCode', '$_VATNo', '$_ContactName', '$_Phone1',  '$_Phone2', '$_Fax', '$_email', '$_www', '$_MethodOfPayment', '$_AccountNo', '$_DeliverySpeed', '$_WhoAreTheyAndWhatDoTheyDo','8' )");
     $result = mysql_query($query);
     if (!$db->Open())$db->Kill();
  	 $oid=mysql_insert_id();

//  if (!isset($_suplayer)) echo "<script language='javascript'>window.location=\"prod1.php\"</script>";

//	if (!$db->Open())$db->Kill();
		$query1 =("INSERT INTO ProductsTbl (ProductID, ProductName, Colour, Description, Notes, ToFit ) VALUES(NULL, 'Add_new!', '', '', '$_Company', '' )");
		$result1 = mysql_query($query1);
		$iddr=mysql_insert_id();

		$query2 =("INSERT INTO ProductSuppliersTbl (ProductSupplierID, ProductID, SupplierID, CatalogueNo, PageNo, QuantityPerUnit, Measure, UnitsPerPack, PackPrice, Notes ) VALUES(NULL, '$iddr', '$oid', '', '', '', '', '', '', '$_Company')");
		$result1 = mysql_query($query2);


     echo "<script language='javascript'>window.location=\"supp1.php?SID=$oid\"</script>";

} 

?>