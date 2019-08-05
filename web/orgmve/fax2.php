<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$order=$_GET['order'];

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
	<META HTTP-EQUIV="CONTENT-TYPE" CONTENT="text/html; charset=windows-1252">
	<TITLE>MVE Shops Ltd. - ORDER</TITLE>
	<STYLE>
	<!--
		@page { size: 21cm 29.7cm; margin-right: 0.69cm; margin-top: 0.6cm; margin-bottom: 1.16cm }
		P { margin-bottom: 0.21cm; text-align: left }
		P.western { font-size: 12pt; so-language: en-US }
		P.cjk { font-size: 12pt; so-language: en-US }
		P.ctl { font-size: 12pt }
	-->
	</STYLE>
</HEAD>
<BODY onload='print();' LANG="en-US" DIR="LTR" STYLE="border: none; padding: 0cm">
<?php



if (!$db->Open()) $db->Kill();

    $sql1 =("SELECT OrdersTbl.OrderID, OrdersTbl.SupplierID, DATE_FORMAT(OrdersTbl.DateStarted, '%d/%m/%Y') as ds, DATE_FORMAT(OrdersTbl.DatePlaced, '%d/%m/%Y') as dp, OrdersTbl.PlacedBy, OrdersTbl.DeliveryAddress, OrdersTbl.InvoiceNo, OrdersTbl.DeliveryNotes, OrdersTbl.StatusID, SuppliersTbl.CompanyName, SuppliersTbl.Address1, SuppliersTbl.Address2, SuppliersTbl.Address3, SuppliersTbl.CityRegion, SuppliersTbl.PostalCode, SuppliersTbl.Phone1, SuppliersTbl.Fax, SuppliersTbl.AccountNo, DeliveryAddressesTbl.Name, DeliveryAddressesTbl.Address1 AS ADD1, DeliveryAddressesTbl.Address2 AS ADD2, DeliveryAddressesTbl.PostalCode AS PC,  StatusTbl.Status FROM ((SuppliersTbl INNER JOIN OrdersTbl ON SuppliersTbl.SupplierID = OrdersTbl.SupplierID) LEFT JOIN DeliveryAddressesTbl ON OrdersTbl.DeliveryAddress = DeliveryAddressesTbl.DeliveryAddressID) INNER JOIN StatusTbl ON OrdersTbl.StatusID = StatusTbl.StatusID WHERE OrdersTbl.OrderID=$order ");


  if (!$db->Query($sql1)) $db->Kill();
      $prd=$db->Row();
	if (isset($prd->PlacedBy) && $prd->PlacedBy <> '') $orderedby=$prd->PlacedBy;

        $user0=("select nazwa FROM hd_users where lp = '$id' LIMIT 1"); 

        if (!$db->Query($user0)) $db->Kill();
           $usern=$db->Row();
           $username=$usern->nazwa;
?>

<CENTER>
<B><FONT FACE="Tahoma, sans-serif" SIZE=6 STYLE="font-size: 24pt">MUSIC AND GOODS EXCHANGE LIMITED</FONT></B><BR>
<FONT FACE="Tahoma, sans-serif" SIZE=2><B>28 PEMBRIDGE ROAD, NOTTING HILL GATE, LONDON W11 3HL, TEL. 020 7243 6688</B></FONT><BR>

<TABLE WIDTH=680 BORDER=0 BORDERCOLOR='#000000' CELLPADDING=2 CELLSPACING=0>
	<COL WIDTH=233>
	<COL WIDTH=150>
	<COL WIDTH=233>
	<TBODY>
<TR>
	<TD algin='right'><FONT FACE="Tahoma, sans-serif" SIZE=2><B><U>PURCHASE ORDER - goods</U></B></FONT></TD>
	<TD algin='center'>&nbsp;</TD>
	<TD algin='left'><FONT FACE="Tahoma, sans-serif" SIZE=2><B>PURCHASE ORDER NUMBER: <?php echo $order ?></B></FONT></TD>
</TR>
</TBODY>
</TABLE>
<BR>
<TABLE WIDTH=680 BORDER=1 BORDERCOLOR='#000000' CELLPADDING=2 CELLSPACING=0 RULES=GROUPS>
	<COL WIDTH=680>

	<TBODY>
