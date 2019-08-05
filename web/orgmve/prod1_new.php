<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;

$_Name = $_POST['_Name'];
$_Description = $_POST['_Description'];
$_Notes = $_POST['_Notes'];
$_ToFit = $_POST['_ToFit'];
$_suplayer = $_POST['_suplayer'];
$_CatalogueNo = $_POST['_CatalogueNo'];
$_PageNo = $_POST['_PageNo'];
$_QPerUnit = $_POST['_QPerUnit'];
$_Measure = $_POST['_Measure'];
$_UPerPack = $_POST['_UPerPack'];
$_PPrice = $_POST['_PPrice'];

$_save= $_POST['save'];
$_delete = $_POST['delete'];
$_search = $_POST['Cataloguebutton'];

$_productid = $_GET['productid'];

$nametype = "0";

if (isset( $_productid )) {

$nametype = "1";

$q1 = "		SELECT *
FROM `ProductsTbl`
INNER JOIN `ProductSuppliersTbl` ON `ProductsTbl`.`ProductID` = `ProductSuppliersTbl`.`ProductID`
Where `ProductsTbl`.`ProductID` = '$_productid' AND `ProductsTbl`.Valid = '8' ";



 if (!$db->Open()) $db->Kill();
		if (!$db->Query($q1)) $db->Kill();
	   $rows=$db->Rows();
	   $row=$db->Row();
	   	
$_Name =$row->ProductName;
$_Description =$row->Description; 	
$_Notes =$row->Notes;
$_ToFit =$row->ToFit;
$_suplayer =$row->suplayer;
$_CatalogueNo =$row->CatalogueNo;
$_PageNo =$row->PageNo;
$_QPerUnit =$row->QuantityPerUnite;
$_Measure =$row->Measure;
$_UPerPack =$row->UnitsPerPack;
$_PPrice=$row->PackPrice;
$_SupplierID=$row->SupplierID;

}



