<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;

if (!isset($_GET['prod'])) $prod = '0'; else $prod = $_GET['prod'];
if (!isset($_POST['state'])) $state = 0; else $state = $_POST['state'];
if (!isset($_POST['Nowy'])) $Nowy = 0; else $Nowy = $_POST['Nowy'];
if (!isset($_POST['_ProductID'])) $_ProductID = 0; else $_ProductID = $_POST['_ProductID'];
if (!isset($_POST['_ProductSupplierID'])) $_ProductSupplierID = 0; else $_ProductSupplierID = $_POST['_ProductSupplierID'];

if (!isset($_POST['_Name'])) $_Name = 0; else $_Name = $_POST['_Name'];
if (!isset($_POST['_Colour'])) $_Colour = 0; else $_Colour = $_POST['_Colour'];
if (!isset($_POST['_Description'])) $_Description = 0; else $_Description = $_POST['_Description'];
if (!isset($_POST['_Notes'])) $_Notes = 0; else $_Notes = $_POST['_Notes'];
if (!isset($_POST['_ToFit'])) $_ToFit = 0; else $_ToFit = $_POST['_ToFit'];
if (!isset($_POST['_suplayer'])) $_suplayer = 0; else $_suplayer = $_POST['_suplayer'];
if (!isset($_POST['_CatalogueNo'])) $_CatalogueNo = 0; else $_CatalogueNo = $_POST['_CatalogueNo'];
if (!isset($_POST['_PageNo'])) $_PageNo = 0; else $_PageNo = $_POST['_PageNo'];
if (!isset($_POST['_QPerUnit'])) $_QPerUnit = 0; else $_QPerUnit = $_POST['_QPerUnit'];
if (!isset($_POST['_Measure'])) $_Measure = 0; else $_Measure = $_POST['_Measure'];
if (!isset($_POST['_UPerPack'])) $_UPerPack = 0; else $_UPerPack = $_POST['_UPerPack'];
if (!isset($_POST['_PPrice'])) $_PPrice = 0; else $_PPrice = $_POST['_PPrice'];
 