<TR><TD algin='right' ><FONT FACE="Tahoma, sans-serif" SIZE=2><B>SUPPLIER: <?php echo $prd->CompanyName ?></B></FONT></TD></TR>
<TR><TD style='border-top: 1px solid #000000; border-left: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000; background-color: #FFFFFF; color: #000000; font-size: 12px;' algin='right'><FONT FACE="Tahoma, sans-serif" SIZE=2><B>ADDRESS: <?php echo "$prd->Address1, $prd->Address2, $prd->Address3, $prd->CityRegion, $prd->PostalCode" ?></B></FONT></TD></TR>
<TR><TD algin='right'><FONT FACE="Tahoma, sans-serif" SIZE=2><B>Fax	No: <?php echo $prd->Fax ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<LEFT>Telephone No: <?php echo $prd->Phone1 ?></LEFT></B></FONT></TD></TR>
</TBODY>
</TABLE>


<TABLE WIDTH=680 BORDER=0 BORDERCOLOR='#000000' CELLPADDING=5 CELLSPACING=2>
	<COL WIDTH=300>
	<COL WIDTH=400>
	<TBODY>
<TR>
	<TD algin='right'><FONT FACE="Tahoma, sans-serif" SIZE=2><B>
	Account No:    <?php echo $prd->AccountNo ?><BR>
	<FONT FACE="Tahoma, sans-serif" SIZE=6 STYLE="font-size: 18pt">INVOICE TO:</FONT><HR style='border: 2px solid #000000; '><BR>
	MUSIC AND GOODS EXCHANGE LTD,<BR>
	ENTERPRISE HOUSE,<BR>
	36A NOTTING HILL GATE,<BR>
	LONDON, W11 3HX
	
	</B></FONT></TD>
	<TD algin='left'><B>
	<FONT FACE="Tahoma, sans-serif" SIZE=6 STYLE="font-size: 18pt">Delivery AFTER 10:00AM to: </FONT><BR>
	<TABLE style='border-top: 2px solid #000000; border-left: 2px solid #000000; border-bottom: 2px solid #000000; border-right: 2px solid #000000; background-color: #FFFFFF; color: #000000; font-size: 12px;' WIDTH=350 BORDER=3 BORDERCOLOR='#000000' CELLPADDING=2 CELLSPACING=0 RULES=GROUPS>

	<TR>
	<TD><CENTER><FONT FACE="Tahoma, sans-serif" SIZE=4><B><?php echo "$prd->Name, <BR>$prd->ADD1, <BR>$prd->ADD2 $prd->PC" ?></B><BR><BR></FONT>
	</CENTER></TD>
	</TR>
	</TABLE>
	
</TD>
</TR>
</TBODY>
</TABLE>
<BR><B><FONT FACE="Tahoma, sans-serif" SIZE=2 STYLE="font-size: 12pt">PLEASE NOTE THAT DELIVERY ADDRESS MAY DIFFER FROM INVOICE ADDRESS</FONT></B><BR><HR style='border: 2px solid #000000; '>



 
<TABLE WIDTH=680 BORDER=1 BORDERCOLOR="#000000" CELLPADDING=7 CELLSPACING=0 RULES=GROUPS>
	<COL  WIDTH=480 >
	<COL  WIDTH=102>
	<COL  WIDTH=63>
	<TR  style='border-top: 1px solid #000000; border-left: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000; background-color: #FFFFFF; color: #000000; font-size: 12px;' VALIGN=TOP>
		<TD style='border-top: 1px solid #000000; border-left: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000; background-color: #FFFFFF; color: #000000; font-size: 12px;' WIDTH=480 style='border-left-style: solid, border-left: 1'><B><FONT FACE="Tahoma, sans-serif" SIZE=2><CENTER>PRODUCT DESCRIPTION</CENTER></FONT></B></TD>
		<TD style='border-top: 1px solid #000000; border-left: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000; background-color: #FFFFFF; color: #000000; font-size: 12px;' WIDTH=102><B><FONT FACE="Tahoma, sans-serif" SIZE=2><CENTER>CAT No</CENTER></FONT></B></TD>
		<TD style='border-top: 1px solid #000000; border-left: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000; background-color: #FFFFFF; color: #000000; font-size: 12px;' WIDTH=63><B><FONT FACE="Tahoma, sans-serif" SIZE=2><CENTER>QUANTITY</CENTER></FONT></B></TD>
	</TR>


