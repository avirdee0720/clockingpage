<?php
include_once("./header.php");
$tytul='U¿ytkownicy';
include("./inc/uprawnienia.php");
uprstr($PU,95);
if(!isset($state))
{
echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>

<center>
<!-- BEGIN Record members -->
<form action='$PHP_SELF' method='post' name='ed_czl'>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>";



 if (!$db->Open()) $db->Kill();

 if(isset($lp)){
  $q = "SELECT hd_wydzial.lp, hd_wydzial.dzial, hd_wydzial.lokalizacja FROM hd_wydzial WHERE hd_wydzial.lp='$lp' LIMIT 1";
  } else { 
  echo "<BR><BR><CENTER><H1>Cos siê zepsu³o!</H1></CENTER><BR><BR>";
  exit;
 }

  if (!$db->Query($q)) $db->Kill();
  
    while ($row=$db->Row())
    {
  echo " <tr>
      <td class='FieldCaptionTD'>$DEPART</td>
      <td class='DataTD'><input class='Input' maxlength='15' name='dzial' size='15' value='$row->dzial'></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$LOCAL</td>
      <td class='DataTD'><input class='Input' maxlength='50' name='lokalizacja' size='30' value='$row->lokalizacja'></td>
    </tr>
    <tr>
      <td align='right' colspan='2'>
		<input name='lp' type='hidden' value='$row->lp'>
		<input name='state' type='hidden' value='1'>";
			
} 
echo "
			<input class='Button' name='Insert' type='submit'  value='$NEWBTN'>
			<input class='Button' name='Update' type='submit' value='$SAVEBTN'>
			<input class='Button' type='submit' name='Delete' onclick=\"return confirm('Czy na pewno skasowac?')\" value='$DELBTN'>
			<input class='Button'  type='Button' onclick='window.location=\"adm_dzial.php\"' value='$LISTBTN'></td>
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

//  sprawdzenie uprawnieñ do tabeli ladowania ' pakoasortym'
$tabela = "hd_users";
echo "<B>Sprawdzanie uprawnieñ</B><BR><BR>";
if (!$db->Open()) $db->Kill();
$upr = ("SELECT lp,ins FROM hd_upr WHERE tabela LIKE '%$tabela' LIMIT 1");
 if (!$db->Query($upr)) $db->Kill();
   while ($row=$db->Row())
		{
     $wymagane = $row->ins;
	}
	if ($PU < $wymagane) 
	{ 
		echo "<script language='javascript'>window.location=\"upr.php\"</script>";
		exit;

	} 
// koniec sprawdzania uprawnien

		 $op = "poprawka hd_wydzial";
		 $logi = "INSERT INTO hd_log ( lp, tabela, temat, kiedy, user_id, infodod) VALUES(null, '$tabela', '$op', '$dzis $godz', '$id', '$dzial')";
		  if (!$db->Query($logi)) $db->Kill();
// zapis startu loga

$haslo=md5($passwd);
if(isset($Update) and $Update=='$SAVEBTN')
{ $query = ("UPDATE hd_wydzial SET `dzial` = '$dzial',`lokalizacja` = '$lokalizacja' WHERE `lp` = '$lp' LIMIT 1") ;
   if (!$db->Open()) $db->Kill();
   $result = mysql_query($query);
   echo "<script language='javascript'>window.location=\"adm_dzial.php\"</script>";
   }

if(isset($Delete) and $Delete=='$DELBTN')
 {  
	if (!$db->Open())$db->Kill();
    $opis=$_title.": ".$art1;
    $tabela="hd_users";
    $ktoto =("INSERT INTO hd_kasowal ( lp, tabela, temat, kiedy, user_id  ) VALUES(NULL,'$tabela','$nazwa', '$dzis $godz','$id')") ;
            if (!$db->Query($ktoto)) $db->Kill();

	$query = ("DELETE FROM hd_wydzial WHERE lp=$lp") ;
    $result = mysql_query($query);
	//header("Location: adm_art.php");
	echo "<script language='javascript'>window.location=\"adm_dzial.php\"</script>";	}

if(isset($Insert) and $Insert=='$NEWBTN')
 { echo "<script language='javascript'>window.location=\"n_dz.php\"</script>";   }

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