if(!isset($_save) && !isset($_delete))
{

$catalogfilter = "";
$catalogfiltercode = "<INPUT TYPE='INPUT' size='60' NAME='_Name' value='$_Name'>";

		if (isset($_search) && isset($_CatalogueNo) ) {

	$catalogfilter = "AND `CatalogueNo` LIKE '%$_CatalogueNo%'";		

// $q1 = "SELECT `ProductID` , `ProductName` FROM `ProductsTbl` INNER JOIN  `ProductSuppliersTbl` ON `ProductsTbl`.`ProductID`= `ProductSuppliersTbl`.`ProductID` 	$catalogfilter order by `CompanyName`";
$q1 = "		SELECT `ProductsTbl`.`ProductID` , `ProductName`,  `Colour`
FROM `ProductsTbl`
INNER JOIN `ProductSuppliersTbl` ON `ProductsTbl`.`ProductID` = `ProductSuppliersTbl`.`ProductID`
Where `CatalogueNo` LIKE '%$_CatalogueNo%' AND `ProductsTbl`.Valid = '8'
ORDER BY `ProductName`";

    
    if (!$db->Open()) $db->Kill();
		if (!$db->Query($q1)) $db->Kill();
	   $rows=$db->Rows();
	   if ($rows > 0) {
	   
	   $catalogfiltercode = "<select class='Select' name='_Name'>";
	   
		while ($row=$db->Row())
    {
  if ($row->CatalogueNo == $_CatalogueNo ) {
            $catalogfiltercode .= "<option value='$PHP_SELF?productid=$row->ProductID' selected>$row->ProductName - Colur($row->Colour) </option>\n";
    }
    else {
    $catalogfiltercode .= "<option value='$PHP_SELF?productid=$row->ProductID'>$row->ProductName - Colur($row->Colour) </option>\n";
    }

    }
    $catalogfiltercode .= "</select>
    <input type=\"button\" value='Go' onClick=\"jumpBox(this.form.elements[0]);\">
    
    ";
  }

}		

	if( isset($_GET['SID']) and $_GET['SID'] <> "" )
	{
		$q1 = "SELECT `SupplierID` , `Company`, `CompanyName` FROM `SuppliersTbl` INNER JOIN  `ProductSuppliersTbl` ON `SuppliersTbl`.`SupplierID`= `ProductSuppliersTbl`.`SupplierID` 	Where `SuppliersTbl`.`Valid`='8' order by `CompanyName`";
		if (!$db->Open()) $db->Kill();
		if (!$db->Query($q1)) $db->Kill();
	    $row=$db->Row();
		$IDCOMP=$row->SupplierID;
		$namecomp="$row->CompanyName : $row->Company";
	}
	else 
	{
		$IDCOMP=85;
		$namecomp="Enter the company!";
	}
echo "<center>
<form action='$PHP_SELF' method='POST' name='n_art'>
  <font class='FormHeaderFont'>$OBJADD $PRODUCT</font>
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
    <tbody>
  <table border='0' cellpadding='3' cellspacing='1'>

<tr><td  colspan='2'>
	<tr>
	    <td class='FieldCaptionTD'>$PRODUCT $DSNAZWA</td>
        <td class='DataTD' colspan='3'>$catalogfiltercode</td>

   </tr>
<tr>
	    <td class='FieldCaptionTD'>$Colour</td>
        <td class='DataTD'><INPUT TYPE='INPUT' NAME='_Colour' VALUE='$_Colour'></td>
		<td class='FieldCaptionTD'>$ToFit</td>
        <td class='DataTD'><INPUT TYPE='INPUT' NAME='_ToFit' VALUE='$_ToFit'></td>
  </tr>
  <tr>
	    <td class='FieldCaptionTD'>$CatNo</td>
        <td class='DataTD'><INPUT TYPE='INPUT' NAME='_CatalogueNo' VALUE='$_CatalogueNo''>
        <INPUT TYPE='submit' NAME='Cataloguebutton' VALUE='Search'>
        </td>
		<td class='FieldCaptionTD'>$PageNo</td>
        <td class='DataTD'><INPUT TYPE='INPUT' NAME='_PageNo' VALUE='$_PageNo'></td>
  </tr>
  <tr>
		<td class='FieldCaptionTD'>$QPerUnit</td>
        <td class='DataTD'><INPUT TYPE='INPUT' NAME='_QPerUnit' VALUE='$_QPerUnit'></td>
		<td class='FieldCaptionTD'>$Measure</td>
        <td class='DataTD'><INPUT TYPE='INPUT' NAME='_Measure' VALUE='$_Measure'></td>
  </tr>
  <tr>				
	    <td class='FieldCaptionTD'>$UPerPack</td>
        <td class='DataTD'><INPUT TYPE='INPUT' NAME='_UPerPack' VALUE='$_UPerPack'></td>
		<td class='FieldCaptionTD'>$PPrice</td>
        <td class='DataTD'><INPUT TYPE='INPUT' NAME='_PPrice' VALUE = '$_PPrice'></td>


  </tr>
  </TD></tr>

</tr>
<tr>
		<td class='FieldCaptionTD'>$NOTEBTN</td>
        <td class='DataTD' colspan='3'><TEXTAREA NAME='_Notes' ROWS='3' COLS='50'>$_Notes</TEXTAREA></td>
</tr>
<tr>
		<td class='FieldCaptionTD'>$Desc</td>
        <td class='DataTD' colspan='3'><TEXTAREA NAME='_Description' ROWS='3' COLS='50'>$_Descripton</TEXTAREA></td>
</tr>
<tr>
      <td class='FieldCaptionTD' >$suplayer</td>
      <td class='DataTD' colspan='3'>   <select class='Select' name='_suplayer'>
		<option selected value='$IDCOMP'>$namecomp</option>";
		
		  $q = "SELECT `SupplierID` , `Company`, `CompanyName` FROM `SuppliersTbl` order by `CompanyName`";

     if (!$db->Open()) $db->Kill();
  if ($db->Query($q)) 
  {
    while ($row=$db->Row())
    {
if ($row->SupplierID == $_SupplierID) {
           echo "<option value='$row->SupplierID' selected>$row->CompanyName : $row->Company</option>";
    }
    else {
   echo "<option value='$row->SupplierID'>$row->CompanyName : $row->Company</option>";
    }
          
    }
	} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='3'>SQL Error in depat.</td>
  </tr>";
 $db->Kill();
}
echo " </select>
</td>
</tr>

