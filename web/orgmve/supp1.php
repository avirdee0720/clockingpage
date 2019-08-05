<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;

if(!isset($state))
{
	echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><TR BGCOLOR='$kolorTlaRamki'>
		</tr></table><table width='100%' border=0><tr><td>

<center>
<form action='$PHP_SELF' method='get' name='zl_new'>
  <font class='FormHeaderFont'>$ZLTYTZBY1T</font> 
<table WIDTH=700 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >";
	
$db = new CMySQL;
if (!$db->Open()) $db->Kill();
 if( $PU > 70 ){
 $q = "SELECT Company, CompanyName, SuppliersTbl.SupplierCategory, SuppliersTbl.SupplierCategory2, Address1, Address2, Address3, CityRegion, PostalCode, VATNo, ContactName, Phone1, Phone2, Fax, email, www, MethodOfPayment, AccountNo, DeliverySpeed, WhoAreTheyAndWhatDoTheyDo, SupplierID FROM SuppliersTbl INNER JOIN `SupplierCategoryTbl` On SuppliersTbl.SupplierCategory = `SupplierCategoryTbl`.SupplierCategory  WHERE SupplierID=$SID LIMIT 1 ";
  } else { 
  echo "<BR><BR><CENTER><H1>$UPRMALE</H1></CENTER><BR><BR>";
  exit;
 }
if (!$db->Query($q)) $db->Kill();
$row=$db->Row();

$rc = $row->SupplierCategory;
$supcattxt = "";

$q = "SELECT * FROM `SupplierCategoryTbl`";

     if (!$db->Open()) $db->Kill();
  if ($db->Query($q)) 
  {
    while ($r=$db->Row())
    {
		if ($rc == $r->SupplierCategory) 
			$supcattxt.= "<option value='$r->SupplierCategory' selected>$r->CategoryType</option>\n";
		else 
		      $supcattxt.= "<option value='$r->SupplierCategory'>$r->CategoryType</option>\n";
    }
	}

  if (!$db->Open()) $db->Kill();
  $popr = "SELECT hd_users.nazwa FROM hd_users WHERE hd_users.lp='$row->id_popr' LIMIT 1 ";
  if (!$db->Query($popr)) $db->Kill();
  $popr=$db->Row();

echo "	
    <tr>
      <td class='FieldCaptionTD'>$Company</td> 
      <td class='DataTD'><input class='Input' maxlength='50' name='_Company' size='30' value='$row->Company'>&nbsp;</td> 
    </tr>

    <tr>
      <td class='FieldCaptionTD'>$CompanyName</td> 
      <td class='DataTD'><input class='Input' maxlength='50' name='_CompanyName' size='50' value='$row->CompanyName'>&nbsp;</td> 
    </tr>
    <tr>
     <td class='FieldCaptionTD'>$SupplierCategory</td> 
     <td class='DataTD' colspan='3'> <select class='Select' name='_SupplierCategory'> 
     $supcattxt
      </select>
     </td>
    </td>
	<tr>
      <td class='FieldCaptionTD'>$Address1</td> 
      <td class='DataTD'><input class='Input' maxlength='50' name='_Address1' size='50' value='$row->Address1'>&nbsp;</td> 
    </tr>

	<tr>
      <td class='FieldCaptionTD'>$Address2</td> 
      <td class='DataTD'><input class='Input' maxlength='50' name='_Address2' size='50' value='$row->Address2'></td> 
    </tr>

	<tr>
      <td class='FieldCaptionTD'>$Address3</td> 
      <td class='DataTD'><input class='Input' maxlength='50' name='_Address3' size='50' value='$row->Address3'></td> 
    </tr>

		
	<tr>
      <td class='FieldCaptionTD'>$CityRegion</td> 
      <td class='DataTD'><input class='Input' maxlength='50' name='_CityRegion' size='50' value='$row->CityRegion'></td> 
    </tr>

	<tr>
      <td class='FieldCaptionTD'>$PostalCode</td> 
      <td class='DataTD'><input class='Input' maxlength='10' name='_PostalCode' size='10' value='$row->PostalCode'></td> 
    </tr>

	<tr>
      <td class='FieldCaptionTD'>$VAT</td> 
      <td class='DataTD'><input class='Input' maxlength='50' name='_VATNo' size='50' value='$row->VATNo'></td> 
    </tr>
			<tr>
      <td class='FieldCaptionTD'>$ContactName</td> 
      <td class='DataTD'><input class='Input' maxlength='50' name='_ContactName' size='50' value='$row->ContactName'></td> 
    </tr>
	<tr>
      <td class='FieldCaptionTD'>$Phone1</td> 
      <td class='DataTD'><input class='Input' maxlength='50' name='_Phone1' size='20' value='$row->Phone1'></td> 
    </tr>			<tr>
      <td class='FieldCaptionTD'>$Phone2</td> 
      <td class='DataTD'><input class='Input' maxlength='50' name='_Phone2' size='20' value='$row->Phone2'></td> 
    </tr>			<tr>
      <td class='FieldCaptionTD'>$Fax</td> 
      <td class='DataTD'><input class='Input' maxlength='50' name='_Fax' size='20' value='$row->Fax'></td> 
    </tr>			<tr>
      <td class='FieldCaptionTD'>$email</td> 
      <td class='DataTD'><input class='Input' maxlength='100' name='_email' size='40' value='$row->email'></td> 
    </tr>
				<tr>
      <td class='FieldCaptionTD'>$www</td> 
      <td class='DataTD'><input class='Input' maxlength='100' name='_www' size='50' value='$row->www'></td> 
    </tr><tr>
      <td class='FieldCaptionTD'>$MethodOfPayment</td> 
      <td class='DataTD'><input class='Input' maxlength='50' name='_MethodOfPayment' size='20' value='$row->MethodOfPayment'></td> 
    </tr><tr>
      <td class='FieldCaptionTD'>$AccountNo</td> 
      <td class='DataTD'><input class='Input' maxlength='50' name='_AccountNo' size='30' value='$row->AccountNo'></td> 
    </tr><tr>
      <td class='FieldCaptionTD'>$DeliverySpeed</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_DeliverySpeed' size='11' value='$row->DeliverySpeed'></td> 
    </tr><tr>
      <td class='FieldCaptionTD'>$WhoAreTheyAndWhatDoTheyDo</td> 
      <td class='DataTD'><input class='Input' maxlength='250' name='_WhoAreTheyAndWhatDoTheyDo' size='70' value='$row->WhoAreTheyAndWhatDoTheyDo'></td> 
    </tr>
 ";

echo "
    <tr>
      <td align='right' colspan='2'>
			<input name='state' type='hidden' value='1'>
			<input name='SID' type='hidden' value='$SID'>
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
if($SupplierCategory==0) $SupplierCategory=1;
     if (!$db->Open())$db->Kill();
     $query =("UPDATE SuppliersTbl SET Company='$_Company', CompanyName='$_CompanyName', SupplierCategory='$_SupplierCategory', SupplierCategory2='$_SupplierCategory2', Address1='$_Address1', Address2='$_Address2', Address3='$_Address3', CityRegion='$_CityRegion', PostalCode='$_PostalCode', VATNo='$_VATNo', ContactName='$_ContactName', Phone1='$_Phone1', Phone2='$_Phone2', Fax='$_Fax', email='$_email', www='$_www', MethodOfPayment='$_MethodOfPayment', AccountNo='$_AccountNo', DeliverySpeed='$_DeliverySpeed', WhoAreTheyAndWhatDoTheyDo='$_WhoAreTheyAndWhatDoTheyDo' WHERE SupplierID=$SID LIMIT 1");
     $result = mysql_query($query);

     echo "<script language='javascript'>window.location=\"supp1.php?SID=$SID\"</script>";

} 

?>