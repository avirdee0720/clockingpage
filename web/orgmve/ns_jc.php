<?php
//if(!isset($id) && !isset($pw))
//{header("Location: index.html");exit;}

include_once("./header.php");
$tytul='Nowa jednostka centralna';

if(!isset($state))
{
echo "<center>
<form action='$PHP_SELF' method='get' name='n_art'>
  <font class='FormHeaderFont'>$tytul</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
    <tbody>
<tr><td  colspan='2'>
<table border='0' cellpadding='3' cellspacing='1'>
<tr>
        <td class='FieldCaptionTD'>Klawiatura</td>
        <td class='DataTD'><INPUT TYPE='checkbox' NAME='_Klawiatura'></td>
	    <td class='FieldCaptionTD'>Mysz</td>
        <td class='DataTD'><INPUT TYPE='checkbox' NAME='_Mysz'></td>
		<td class='FieldCaptionTD'>TCP/IP z DHCP</td>
        <td class='DataTD'><INPUT TYPE='checkbox' NAME='_TCP_IP_DHCP'></td>
		<td class='FieldCaptionTD'>TCP/IP Reczne:</td>
        <td class='DataTD'><INPUT TYPE='input' maxlength='20' NAME='_TCP_IP_Reczne'></td>	
</tr>
</TD></tr>
</table>
</tr>
<tr><td  colspan='2'>
<table border='0' cellpadding='3' cellspacing='1'>
<tr>
        <td class='FieldCaptionTD'>HDD0</td>
        <td class='DataTD'><INPUT TYPE='INPUT' size='6' NAME='_HDD0' onChange=\"this.value=this.value.toUpperCase()\">&nbsp;MB</td>
	    <td class='FieldCaptionTD'>HDD1</td>
        <td class='DataTD'><INPUT TYPE='INPUT' size='6' NAME='_HDD1' onChange=\"this.value=this.value.toUpperCase()\">&nbsp;MB</td>
		<td class='FieldCaptionTD'>HDD2</td>
        <td class='DataTD'><INPUT TYPE='INPUT' size='6' NAME='_HDD2' onChange=\"this.value=this.value.toUpperCase()\">&nbsp;MB</td>
		<td class='FieldCaptionTD'>HDD3</td>
        <td class='DataTD'><INPUT TYPE='INPUT' size='6' NAME='HDD3' onChange=\"this.value=this.value.toUpperCase()\">&nbsp;MB</td>	
</tr>
</TD></tr>
</table></tr>
<tr><td  colspan='2'>
<table border='0' cellpadding='3' cellspacing='1'>
<tr>
	    <td class='FieldCaptionTD'>RAM</td>
        <td class='DataTD'><INPUT TYPE='INPUT' size='6' NAME='_MB_RAM'>&nbsp;MB</td>
	    <td class='FieldCaptionTD'>Muzyka</td>
        <td class='DataTD'><INPUT TYPE='checkbox' NAME='_Muzyka'></td>
		<td class='FieldCaptionTD'>Procesor</td>
        <td class='DataTD'><INPUT TYPE='INPUT' size='10'maxlenght='50' NAME='_Procesor'>&nbsp;opis</td>
</tr>
</TD></tr>
</table></tr>
<tr><td  colspan='2'>
<table border='0' cellpadding='3' cellspacing='1'>
<tr>
	    <td class='FieldCaptionTD'>Dostawca</td>
        <td class='DataTD'><INPUT TYPE='INPUT' NAME='_Dostawca' onChange=\"this.value=this.value.toUpperCase()\"></td>
		<td class='FieldCaptionTD'>Model</td>
        <td class='DataTD'><INPUT TYPE='INPUT' NAME='_Model' onChange=\"this.value=this.value.toUpperCase()\"></td>
</tr>
</TD></tr>
</table></tr>
<tr>
        <td class='FieldCaptionTD'>Dzia³</td>
        <td class='DataTD'><INPUT TYPE='input' class='Input' size='50' maxlength='50' name='_Dzial' onChange=\"this.value=this.value.toUpperCase()\"></td>
      </tr>
      <tr>
        <td class='FieldCaptionTD'>Lokalizacja</td>
        <td class='DataTD'><INPUT TYPE='input' class='Input' size='70'  maxlength='70' name='_Lokalizacja' onChange=\"this.value=this.value.toUpperCase()\"></td>
      </tr>
      <tr>
        <td class='FieldCaptionTD'>Uzytkownik</td>
        <td class='DataTD'><INPUT TYPE='input' class='Input' size='50' maxlength='50' name='_Uzytkownik' onChange=\"this.value=this.value.toUpperCase()\"></td>
      </tr>
	  <tr>
        <td class='FieldCaptionTD'> Nr_ewid</td>
        <td class='DataTD'><INPUT TYPE='input' class='Input' size='50' maxlength='50' name='_Nr_ewid' ></td>
      </tr>
      <tr>
        <td class='FieldCaptionTD'>Nr_seryjny</td>
        <td class='DataTD'><input class='Input' size='50' maxlength='50' name='_Nr_seryjny'  value=''></td>
      </tr>
      <tr>
        <td class='FieldCaptionTD'>Rok_prod</td>
        <td class='DataTD'><input class='Input' size='4' maxlength='4' name='_Rok_prod'  value=''></td>
      </tr>
      <tr>
        <td class='FieldCaptionTD'>Nazwa_sieciowa</td>
        <td class='DataTD'><input class='Input' size='50' maxlength='50' name='_Nazwa_sieciowa'  value=''></td>
      </tr>
      <tr>
        <td class='FieldCaptionTD'>Data_gw_do</td>
        <td class='DataTD'><input class='Input' maxlength='10' name='_Data_gw_do'  value=''></td>
      </tr>
<tr>
        <td align='right' colspan='2'>
			<input  name='state' type='hidden' value='1'>
			<input  name='dataogl' type='hidden' value='$dzis'>
			<input class='Button' name='Nowy' type='submit' value='Zapisz'>
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

if(isset($Nowy) and $Nowy=='Zapisz')
    {  
	if ($_Klawiatura=="on") $kbd=1;
	   else $kbd=0;
	if ($_Mysz=="on") $mysz=1;
	   else $mysz=0;
	if ($_TCP_IP_DHCP=="on") $dhcp=1;
	   else $dhcp=0;
	if ($_Muzyka=="on") $muzyka=1;
	   else $muzyka=0;
	if (!$db->Open())$db->Kill();
    $query =("INSERT INTO hd_komp (lp, Klawiatura, Mysz, Dzial, Lokalizacja, Uzytkownik, Nr_ewid, Nr_seryjny, Rok_prod, Data_gw_do, Dostawca, Model, TCP_IP_DHCP, TCP_IP_Reczne, Nazwa_sieciowa, Procesor, MB_RAM, muzyka, HDD0, HDD1, HDD2, HDD3) VALUES(NULL, '$kbd', '$mysz', '$_Dzial', '$_Lokalizacja', '$_Uzytkownik', '$_Nr_ewid', '$_Nr_seryjny', '$_Rok_prod', '$_Data_gw_do', '$_Dostawca', '$_Model', '$dhcp', '$_TCP_IP_Reczne', '$_Nazwa_sieciowa', '$_Procesor', '$_MB_RAM', '$muzyka', '$_HDD0', '$_HDD1', '$_HDD2', '$_HDD3')");
	$result = mysql_query($query);
	$idkomp=mysql_insert_id();
	echo "<script language='javascript'>window.location=\"ns_jc.php\"</script>";
	}
} 
?>