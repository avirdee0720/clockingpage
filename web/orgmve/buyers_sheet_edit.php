<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];

$db = new CMySQL;
$db2 = new CMySQL;

if (!$db->Open()) $db->Kill();
if (!$db2->Open()) $db->Kill();
 
$tytul="Buyer's sheet";
$dataakt=date("d/m/Y");
$dataakt2=date("d/m/Y H:i:s");
$date1= date("Y-m-d");

$ipx=$_SERVER['REMOTE_ADDR'];


$bno=$_GET['bno'];
$todo=$_GET['todo'];

if (!isset($bs) && isset($_GET['bs'])) $bs=$_GET['bs'];  

if ($bs == "") $bs="new";

if(!isset($state))
{

     
if ($bs!="new") {
 
$q = "SELECT * FROM `buyers_sheet` INNER JOIN `seller` ON  `buyers_sheet`.`sellerdbid`=`seller`.`sellerdbid` WHERE `buyers_sheet`.`id`='$bs'
Limit 1";

  if ($db2->Query($q)) 
  {
     $row2=$db2->Row();
  }
  
}
if ($todo == "1" || $bs=="new" ) {

$namehtml = "";
 $q = "SELECT `nombers`.`knownas`, `nombers`.`firstname`, `nombers`.`surname`, `nombers`.`pno` FROM `nombers` LEFT JOIN `inout` ON `inout`.`no`=`nombers`.`pno` WHERE `nombers`.`status`=\"OK\" AND inout.date1='$date1' GROUP BY `nombers`.`pno` ORDER BY `nombers`.`pno` ASC";

//	$db = new CMySQL;
     if (!$db->Open()) $db->Kill();
  if ($db->Query($q)) 
  {
    while ($r=$db->Row())
    {
          if ($row2->no == $r->pno)  $selected = 'selected=\"selected\"'; else $selected="";
          
          $namehtml.= "<option value='$r->pno' $selected>$r->pno: $r->firstname $r->surname</option>\n";
    }
	} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='3'>SQL Error 1a</td>
  </tr>";
 $db->Kill();
}


$shoplisthtml = "";

  $q = "SELECT shopid,name, address1, address2 FROM `shoplist` ORDER BY `name`, address1, address2 ASC";

//	$db = new CMySQL;
     if (!$db->Open()) $db->Kill();
  if ($db->Query($q)) 
  {
    while ($r=$db->Row())
    {
          $shopname = $r->name;
          if ($r->address1 != "") $shopname.= " - ".$r->address1;
          if ($r->address2 != "") $shopname.= " /".$r->address2."/";
          if ($row2->shopid == $r->shopid)  $selected = 'selected=\"selected\"'; else $selected="";
          $shoplisthtml.= "<option value='$r->shopid' $selected>$shopname</option>\n";
    }
	} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='3'>SQL Error 1a</td>
  </tr>";
 $db->Kill();
}


$producthtml = "";

  $q = "SELECT ptypeid,name FROM `product_type` ORDER BY `name`";

//	$db = new CMySQL;
     if (!$db->Open()) $db->Kill();
  if ($db->Query($q)) 
  {
    while ($r=$db->Row())
    {
          if ($row2->type == $r->ptypeid)  $selected = 'selected=\"selected\"'; else $selected="";
          $producthtml.= "<option value='$r->ptypeid' $selected >$r->name</option>\n";
    }
	} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='3'>SQL Error 1a</td>
  </tr>";
 $db->Kill();
}

echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>

<center>
<form action='$PHP_SELF' method='post' name='ed_czl'>
  <font class='FormHeaderFont'>$tytul</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
  
  <tr>
      <td class='FieldCaptionTD'>Buyer</td>

<td class='DataTD'>   <select class='Select' name='_no'>
      $namehtml
    </select>
