<?php
include_once("./header.php");
$tytul='New sub menu ';
//include("./inc/uprawnienia.php");

if(!isset($state))
{
echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>

<center>
<form action='$PHP_SELF' method='post' name='ed_czl'>
  <font class='FormHeaderFont'>$tytul</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
 <tr>
      <td class='FieldCaptionTD'>Menu name *</td>
      <td class='DataTD'><input class='Input' maxlength='15' name='_mnu_nazwa' size='15' value='$row->mnu_nazwa'></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>File *</td>
      <td class='DataTD'><input class='Input' maxlength='15' name='_mnu_plik' size='15' value='$row->mnu_plik'></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Sorting</td>
      <td class='DataTD'><input class='Input' maxlength='15' name='_kol' size='15' value='$row->kol'></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>No GL *(do not use)</td>
      <td class='DataTD'><input class='Input' maxlength='20' name='_mnu_nr' value='$row->mnu_nr'>

      </td>
    </tr>
    <tr>
		<TD>
		<input class='Button' name='Insert' type='submit'  value='Nowy'>
			<input class='Button' name='Update' type='submit' value='Zapisz'>
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

if(isset($Update) and $Update=='Zapisz')
{ 
	$tabela = "menu";
	$op = "add sub menu";
	if (!$db->Open()) $db->Kill();
	$logi = "INSERT INTO hd_log ( lp, tabela, temat, kiedy, user_id, infodod) VALUES(null, '$tabela', '$op', '$dzis $godz', '$id', '$_mnu_nazwa')";
    $result = mysql_query($logi);

	$query = ("    8UPDATE hd_menu1 SET  mnu_nazwa= '$_mnu_nazwa', mnu_nr = '$_mnu_nr', mnu_plik = '$_mnu_plik', kol='$_kol' WHERE `lp` = '$lp' LIMIT 1") ;
     if (!$db->Open()) $db->Kill();
    $result = mysql_query($query);
    echo "<script language='javascript'>window.location=\"adm_podmnu.php?lp=$idpm\"</script>";
   }

} //fi state=1
else
{
 echo "<BR><BR><BR>Ostrze¿enie!!!!!<BR><BR><BR>",
	 "Ktos z komputera $REMOTE_ADDR probuje sie wlamac<BR>";
} //else state
//} //elseif  state
?>