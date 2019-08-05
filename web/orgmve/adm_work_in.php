<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$tytul='Users which using program now';

uprstr($PU,90);
if (!isset($lp)) $lp=0;
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
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=1&kier=$kier'><B>Lp</B>$kier_img[1]</A></td>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=2&kier=$kier'><B>Date</B>$kier_img[2]</A></td>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=3&kier=$kier'><B>Who</B>$kier_img[3]</A></td>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=4&kier=$kier'><B>Comp. no</B>$kier_img[4]</a></td>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=5&kier=$kier'><B>Where</B>$kier_img[5]</A></td>

</tr>";


if (!$db->Open()) $db->Kill();

if(!isset($sort)) $sort=1;
 // ID_SES   	  lp   	  DATA_IN   	  DATA_OUT   	  SES_ID   	  host
	switch ($sort)
		{
		case 1:
		 $sortowanie=" ORDER BY `hd_users`.`nazwa` $kier_sql";
		 break;
		case 2:
		 $sortowanie=" ORDER BY `hd_users_logins`.`DATA_IN` $kier_sql";
		 break;
		case 3:
		 $sortowanie=" ORDER BY `hd_users_logins`.`host` $kier_sql";
		 break;
		case 4:
		 $sortowanie=" ORDER BY `hd_users`.`menu` $kier_sql";
		 break;
		case 5:
		 $sortowanie=" ORDER BY `hd_menu1`.`mnu_nazwa` $kier_sql";
		 break;
		default:
		 $sortowanie=" ORDER BY `hd_users_logins`.`DATA_IN` $kier_sql ";
		 break;
		}

$sql = "SELECT `hd_users`.`nazwa`, `hd_users_logins`.`DATA_IN`,`hd_users_logins`.`host`,`hd_users`.`menu`,`hd_menu1`.`mnu_nazwa` FROM  `hd_users_logins` INNER  JOIN  (`hd_users` INNER JOIN `hd_menu1` ON `hd_menu1`.`lp`=`hd_users`.`menu`) ON `hd_users_logins`.`lp` = `hd_users`.`lp` WHERE `hd_users_logins`.`SES_ID` IS  NOT  NULL ";

$q=$sql.$sortowanie;


  if ($db->Query($q)) 
  {
    while ($row=$db->Row())
    {
$lp++;
     echo "
  <tr>
    <td class='DataTD'>$lp</td>
    <td class='DataTD'>$row->DATA_IN</td>
    <td class='DataTD'>$row->nazwa</td>
    <td class='DataTD'>$row->host</td>
	<td class='DataTD'>$row->mnu_nazwa</td>
  </tr>
  ";
  } 
} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='5'>Brak U¿ytkowników</td>
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