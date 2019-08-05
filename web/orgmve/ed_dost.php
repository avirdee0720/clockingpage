<?php
if(!isset($id) && !isset($pw))
{header("Location: index.html");exit;}

include_once("./header.php");
include("./inc/uprawnienia.php");
include("./languages/$LANGUAGE.php");


if(!isset($state))
{
echo "
<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
<table width='100%' border=0><tr><td>

<center>
<form action='$PHP_SELF' method='get' name='ed_art'>
  <font class='FormHeaderFont'>$TYTULADMDZ1</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
    <tbody>
";

	//$db = new CMySQL;
if (!$db->Open()) $db->Kill();

 if(isset($lp)){
  $q = "SELECT hd_dostawcy.ID, hd_dostawcy.DSKOD, hd_dostawcy.DSNAZWA, hd_dostawcy.DSMIASTO, hd_dostawcy.DSULICA, hd_dostawcy.DSNRDOMU, hd_dostawcy.DSKODPOCZT, hd_dostawcy.DSTEL, hd_dostawcy.DSFAX, hd_dostawcy.DSTELEX, hd_dostawcy.DSSALDO, hd_dostawcy.DSDLUG, hd_dostawcy.DSBANK, hd_dostawcy.DSKONTO, hd_dostawcy.DSRABAT, hd_dostawcy.DSNRIDENT, hd_dostawcy.DSUWAGI, hd_dostawcy.DSPRACOW, hd_dostawcy.DSNAZSKR, hd_dostawcy.DSKONTOFK, hd_users.nazwa FROM hd_dostawcy LEFT JOIN hd_users ON hd_dostawcy.user_id=hd_users.lp WHERE hd_dostawcy.ID='$lp' LIMIT 1";
  } else { 
  echo "<BR><BR><CENTER><H1>Cos siê zepsu³o!</H1></CENTER><BR><BR>";
  exit;
 }

  if (!$db->Query($q)) $db->Kill();
  
    while ($row=$db->Row())
    {

echo " 
        <tr><td class='FieldCaptionTD'><B><FONT COLOR='#FF0099'>$DSKOD</FONT></B></td>
        <td class='DataTD'><input class='Input' maxlength='7' name='_DSKOD' size='7' value='$row->DSKOD'> </td>
      </tr>
        </td>
        <tr><td class='FieldCaptionTD'>$DSNAZWA</td>
        <td class='DataTD'><input class='Input' size='70' maxlength='70' name='_DSNAZWA' value='$row->DSNAZWA'></td>
      </tr>
        <tr><td class='FieldCaptionTD'>$DSMIASTO</td>
        <td class='DataTD'><input class='Input' maxlength='20' name='_DSMIASTO'  value='$row->DSMIASTO'>&nbsp;</td>
      </tr>

<tr><td class='DataTD' colspan='2' nowrap>
<table>
<tr><td class='FieldCaptionTD'>$DSULICA</td>
        <td class='DataTD'><input class='Input' maxlength='50' size='20' name='_DSULICA'  value='$row->DSULICA'>&nbsp;</td>
<td class='FieldCaptionTD'>&nbsp;</td>
        <td class='DataTD'><input class='Input' maxlength='5' size='5' name='_DSNRDOMU'  value='$row->DSNRDOMU'>&nbsp; </td>

<td class='FieldCaptionTD'>$DSKOD</td>
        <td class='DataTD'><input class='Input' maxlength='6' size='6' name='_DSKODPOCZT' value='$row->DSKODPOCZT'>&nbsp; </td> 
 </tr>

</table>

<table>
<tr>
<td class='FieldCaptionTD'>$DSTEL</td>
        <td class='DataTD'><input class='Input' maxlength='12' size='12' name='_DSTEL'  value='$row->DSTEL'>&nbsp; </td>

<td class='FieldCaptionTD'>$DSFAX</td>
        <td class='DataTD'><input class='Input' maxlength='12' size='12' name='_DSFAX'  value='$row->DSFAX'>&nbsp; </td>

<td class='FieldCaptionTD'>$DSTELEX</td>
        <td class='DataTD'><input class='Input' maxlength='12' size='12' name='_DSTELEX'  value='$row->DSTELEX'>&nbsp; </td>
      </tr>

</table>

</td>
        <tr><td class='FieldCaptionTD'>$DSSALDOZ</td>
        <td class='DataTD'><input class='Input' maxlength='10' size='10' name='_DSSALDO'  value='$row->DSSALDO'>&nbsp; </td>
      </tr>
<!-- LINIA -->
<TR><TD colspan='2' nowrap>	<HR></TD></TR>

        <tr><td class='FieldCaptionTD'>$DSDLUG</td>
        <td class='DataTD'><input class='Input' maxlength='5' size='5' name='_DSDLUG'  value='$row->DSDLUG'>&nbsp;$DSDLUGOP</td>
      </tr>
        <tr><td class='FieldCaptionTD'>$DSBANK </td>
        <td class='DataTD'><input class='Input' maxlength='50' size='50' name='_DSBANK'  value='$row->DSBANK'>&nbsp; </td>
      </tr>
        <tr><td class='FieldCaptionTD'>$DSKONTO</td>
        <td class='DataTD'><input class='Input' maxlength='50' size='50' name='_DSKONTO'  value='$row->DSKONTO'>&nbsp; </td>
      </tr>
        <tr><td class='FieldCaptionTD'>$DSRABAT</td>
        <td class='DataTD'><input class='Input' maxlength='5' size='5' name='_DSRABAT'  value='$row->DSRABAT'>&nbsp; </td>
      </tr>
        <tr><td class='FieldCaptionTD'>$DSNIP</td>
        <td class='DataTD'><input class='Input' maxlength='20' size='20' name='_DSNRIDENT'  value='$row->DSNRIDENT'>&nbsp; </td>
      </tr>
        <tr><td class='FieldCaptionTD'>$DSUWAGI</td>
        <td class='DataTD'><input class='Input' maxlength='70' size='70' name='_DSUWAGI'  value='$row->DSUWAGI'>&nbsp; </td>
      </tr>

        <tr><td class='FieldCaptionTD'>$DSPRACOW</td>
        <td class='DataTD'><input class='Input' maxlength='15' size='15' name='_DSPRACOW'  value='$row->DSPRACOW'>&nbsp; </td>
      </tr>
        <tr><td class='FieldCaptionTD'>$DSNAZSKR</td>
        <td class='DataTD'><input class='Input' maxlength='15' size='15' name='_DSNAZSKR'  value='$row->DSNAZSKR'>&nbsp; </td>
      </tr>
        <tr><td class='FieldCaptionTD'>$DSKONTOFK</td>
        <td class='DataTD'><input class='Input' maxlength='15' size='15' name='_DSKONTOFK'  value='$row->DSKONTOFK'>&nbsp; </td>
      </tr>

        <tr><td class='FieldCaptionTD'>$AKT0</td>
        <td class='DataTD'>$row->nazwa, Nr: <B><FONT COLOR='#FF0000'>$row->DSKOD</FONT></B></td>
      </tr>
<input name='lp' type='hidden' value='$row->ID'>";
			
} 

echo "<tr>
        <td align='right' colspan='2'>
			<input name='state' type='hidden' value='1'>
			<input class='Button' name='Insert' type='submit'  value='$NEWBTN'>
			<input class='Button' name='Update' type='submit' value='$SAVEBTN'>
			<input class='Button' type='submit' name='Delete' onclick=\"return confirm('Czy na pewno skasowac?')\" value='$DELBTN'>
			<input class='Button'  type='Button' onclick='javascript:history.back()' value='$BACKBTN'>
			<input class='Button'  type='Button' onclick='window.location=\"adm_dost.php\"' value='$LISTBTN'>
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
include("./languages/$LANGUAGE.php");
//  sprawdzenie uprawnieñ do tabeli 

$tabela = "hd_dostawcy";
upr2w($PU,$tabela,"upt");

if(isset($Update) and $Update==strval("$SAVEBTN"))
{ $query = ("UPDATE hd_dostawcy SET  DSKOD='$_DSKOD', DSNAZWA='$_DSNAZWA', DSMIASTO='$_DSMIASTO', DSULICA='$_DSULICA', DSNRDOMU='$_DSNRDOMU', DSKODPOCZT='$_DSKODPOCZT', DSTEL='$_DSTEL', DSFAX='$_DSFAX', DSTELEX='$_DSTELEX', DSSALDO='$_DSSALDO', DSDLUG='$_DSDLUG', DSBANK='$_DSBANK', DSKONTO='$_DSKONTO', DSRABAT='$_DSRABAT', DSNRIDENT='$_DSNRIDENT', DSUWAGI='$_DSUWAGI', DSPRACOW='$_DSPRACOW', DSNAZSKR='$_DSNAZSKR', DSKONTOFK='$_DSKONTOFK' WHERE ID='$lp' LIMIT 1") ;
   if (!$db->Open()) $db->Kill();
   $result = mysql_query($query);
   echo "<script language='javascript'>window.location=\"ed_dost.php?lp=$lp\"</script>";
   }

if(isset($Delete) and $Delete==strval("$DELBTN"))
 {  $kto=$id;
    if (!$db->Open())$db->Kill();
    $opis="Usuniecie $_DSKOD";
    upr2w($PU,$tabela,"del");
    $ktoto =("INSERT INTO hd_logi ( lp,tabela,temat,kiedy,user_id,infodod) VALUES(NULL,'$tabela','$opis', '$dzis $godz', '$id','$_ASNAZWA')") ;
            if (!$db->Query($ktoto)) $db->Kill();

	$query = ("DELETE FROM hd_dostawcy WHERE ID=$lp") ;
    $result = mysql_query($query);
	echo "<script language='javascript'>window.location=\"adm_dost.php\"</script>";
	}

if(isset($Insert) and $Insert==strval("$NEWBTN"))
 { echo "<script language='javascript'>window.location=\"n_dost.php\"</script>";

   }

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