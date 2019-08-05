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
  <font class='FormHeaderFont'>$TYTULADMDZ2</font>
	<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
    <tbody>
         <tr><td class='FieldCaptionTD'><B><FONT COLOR='#FF0099'>$DSKOD</FONT></B></td>
        <td class='DataTD'><input class='Input' maxlength='7' name='_DSKOD' size='7' value=''> </td>
      </tr>
        </td>
        <tr><td class='FieldCaptionTD'>$DSNAZWA</td>
        <td class='DataTD'><input class='Input' size='70' maxlength='70' name='_DSNAZWA' value=''></td>
      </tr>
        <tr><td class='FieldCaptionTD'>$DSMIASTO</td>
        <td class='DataTD'><input class='Input' maxlength='20' name='_DSMIASTO'  value=''>&nbsp;</td>
      </tr>

<tr><td class='DataTD' colspan='2' nowrap>
<table>
<tr><td class='FieldCaptionTD'>$DSULICA</td>
        <td class='DataTD'><input class='Input' maxlength='50' size='20' name='_DSULICA'  value=''>&nbsp;</td>
<td class='FieldCaptionTD'>&nbsp;</td>
        <td class='DataTD'><input class='Input' maxlength='5' size='5' name='_DSNRDOMU'  value=''>&nbsp; </td>

<td class='FieldCaptionTD'>$DSKOD</td>
        <td class='DataTD'><input class='Input' maxlength='6' size='6' name='_DSKODPOCZT' value=''>&nbsp; </td> 
 </tr>

</table>

<table>
<tr>
<td class='FieldCaptionTD'>$DSTEL</td>
        <td class='DataTD'><input class='Input' maxlength='12' size='12' name='_DSTEL'  value=''>&nbsp; </td>

<td class='FieldCaptionTD'>$DSFAX</td>
        <td class='DataTD'><input class='Input' maxlength='12' size='12' name='_DSFAX'  value=''>&nbsp; </td>

<td class='FieldCaptionTD'>$DSTELEX</td>
        <td class='DataTD'><input class='Input' maxlength='12' size='12' name='_DSTELEX'  value=''>&nbsp; </td>
      </tr>

</table>

</td>
        <tr><td class='FieldCaptionTD'>$DSSALDOZ</td>
        <td class='DataTD'><input class='Input' maxlength='10' size='10' name='_DSSALDO'  value=''>&nbsp; </td>
      </tr>
<!-- LINIA -->
<TR><TD colspan='2' nowrap>	<HR></TD></TR>

        <tr><td class='FieldCaptionTD'>$DSDLUG</td>
        <td class='DataTD'><input class='Input' maxlength='5' size='5' name='_DSDLUG'  value=''>&nbsp;Stan faktyczny </td>
      </tr>
        <tr><td class='FieldCaptionTD'>$DSBANK </td>
        <td class='DataTD'><input class='Input' maxlength='50' size='50' name='_DSBANK'  value=''>&nbsp; </td>
      </tr>
        <tr><td class='FieldCaptionTD'>$DSKONTO</td>
        <td class='DataTD'><input class='Input' maxlength='50' size='50' name='_DSKONTO'  value=''>&nbsp; </td>
      </tr>
        <tr><td class='FieldCaptionTD'>$DSRABAT</td>
        <td class='DataTD'><input class='Input' maxlength='5' size='5' name='_DSRABAT'  value=''>&nbsp; </td>
      </tr>
        <tr><td class='FieldCaptionTD'>$DSNIP</td>
        <td class='DataTD'><input class='Input' maxlength='20' size='20' name='_DSNRIDENT'  value=''>&nbsp; </td>
      </tr>
        <tr><td class='FieldCaptionTD'>$DSUWAGI</td>
        <td class='DataTD'><input class='Input' maxlength='70' size='70' name='_DSUWAGI'  value=''>&nbsp; </td>
      </tr>

        <tr><td class='FieldCaptionTD'>$DSPRACOW</td>
        <td class='DataTD'><input class='Input' maxlength='15' size='15' name='_DSPRACOW'  value=''>&nbsp; </td>
      </tr>
        <tr><td class='FieldCaptionTD'>$DSNAZSKR</td>
        <td class='DataTD'><input class='Input' maxlength='15' size='15' name='_DSNAZSKR'  value=''>&nbsp; </td>
      </tr>
        <tr><td class='FieldCaptionTD'>$DSKONTOFK</td>
        <td class='DataTD'><input class='Input' maxlength='15' size='15' name='_DSKONTOFK'  value=''>&nbsp; </td>
      </tr>";
echo "<tr>
        <td align='right' colspan='2'>
			<input name='state' type='hidden' value='1'>

			<input class='Button' name='Update' type='submit' value='Zapisz'>

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
//  sprawdzenie uprawnieñ do tabeli ladowania ' pakoasortym'
$tabela = "hd_dostawcy";
upr2w($PU,$tabela,"ins");

 $query = ("INSERT INTO hd_dostawcy (DSKOD, DSNAZWA, DSMIASTO, DSULICA, DSNRDOMU, DSKODPOCZT, DSTEL, DSFAX, DSTELEX, DSSALDO, DSDLUG, DSBANK, DSKONTO, DSRABAT, DSNRIDENT, DSUWAGI, DSPRACOW, DSNAZSKR, DSKONTOFK, user_id) VALUES ('$_DSKOD', '$_DSNAZWA', '$_DSMIASTO', '$_DSULICA', '$_DSNRDOMU', '$_DSKODPOCZT', '$_DSTEL', '$_DSFAX', '$_DSTELEX', '$_DSSALDO', '$_DSDLUG', '$_DSBANK', '$_DSKONTO', '$_DSRABAT','$_DSNRIDENT', '$_DSUWAGI', '$_DSPRACOW', '$_DSNAZSKR', '$_DSKONTOFK','$id')");

   if (!$db->Open()) $db->Kill();
   $result = mysql_query($query);
   $lp=mysql_insert_id();   
   echo "<script language='javascript'>window.location=\"ed_dost.php?lp=$lp\"</script>";


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