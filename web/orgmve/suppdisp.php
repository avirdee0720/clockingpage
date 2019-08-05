<?php

function DispSupp($SID) {
include("./config.php");
include_once("./header.php");

$result = "<center><font class='FormHeaderFont'>$ZLTYTZBY1T</font><table WIDTH=700 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >";


$dbCon = new CMySQL;
if (!$dbCon->Open()) $dbCon->Kill();
 if( $PU > 70 ){
 $q = "SELECT Company, CompanyName, SupplierCategory, SupplierCategory2, Address1, Address2, Address3, CityRegion, PostalCode, VATNo, ContactName, Phone1, Phone2, Fax, email, www, MethodOfPayment, AccountNo, DeliverySpeed, WhoAreTheyAndWhatDoTheyDo, SupplierID FROM SuppliersTbl WHERE SupplierID=$SID LIMIT 1 ";
  } else { 
  echo "<BR><BR><CENTER><H1>$UPRMALE</H1></CENTER><BR><BR>";
  exit;
 }
if (!$dbCon->Query($q)) $dbCon->Kill();
$row=$dbCon->Row();

  if (!$dbCon->Open()) $dbCon->Kill();
  $popr = "SELECT hd_users.nazwa FROM hd_users WHERE hd_users.lp='$row->id_popr' LIMIT 1 ";
  if (!$dbCon->Query($popr)) $dbCon->Kill();
  $popr=$dbCon->Row();

 $result = $result ."
 ?>   <tr>
      <td class='FieldCaptionTD'><?php echo $Company ?></td> 
      <td class='DataTD'><?php echo $row->Company ?>&nbsp;</td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'><?php echo $CompanyName ?></td> 
      <td class='DataTD'><?php echo $row->CompanyName ?>&nbsp;</td> 
    </tr>
    <tr>
     <td class='FieldCaptionTD'><?php echo $SupplierCategory ?></td> 
     <td class='DataTD' colspan='3'><?php echo $row->SupplierCategory ?>COMBO!!&nbsp;</td>
    </td>
	<tr>
      <td class='FieldCaptionTD'><?php echo $Address1 ?></td> 
      <td class='DataTD'><?php echo $row->Address1 ?>&nbsp;</td> 
    </tr>
	<tr>
      <td class='FieldCaptionTD'><?php echo $Address2 ?></td> 
      <td class='DataTD'><?php echo $row->Address2 ?></td> 
    </tr>

	<tr>
      <td class='FieldCaptionTD'><?php echo $Address3 ?></td> 
      <td class='DataTD'><?php echo $row->Address3 ?></td> 
    </tr>
	<tr>
      <td class='FieldCaptionTD'><?php echo $CityRegion ?></td> 
      <td class='DataTD'><?php echo $row->CityRegion ?></td> 
    </tr>
	<tr>
      <td class='FieldCaptionTD'><?php echo $PostalCode ?></td> 
      <td class='DataTD'><?php echo $row->PostalCode ?></td> 
    </tr>
	<tr>
      <td class='FieldCaptionTD'><?php echo $VAT ?></td> 
      <td class='DataTD'><?php echo $row->VATNo ?></td> 
    </tr>
			<tr>
      <td class='FieldCaptionTD'><?php echo $ContactName ?></td> 
      <td class='DataTD'><?php echo $row->ContactName ?></td> 
    </tr>
	<tr>
      <td class='FieldCaptionTD'><?php echo $Phone1 ?></td> 
      <td class='DataTD'><?php echo $row->Phone1 ?></td> 
    </tr>			<tr>
      <td class='FieldCaptionTD'><?php echo $Phone2 ?></td> 
      <td class='DataTD'><?php echo $row->Phone2 ?></td> 
    </tr>			<tr>
      <td class='FieldCaptionTD'><?php echo $Fax ?></td> 
      <td class='DataTD'><?php echo $row->Fax ?></td> 
    </tr>			<tr>
      <td class='FieldCaptionTD'><?php echo $email ?></td> 
      <td class='DataTD'><?php echo $row->email ?></td> 
    </tr>
				<tr>
      <td class='FieldCaptionTD'><?php echo $www ?></td> 
      <td class='DataTD'><?php echo $row->www ?></td> 
    </tr><tr>
      <td class='FieldCaptionTD'><?php echo $MethodOfPayment ?></td> 
      <td class='DataTD'><?php echo $row->MethodOfPayment ?></td> 
    </tr><tr>
      <td class='FieldCaptionTD'><?php echo $AccountNo ?></td> 
      <td class='DataTD'><?php echo $row->AccountNo ?></td> 
    </tr><tr>
      <td class='FieldCaptionTD'><?php echo $DeliverySpeed ?></td> 
      <td class='DataTD'><?php echo $row->DeliverySpeed ?></td> 
    </tr><tr>
      <td class='FieldCaptionTD'><?php echo $WhoAreTheyAndWhatDoTheyDo ?></td> 
      <td class='DataTD'><?php echo $row->WhoAreTheyAndWhatDoTheyDo ?></td> 
    </tr>
 
  </table>
<?php
"."end12";
  return  $result;
  
 }



?>