</td></tr>

    <tr>
      <td class='FieldCaptionTD'>Date</td>
      <td class='DataTD'>$dataakt</td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>Shop</td>
      <td class='DataTD'><select class='Select' name='_shopid'>
      $shoplisthtml 
      </select></td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>Product Type</td>
      <td class='DataTD'><select class='Select' name='_type'>
      $producthtml
      </select></td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>Title</td>
      <td class='DataTD'><input class='Input' maxlength='250' name='_title' value='$row2->title' size='30'></td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>Descripton of Goods</td>
      <td class='DataTD'><input class='Input' maxlength='250' name='_description' value='$row2->description' size='30'></td>
    </tr>
     <tr>  
      <td class='FieldCaptionTD'>Seller</td>
      <td class='DataTD'><input class='Input' maxlength='250' name='_seller' value='$row2->name' size='30'></td>
    </tr>
     <tr>  
      <td class='FieldCaptionTD'>Seller's address1</td>
      <td class='DataTD'><input class='Input' maxlength='12' name='_seller_address1' value='$row2->address1'></td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>Seller's address2</td>
      <td class='DataTD'><input class='Input' maxlength='12' name='_seller_address2' value='$row2->address2'></td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>Seller's address3</td>
      <td class='DataTD'><input class='Input' maxlength='12' name='_seller_address3' value='$row2->address3'></td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>Postal Code</td>
      <td class='DataTD'><input class='Input' maxlength='12' name='_postcode' value='$row2->postcode'></td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>Country</td>
      <td class='DataTD'><input class='Input' maxlength='12' name='_country' value='$row2->country'></td>
    </tr>
     <tr>  
      <td class='FieldCaptionTD'>Seller's ID</td>
      <td class='DataTD'><input class='Input' maxlength='12' name='_seller_id' value='$row2->sellersid'></td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>Net Amount Payable To Seller (CASH)</td>
      <td class='DataTD'><input class='Input' maxlength='12' name='_cash' value='$row2->amount_cash'></td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>Net Amount Payable To Seller (Vouchers)</td>
      <td class='DataTD'><input class='Input' maxlength='12' name='_vouchers' value='$row2->amount_vouchers'></td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>Invoice No.</td>
      <td class='DataTD'><input class='Input' maxlength='12' name='_invoice_no' value='$row2->invoice_no'></td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>Checker</td>
      <td class='DataTD'><input class='Input' maxlength='12' name='_checker' value='$row2->checker'></td>
    </tr>
   <tr>
      <td align='right' colspan='2'>
		<input name='state' type='hidden' value='1'>
			<input name='bs' type='hidden' value='$bs'>
	<input class='Button' name='Update' type='submit' value='$OKBTN'>
	</td>
    </tr>
  </table>
</form>
</center>
<BR>
</td></tr>
</table>";

}  // new or edit 

elseif ($todo=="2") { // Print

//Pdf Generation
echo " Buyer Sheet generation";

echo "Text, Text...";


echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>

<center>
  <font class='FormHeaderFont'>$tytul</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
  
  <tr>
      <td class='FieldCaptionTD'>Buyer</td>

<td class='DataTD'> $row2->no
</td></tr>

    <tr>
      <td class='FieldCaptionTD'>Date</td>
      <td class='DataTD'>$dataakt</td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>Shop</td>
      <td class='DataTD'>
      $row2->shopid
      </td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>Product Type</td>
      <td class='DataTD'>
      $row2->type</td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>Title</td>
      <td class='DataTD'>$row2->title</td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>Descripton of Goods</td>
      <td class='DataTD'>$row2->description</td>
    </tr>
     <tr>  
      <td class='FieldCaptionTD'>Seller</td>
      <td class='DataTD'>$row2->name</td>
    </tr>
     <tr>  
      <td class='FieldCaptionTD'>Seller's address1</td>
      <td class='DataTD'>$row2->address1</td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>Seller's address2</td>
      <td class='DataTD'>$row2->address2</td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>Seller's address3</td>
      <td class='DataTD'>$row2->address3</td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>Postal Code</td>
      <td class='DataTD'>$row2->postcode</td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>Country</td>
      <td class='DataTD'>$row2->country</td>
    </tr>
     <tr>  
      <td class='FieldCaptionTD'>Seller's ID</td>
      <td class='DataTD'>$row2->sellersid</td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>Net Amount Payable To Seller (CASH)</td>
      <td class='DataTD'>$row2->amount_cash</td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>Net Amount Payable To Seller (Vouchers)</td>
      <td class='DataTD'>$row2->amount_vouchers</td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>Invoice No.</td>
      <td class='DataTD'>$row2->invoice_no</td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>Checker</td>
      <td class='DataTD'>$row2->checker</td>
    </tr>
  </table>
</center>
<BR>
</td></tr>
</table>";

}

