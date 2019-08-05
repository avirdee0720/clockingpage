<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;

if (!isset($_POST['state'])) $state = 0; else $state = $_POST['state'];

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
	if( isset($_GET['SID']) and $_GET['SID'] <> "" )
	{
		$q1 = "SELECT `SupplierID` , `Company`, `CompanyName` FROM `SuppliersTbl` order by `CompanyName`";
		if (!$db->Open()) $db->Kill();
		if (!$db->Query($q1)) $db->Kill();
	    $row=$db->Row();
		$IDCOMP=$row->SupplierID;
		$namecomp="$row->CompanyName : $row->Company";
	}
	else 
	{
		$IDCOMP=85;
		$namecomp="Enter the company or Missing 2!";
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
        <td class='DataTD' colspan='3'><INPUT TYPE='INPUT' size='60' NAME='_Name' ></td>

   </tr>
<tr>
	    <td class='FieldCaptionTD'>$Colour</td>
        <td class='DataTD'><INPUT TYPE='INPUT' NAME='_Colour' VALUE='NA'></td>
		<td class='FieldCaptionTD'>$ToFit</td>
        <td class='DataTD'><INPUT TYPE='INPUT' NAME='_ToFit' VALUE='NA'></td>
  </tr>
  <tr>
	    <td class='FieldCaptionTD'>$CatNo</td>
        <td class='DataTD'><INPUT TYPE='INPUT' NAME='_CatalogueNo' VALUE='NA'>
        
        </td>
		<td class='FieldCaptionTD'>$PageNo</td>
        <td class='DataTD'><INPUT TYPE='INPUT' NAME='_PageNo' VALUE='1'></td>
  </tr>
  <tr>
		<td class='FieldCaptionTD'>$QPerUnit</td>
        <td class='DataTD'><INPUT TYPE='INPUT' NAME='_QPerUnit' VALUE='1'></td>
		<td class='FieldCaptionTD'>$Measure</td>
        <td class='DataTD'><INPUT TYPE='INPUT' NAME='_Measure' VALUE='NA'></td>
  </tr>
  <tr>				
	    <td class='FieldCaptionTD'>$UPerPack</td>
        <td class='DataTD'><INPUT TYPE='INPUT' NAME='_UPerPack' VALUE='1'></td>
		<td class='FieldCaptionTD'>$PPrice</td>
        <td class='DataTD'><INPUT TYPE='INPUT' NAME='_PPrice' ></td>


  </tr>
  </TD></tr>

</tr>
<tr>
		<td class='FieldCaptionTD'>$NOTEBTN</td>
        <td class='DataTD' colspan='3'><TEXTAREA NAME='_Notes' ROWS='3' COLS='50'>NA</TEXTAREA></td>
</tr>
<tr>
		<td class='FieldCaptionTD'>$Desc</td>
        <td class='DataTD' colspan='3'><TEXTAREA NAME='_Description' ROWS='3' COLS='50'>NA</TEXTAREA></td>
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
echo " </select>
</td>
</tr>

<tr>
        <td align='right' colspan='4'>
			<input  name='state' type='hidden' value='1'>
			<input  name='dataogl' type='hidden' value='$dzis'>
			<input class='Button' name='Nowy' type='submit' value='$SAVEBTN'>
			<input class='Button'  type='Button' onclick='javascript:history.back()' value='$BACKBTN'>
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
elseif($state==1)
{

if (!$db->Open())$db->Kill();
		$query1 =("INSERT INTO `ProductsTbl` (`ProductID`, `ProductName`, `Colour`, `Description`, `Notes`, `ToFit` ) VALUES(NULL, '$_Name', '$_Colour', '$_Description', '$_Notes', '$_ToFit' )");
		$result1 = mysql_query($query1);
		$iddr=mysql_insert_id();

if(isset($iddr)){
		$query2 =("INSERT INTO `ProductSuppliersTbl` (`ProductSupplierID`, `ProductID`, `SupplierID`, `CatalogueNo`, `PageNo`, `QuantityPerUnit`, `Measure`, `UnitsPerPack`, `PackPrice`, `Notes` ) VALUES(NULL, '$iddr', '$_suplayer', '$_CatalogueNo', '$_PageNo', '$_QPerUnit', '$_Measure', '$_UPerPack', '$_PPrice', '$_Notes')");
		$result1 = mysql_query($query2);

		echo "<script language='javascript'>window.location=\"prod1_ed.php?prod=$iddr\"</script>";
 } else { 
    echo "Transaction error!"; }

} 
?>