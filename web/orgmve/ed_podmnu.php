<?php
include_once("./header.php");
//$tytul='Edycja Pod menu ';
//include("./inc/uprawnienia.php");

if(!isset($state))
{
echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>

<center>
<!-- BEGIN Record members -->
<form action='$PHP_SELF' method='post' name='ed_czl'>
  <font class='FormHeaderFont'>$tytul</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
";

//uprstr($PU,50);

 if (!$db->Open()) $db->Kill();

 if(isset($lp)){
  $q = "SELECT lp,mnu_nazwa,mnu_nr,mnu_plik, kol FROM hd_menu1 WHERE lp='$lp' LIMIT 1";
  } else { 
  echo "<BR><BR><CENTER><H1>Cos siê zepsu³o!</H1></CENTER><BR><BR>";
  exit;
 }

  if (!$db->Query($q)) $db->Kill();
  
    while ($row=$db->Row())
    {
  echo " <tr>
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
<input name='idpm' type='hidden' value='$lp'>
<input name='lp' type='hidden' value='$row->lp'>
<input name='state' type='hidden' value='1'>
";
			
} 
echo "
    </tr>
    <tr>
		<TD>
		<input class='Button' name='Insert' type='submit'  value='Nowy'>
			<input class='Button' name='Update' type='submit' value='Zapisz'>
			<input class='Button' type='submit' name='Delete' onclick=\"return confirm('Czy na pewno skasowac?')\" value='Usuñ'>
			<input class='Button'  type='Button' onclick='window.location=\"adm_podmnu.php?lp=$idpm\"' value='Lista'></td>
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
	$op = "poprawka menugl";
	if (!$db->Open()) $db->Kill();
	$logi = "INSERT INTO hd_log ( lp, tabela, temat, kiedy, user_id, infodod) VALUES(null, '$tabela', '$op', '$dzis $godz', '$id', '$_mnu_nazwa')";
    $result = mysql_query($logi);

	$query = ("UPDATE hd_menu1 SET  mnu_nazwa= '$_mnu_nazwa', mnu_nr = '$_mnu_nr', mnu_plik = '$_mnu_plik', kol='$_kol' WHERE `lp` = '$lp' LIMIT 1") ;
     if (!$db->Open()) $db->Kill();
    $result = mysql_query($query);
    echo "<script language='javascript'>window.location=\"adm_podmnu.php?lp=$idpm\"</script>";
   }

if(isset($Delete) and $Delete=='Usuñ')
 {  
	if (!$db->Open())$db->Kill();
    $opis=$_title.": ".$art1;
    $tabela="user";
    $ktoto =("INSERT INTO hd_log ( lp, tabela, temat, kiedy, user_id  ) VALUES(NULL,'$tabela','$nazwa', '$dzis $godz','$id')") ;
            if (!$db->Query($ktoto)) $db->Kill();

	$query = ("DELETE FROM hd_menu1 WHERE lp=$lp") ;
    $result = mysql_query($query);
	//header("Location: adm_art.php");
//	echo "<script language='javascript'>window.location=\"adm_podmnu.php\"</script>";	}

if(isset($Insert) and $Insert=='Nowy')
 { echo "<script language='javascript'>window.location=\"n_podmnu.php\"</script>";   }

} //fi state=1
/*


*/
else
{
 echo "<BR><BR><BR>Ostrze¿enie!!!!!<BR><BR><BR>",
	 "Ktos z komputera $REMOTE_ADDR probuje sie wlamac<BR>";
} //else state
//} //elseif  state
?>