elseif ($todo=="3") { // Close

// State change 


}

include_once("./footer.php");
}
elseif($state==1)
{

$total = $_cash+$_vouchers;     
$pg = 2*$total;
$ipremium = 0.25*$total;
$icost = $ipremium*3;
 echo " BS $bs";
// insert
if ($bs == "new") {
   
   $ins = "
   INSERT INTO `seller` (  `name` , `address1` , `address2` , `address3` , `postcode` , `country` , `phone` , `email` , `sellersid` , `cur_timestamp` )
VALUES (
 '$_seller', '$_seller_address1', '$_seller_address2', '$_seller_address3', '$_postcode', '$_country', '1', '1', '$_seller_id', 'CURRENT_TIMESTAMP'
);

  ";
      if (!$db->Query($ins)) $db->Kill(); 

   $ins = "
   INSERT INTO `buyers_sheet` ( `no` , `shopid` , `type` , `title` , `description` , `sellerdbid` , `date1` , `price_goods` , `ins_premium` , `ins_adm_cost` , `ins_total` , `amount_cash` , `amount_vouchers` , `invoice_no` , `checker` , `ins_prem2` , `state`  )
VALUES (
'$_no', '$_shopid', '$_type', '$_title','$_description', LAST_INSERT_ID(), NOW(), '$pg', '$ipremium', '$icost', '$total', '$_cash', '$_vouchers', '$_invoice_no', '$_checker', '$ipremium', '1');

   ";
   
         if (!$db->Query($ins)) $db->Kill(); 
                  }
// update
else {

$q = "SELECT * FROM `buyers_sheet` INNER JOIN `seller` ON  `buyers_sheet`.`sellerdbid`=`seller`.`sellerdbid` WHERE `buyers_sheet`.`id`='$bs'
Limit 1";

  if ($db2->Query($q)) 
  {
     $row2=$db2->Row();
  }

$upd = "UPDATE `buyers_sheet` SET `no`='$_no',`shopid`='$_shopid',`type`='$_type',`title`='$_title', `description`='$_description',`price_goods`='$pg',`ins_premium`='$ipremium',`ins_adm_cost`='$icost',`ins_total`='$total',`amount_cash`='$_cash',`amount_vouchers`='$_vouchers',`invoice_no`='$_invoice_no', `checker`='$_checker',`ins_prem2`='$ipremium' WHERE `id`='$bs' Limit 1";
  if (!$db->Query($upd)) $db->Kill();

 
$upd = "UPDATE `seller` SET seller.name='$_seller',`address1`='$_seller_address1',`address2`='$_seller_address2',`address3`='$_seller_address3',`postcode`='$_postcode',`country`='$_country',`sellersid`='$_seller_id' WHERE `sellerdbid`='$row2->sellerdbid' Limit 1";
  if (!$db->Query($upd)) $db->Kill(); 

}                  
                  
                  
 //  echo "<script language='javascript'>window.location=\"totalh2.php?cln=$_cln&startd=$startd&endd=$endd\"</script>";
} //fi state=1
else
{
 echo "<BR><BR><BR>Ostrze¿enie!!!!!<BR><BR><BR>",
	 "Oy! What are you doing? $REMOTE_ADDR <BR>";
} //else state
?>