<tr>
        <td align='right' colspan='4'>
			<input  name='state' type='hidden' value='1'>
			<input  name='dataogl' type='hidden' value='$dzis'>
			<input  name='nametype' type='hidden' value='$nametype'>
			<input class='Button' name='Nowy' type='submit' value='$SAVEBTN'>
			<input name='save' class='Button'  type='Button' onclick='javascript:history.back()' value='$BACKBTN'>
			<input class='Button' TYPE='submit'  value='Delete' name='delete'>
			</td>
      </tr>
    </form>
  </tbody>
</table>
</center>
<BR>
</td></tr>
</table>";
include_once("./footer.php");
}

elseif(isset($_save))
{

checkZm("_Name");
checkZm("_Colour");
checkZm("_Description");
checkZm("_Notes");
checkZm("_ToFit");
checkZm("_suplayer");
checkZm("_CatalogueNo");
checkZm("_PageNo");
checkZm("_QPerUnit");
checkZm("_Measure");
checkZm("_UPerPack");
checkZm("_PPrice");

if ($nametype == "0") {
echo "SSS ";
if (!$db->Open())$db->Kill();
		$query1 ="INSERT INTO `ProductsTbl` (`ProductID`, `ProductName`, `Colour`, `Description`, `Notes`, `ToFit`,`Valid` ) VALUES(NULL, '$_Name', '$_Colour', '$_Description', '$_Notes', '$_ToFit', '8' )";
		$result1 = mysql_query($query1);
		$iddr=mysql_insert_id();

if(isset($iddr)){
		$query2 ="INSERT INTO `ProductSuppliersTbl` (`ProductSupplierID`, `ProductID`, `SupplierID`, `CatalogueNo`, `PageNo`, `QuantityPerUnit`, `Measure`, `UnitsPerPack`, `PackPrice`, `Notes`,`Valid`  ) VALUES(NULL, '$iddr', '$_suplayer', '$_CatalogueNo', '$_PageNo', '$_QPerUnit', '$_Measure', '$_UPerPack', '$_PPrice', '$_Notes', '8')";
		$result1 = mysql_query($query2);

		echo "<script language='javascript'>window.location=\"prod1_ed.php?prod=$iddr\"</script>";
 } else { 
    echo "Transaction error!"; }
}

else echo "You should add a new product!  Not choose one!";
}

elseif(isset($_delete))
{

 
if ($nametype == "1") {

$query1 = "select * form `ProductsTbl` Where `ProductID` ='$_productid'" ;

if (!$db->Open()) $db->Kill();
		if (!$db->Query($q1)) $db->Kill();
	   $rows=$db->Rows();
	   if ($rows == 1) {
$query1 = "UPDATE `ProductsTbl` SET `Valid` = '9',
`cur_timestamp` = NOW( ) WHERE `ProductID` ='$_productid'  LIMIT 1" ;}
elseif ($rows == 0) echo "There is no product.";
elseif ($rows > 1) echo " There are too much product.";

}


else {

$query1 = "select * form `ProductsTbl` Where `ProductName` ='$_Name'" ;

if (!$db->Open()) $db->Kill();
		if (!$db->Query($q1)) $db->Kill();
	   $rows=$db->Rows();
	   if ($rows == 1) {
$query1 = "UPDATE `ProductsTbl` SET `Valid` = '9',
`cur_timestamp` = NOW( ) WHERE `ProductName` ='$_Name' LIMIT 1";}
elseif ($rows == 0) echo "There is no product.";
elseif ($rows > 1) echo " There are too much product.";

}



//	$result1 = mysql_query($query1);
//	$iddr=mysql_insert_id();


}



?>