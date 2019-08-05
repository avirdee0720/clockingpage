<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;

echo "	<A HREF='prod1.php'><font class='FormHeaderFont'>$OBJADD $PRODUCT</font></A><BR><BR>
<TD ALIGN=JUSTIFY VALIGN=TOP border=0>

<center>
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE' bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white'>
<tbody>
<tr>
<td class='FieldCaptionTD'><B>LP</B></td>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=1&kier=$kier'><B>$PRODUCT</B>$kier_img[1]</A></td>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=2&kier=$kier'><B>$suplayer</B>$kier_img[2]</A></td>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=3&kier=$kier'><B>$CatNo</B>$kier_img[3]</A></td>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=4&kier=$kier'><B>$QPU</B>$kier_img[4]</a></td>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=5&kier=$kier'><B>$categ</B>$kier_img[5]</A></td>
</tr>";

if (!$db->Open()) $db->Kill();

if(!isset($sort)) $sort=1;

	switch ($sort)
		{
		case 1:
		 $sortowanie=" ORDER BY ProductName $kier_sql";
		 break;
		case 2:
		 $sortowanie=" ORDER BY CompanyName $kier_sql";
		 break;
		case 3:
		 $sortowanie=" ORDER BY CatalogueNo $kier_sql";
		 break;
		case 4:
		 $sortowanie=" ORDER BY QuantityPerUnit $kier_sql";
		 break;
		case 5:
		 $sortowanie=" ORDER BY CategoryType $kier_sql";
		 break;

		default:
		 $sortowanie=" ORDER BY ProductName $kier_sql ";
		 break;
		}


if(!isset($nr_zam_o)){
    $sql =("SELECT ProductsTbl.ProductID, ProductsTbl.ProductName, SuppliersTbl.CompanyName, ProductSuppliersTbl.ProductSupplierID, ProductSuppliersTbl.CatalogueNo, ProductSuppliersTbl.QuantityPerUnit, ProductCategoryTbl.CategoryType FROM ProductsTbl RIGHT JOIN ( ProductCategoryTbl INNER JOIN ( SuppliersTbl INNER JOIN ProductSuppliersTbl ON SuppliersTbl.SupplierID = ProductSuppliersTbl.SupplierID ) ON ProductCategoryTbl.ProductCategory =  SuppliersTbl.SupplierCategory ) ON ProductsTbl.ProductID = ProductSuppliersTbl.ProductID ");
}else{
   $sql =("SELECT ProductsTbl.ProductID, ProductsTbl.ProductName, SuppliersTbl.CompanyName, ProductSuppliersTbl.ProductSupplierID, ProductSuppliersTbl.CatalogueNo, ProductSuppliersTbl.QuantityPerUnit,  ProductCategoryTbl.CategoryType FROM ProductsTbl RIGHT JOIN ( ProductCategoryTbl INNER JOIN ( SuppliersTbl INNER JOIN ProductSuppliersTbl ON SuppliersTbl.SupplierID = ProductSuppliersTbl.SupplierID ) ON ProductCategoryTbl.ProductCategory =  SuppliersTbl.SupplierCategory ) ON ProductsTbl.ProductID = ProductSuppliersTbl.ProductID");

}
	$q=$sql.$sortowanie;

  if (!$db->Query($q)) $db->Kill();
$licz=1;
    while ($row=$db->Row())
    {
    
    echo "<tr>
        <td class='DataTD'><B>$licz</B></td>
		<td class='DataTD'><A HREF='prod1_ed.php?prod=$row->ProductID'><B>$row->ProductName</B></A></td>
        <td class='DataTD'><A HREF='prod1_ed.php?prod=$row->ProductID'>$row->CompanyName</A></td>
        <td class='DataTD'>$row->ProductSupplierID $row->CatalogueNo</td>
        <td class='DataTD'>$row->QuantityPerUnit</td>
        <td class='DataTD'>$row->CategoryType</td>
      </tr>";
     $licz++;			
   } // koniec pentli


echo "</table>
</td></tr>
</table> 

</td></tr></table></form></center>
";
include_once("./footer.php");
?>