<?php
$sql =("SELECT IndividualOrdersTbl.IndividualOrderID, IndividualOrdersTbl.OrderID, IndividualOrdersTbl.ProductSupplierID, ProductSuppliersTbl.CatalogueNo, IndividualOrdersTbl.QuantityPerUnit, IndividualOrdersTbl.Measure, IndividualOrdersTbl.UnitsPerPack, ProductSuppliersTbl.PackPrice AS PP, IndividualOrdersTbl.PacksOrdered, IndividualOrdersTbl.PacksDelivered, ProductsTbl.ProductName, ProductsTbl.Colour AS Expr1, ProductSuppliersTbl.PackPrice*IndividualOrdersTbl.PacksOrdered AS TotalPrice FROM ProductsTbl INNER JOIN (IndividualOrdersTbl INNER JOIN ProductSuppliersTbl ON IndividualOrdersTbl.ProductSupplierID = ProductSuppliersTbl.ProductSupplierID) ON ProductsTbl.ProductID = ProductSuppliersTbl.ProductID WHERE IndividualOrdersTbl.OrderID=$order");
if (!$db->Query($sql)) $db->Kill();

$wierszy=$db->Rows();
    while ($row=$db->Row())
    {
     if(isset($row->ProductName)) {$naz=$row->ProductName; } else { $naz="&nbsp;"; }
     if(isset($row->CatalogueNo)) {$col=$row->CatalogueNo; } else { $col="&nbsp;"; }
     //if(isset($row->Colour)) {$col=", ".$row->Colour; } else { $col="&nbsp;"; }
	 if(isset($row->PacksOrdered)) {$pp=$row->PacksOrdered; } else { $pp="&nbsp;"; }
	echo "<TR VALIGN=TOP>
		<TD WIDTH=480><B><FONT FACE='Tahoma, sans-serif' SIZE=2>$naz</FONT></B></TD>
		<TD WIDTH=102 style='border-left: 1px solid #000000; border-right: 1px solid #000000; background-color: #FFFFFF; color: #000000; font-size: 12px;'><B><FONT FACE='Tahoma, sans-serif' SIZE=2>$col</FONT></B></TD>
		<TD WIDTH=63><B><FONT FACE='Tahoma, sans-serif' SIZE=2>$pp</FONT></B></TD>
	</TR>";
	}

$lini=16;
$zostaje= $lini - $wierszy;

for ($i = 1; $i <= $zostaje; $i++) {
	echo "<TR VALIGN=TOP>
		<TD WIDTH=480>&nbsp;</TD>
		<TD WIDTH=102 style='border-left: 1px solid #000000; border-right: 1px solid #000000; background-color: #FFFFFF; color: #000000; font-size: 12px;'>&nbsp;</TD>
		<TD WIDTH=63>&nbsp;</TD>
	</TR>";
}

?>
</TABLE>

<BR>

<TABLE style='border-top: 1px solid #000000; border-left: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000; background-color: #FFFFFF; color: #000000; font-size: 12px;' WIDTH=680 BORDER=1 BORDERCOLOR='#000000' CELLPADDING=2 CELLSPACING=0 RULES=GROUPS>
	<COL WIDTH=680>

	<TBODY>
<TR><TD style='border-top: 1px solid #000000; border-left: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000; background-color: #FFFFFF; color: #000000; font-size: 12px;' algin='right'><FONT FACE="Tahoma, sans-serif" SIZE=2><B>

<TABLE  WIDTH=680 BORDER=0 BORDERCOLOR='#000000' CELLPADDING=2 CELLSPACING=0 RULES=GROUPS>

	<TR ><TD><B><FONT FACE="Tahoma, sans-serif" SIZE=2>
	ORDERED BY: <?php echo $orderedby ?></FONT></B></TD><TD algin='right'><B><FONT FACE="Tahoma, sans-serif" SIZE=2> 
	DATE: <?php echo $prd->ds ?></FONT></B></TD></TR>
	</TABLE>


</B></FONT></TD></TR>
<TR><TD algin='right'><FONT FACE="Tahoma, sans-serif" SIZE=2><B><FONT FACE="Tahoma, sans-serif" SIZE=2>AUTHORISED BY:</B></FONT></TD></TR>
</TBODY>
</TABLE>



<FONT SIZE=1 STYLE="font-size: 7pt">Incorporated with  limited liability in the state of Nevada, USA. reg no. C2852301. UK reg. off.
28 Pembridge Rd, London W11 3HL. UK reg. no. FC23764. Branch no. BR6476</FONT>
</CENTER>
<?php

if (!$db->Open()) $db->Kill();
    $query =("UPDATE OrdersTbl SET StatusID=2, PlacedBy='$username', DatePlaced='$teraz' WHERE OrderID =$order LIMIT 1");
if (!$db->Query($query)) $db->Kill();
//$db->Kill();
?>
</BODY>
</HTML>