if($state==0)
{
 if (!$db->Open()) $db->Kill();

 if(isset($prod)){
  $q = "SELECT ProductsTbl.ProductID, ProductsTbl.ProductName, ProductsTbl.Colour, ProductsTbl.Description, ProductsTbl.Notes, ProductsTbl.ToFit, ProductSuppliersTbl.ProductSupplierID, ProductSuppliersTbl.CatalogueNo, ProductSuppliersTbl.PageNo, ProductSuppliersTbl.QuantityPerUnit, ProductSuppliersTbl.Measure, ProductSuppliersTbl.UnitsPerPack, ProductSuppliersTbl.PackPrice, ProductSuppliersTbl.Notes, SuppliersTbl.Company, ProductSuppliersTbl.SupplierID FROM (ProductsTbl INNER JOIN ProductSuppliersTbl ON ProductsTbl.ProductID = ProductSuppliersTbl.ProductID) INNER JOIN SuppliersTbl ON ProductSuppliersTbl.SupplierID = SuppliersTbl.SupplierID WHERE ProductsTbl.ProductID=$prod LIMIT 1";
  } else { 
  echo "<BR><BR><CENTER><H1>SQL Error</H1></CENTER><BR><BR>";
  exit;
 }

  if (!$db->Query($q)) $db->Kill();
  
    while ($row=$db->Row())
    {
echo "<center>
<form action='$PHP_SELF' method='POST' name='n_art'>
  <font class='FormHeaderFont'>$OBJEDIT $PRODUCT</font>
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
    <tbody>

<input  name='_ProductID' type='hidden' value='$row->ProductID'>
<input  name='_ProductSupplierID' type='hidden' value='$row->ProductSupplierID'>

  <table border='0' cellpadding='3' cellspacing='1'>

<tr><td  colspan='2'>
	<tr>
	    <td class='FieldCaptionTD'>$PRODUCT $DSNAZWA</td>
        <td class='DataTD' colspan='3'><INPUT TYPE='INPUT' size='60' NAME='_Name' VALUE='$row->ProductName'></td>

   </tr>
<tr>
	    <td class='FieldCaptionTD'>$Colour</td>
        <td class='DataTD'><INPUT TYPE='INPUT' NAME='_Colour' VALUE='$row->Colour'></td>
		<td class='FieldCaptionTD'>$ToFit</td>
        <td class='DataTD'><INPUT TYPE='INPUT' NAME='_ToFit' VALUE='$row->ToFit'></td>
  </tr>
  <tr>
	    <td class='FieldCaptionTD'>$CatNo</td>
        <td class='DataTD'><INPUT TYPE='INPUT' NAME='_CatalogueNo' VALUE='$row->CatalogueNo'></td>
		<td class='FieldCaptionTD'>$PageNo</td>
        <td class='DataTD'><INPUT TYPE='INPUT' NAME='_PageNo' VALUE='$row->PageNo'></td>
  </tr>
  <tr>
		<td class='FieldCaptionTD'>$QPerUnit</td>
        <td class='DataTD'><INPUT TYPE='INPUT' NAME='_QPerUnit' VALUE='$row->QuantityPerUnit'></td>
		<td class='FieldCaptionTD'>$Measure</td>
        <td class='DataTD'><INPUT TYPE='INPUT' NAME='_Measure' VALUE='$row->Measure'></td>
  </tr>
  <tr>				
	    <td class='FieldCaptionTD'>$UPerPack</td>
        <td class='DataTD'><INPUT TYPE='INPUT' NAME='_UPerPack' VALUE='$row->UnitsPerPack'></td>
		<td class='FieldCaptionTD'>$PPrice</td>
        <td class='DataTD'><INPUT TYPE='INPUT' NAME='_PPrice' VALUE='$row->PackPrice'></td>


  </tr>
  </TD></tr>

</tr>
<tr>
		<td class='FieldCaptionTD'>$NOTEBTN</td>
        <td class='DataTD' colspan='3'><TEXTAREA NAME='_Notes' ROWS='3' COLS='50'>$row->Notes</TEXTAREA></td>
</tr>
<tr>
		<td class='FieldCaptionTD'>$Desc</td>
        <td class='DataTD' colspan='3'><TEXTAREA NAME='_Description' ROWS='3' COLS='50'>$row->Description</TEXTAREA></td>
</tr>
<tr>
      <td class='FieldCaptionTD' >$suplayer</td>
      <td class='DataTD' colspan='3'>   <select class='Select' name='_suplayer'>
		<option selected VALUE='$row->SupplierID'>$row->Company</option>";
		  $q = "SELECT SupplierID , Company, CompanyName FROM SuppliersTbl order by CompanyName";

     if (!$db->Open()) $db->Kill();
  if ($db->Query($q)) 
  {
    while ($row=$db->Row())
    {

          echo "<option value='$row->SupplierID'>$row->CompanyName : $row->Company</option>";
    }
	} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='3'>SQL Error in depat.</td>
  </tr>";
 $db->Kill();
}

	} // while
echo " </select>
</td>
</tr>

<tr>
        <td align='right' colspan='4'>
			<input  name='state' type='hidden' value='1'>
	
			<input  name='dataogl' type='hidden' value='$dzis'>
			<input class='Button' name='Nowy' type='submit' value='$SAVEBTN'>
			<input class='Button'  type='Button' onclick='javascript:windoww.open('prod2.php?SID=$row->SupplierID')' value='$LISTBTN'></td>
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
elseif($state==1)
{
include("./languages/$LANGUAGE.php");

if(isset($Nowy) and $Nowy==strval("$SAVEBTN"))
    {  

  if (!isset($_suplayer)) echo "<script language='javascript'>window.location=\"prod1.php\"</script>";

	if (!$db->Open())$db->Kill();
		$query1 =("UPDATE `ProductsTbl` SET  `ProductName`='$_Name', `Colour`='$_Colour', `Description`='$_Description', `Notes`='$_Notes', `ToFit`='$_ToFit' WHERE `ProductID`='$_ProductID' LIMIT 1 ");
		$result1 = mysql_query($query1);
	if(isset($result1)){
		$query2 =("UPDATE `ProductSuppliersTbl` SET `SupplierID`='$_suplayer', `CatalogueNo`='$_CatalogueNo', `PageNo`='$_PageNo', `QuantityPerUnit`='$_QPerUnit', `Measure`='$_Measure', `UnitsPerPack`='$_UPerPack', `PackPrice`='$_PPrice', `Notes`='$_Notes' WHERE `ProductSupplierID`='$_ProductSupplierID' LIMIT 1");
		$result1 = mysql_query($query2);

		echo "<script language='javascript'>window.location=\"prod1_ed.php?prod=$_ProductID\"</script>";
	} else { 
		echo "Transaction error!"; }
	}
} 
?>