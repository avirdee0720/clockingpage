<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$tytul='System logs ';

uprstr($PU,90);

echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>

<center>
<!--
<form action='{Action}' method='post' name='{HTMLFormName}'>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>

    <tr>
      <td class='FieldCaptionTD'>Login (Name)</td>
      <td class='DataTD'>
	  
	    <input class='Input' maxlength='15' name='member_login' value=''>&nbsp;
		<input class='Button' name='DoSearch' type='submit' value='Szukaj'></td>
    </tr>
  </table>

</form>
-->
&nbsp;
<font class='FormHeaderFont'>$tytul</font>
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
  <tr>
    <td class='ColumnTD' nowrap>
		<a class='SorterLink' href='$PHP_SELF?sort=1&kier=$kier'>Table $kier_img[1]</a>

	</td>
    <td class='ColumnTD' nowrap>
		<a class='SorterLink' href='$PHP_SELF?sort=2&kier=$kier'>Subject $kier_img[2]</a>

	</td>
    <td class='ColumnTD' nowrap>
		<a class='SorterLink' href='$PHP_SELF?sort=3&kier=$kier'>When $kier_img[3]</a>

	</td>
    <td class='ColumnTD' nowrap>
		<a class='SorterLink' href='$PHP_SELF?sort=4&kier=$kier'>Who $kier_img[4]</a>

	</td>
	    <td class='ColumnTD' nowrap>
		<a class='SorterLink' href='$PHP_SELF?sort=5&kier=$kier'>Info $kier_img[5]</a>

	</td>
  </tr>
";

if(!isset($sort)) $sort=0;

	switch ($sort)
		{
		case 1:
		 $sortowanie=" ORDER BY hd_log.tabela $kier_sql";
		 break;
		case 2:
		 $sortowanie=" ORDER BY hd_log.temat $kier_sql";
		 break;
		case 3:
		 $sortowanie=" ORDER BY hd_log.kiedy $kier_sql";
		 break;
		case 4:
		 $sortowanie=" ORDER BY hd_users.nazwa $kier_sql";
		 break;
		case 5:
		 $sortowanie=" ORDER BY hd_log.infodod $kier_sql ";
		 break;
		default:
		 $sortowanie=" ORDER BY hd_log.kiedy $kier_sql ";
		 break;
		}

if (!$db->Open()) $db->Kill();
$sql = "SELECT hd_log.lp, hd_log.tabela, hd_log.temat, hd_log.kiedy, hd_log.user_id, hd_log.infodod, hd_users.nazwa  FROM hd_log, hd_users WHERE hd_log.user_id=hd_users.lp ";
$q=$sql.$sortowanie;

  if ($db->Query($q)) 
  {
    while ($row=$db->Row())
    {

     echo "
  <tr>
    <td class='DataTD'>$row->tabela</td>
    <td class='DataTD'>$row->temat</td>
    <td class='DataTD'>$row->kiedy</td>
    <td class='DataTD'>$row->nazwa</td>
    <td class='DataTD'>$row->infodod</td>
  </tr>
  ";
  } 
} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='5'>Error</td>
  </tr>";
 $db->Kill();
}
echo "
  <tr>
    <td align='left' class='FooterTD' nowrap>&nbsp;</td>
    <td align='middle' class='FooterTD' colspan='4' nowrap>&nbsp;</td>
  </tr>
</table>
<!-- END Grid members -->
</center>
<BR>
</td></tr>
</table>";
include_once("./footer.php");
?>