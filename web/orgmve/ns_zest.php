<?php
//if(!isset($id) && !isset($pw))
//{header("Location: index.html");exit;}

include_once("./header.php");
include("./languages/$LANGUAGE.php");

if(!isset($state))
{
echo "<center>
<form action='$PHP_SELF' method='get' name='n_art'>
  <font class='FormHeaderFont'>$tytulnzest</font>
<BR>
<CENTER><B>$MAINUNITNAME0</B> </CENTER> 

<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
    <tbody>
<tr><td  colspan='2'>
<table border='0' cellpadding='3' cellspacing='1'>
<tr>
        <td class='FieldCaptionTD'>$kbd</td>
        <td class='DataTD'><INPUT TYPE='checkbox' NAME='_Klawiatura' ></td>
	    <td class='FieldCaptionTD'>$mouse</td>
        <td class='DataTD'><INPUT TYPE='checkbox' NAME='_Mysz' ></td>
		<td class='FieldCaptionTD'>$tcd</td>
        <td class='DataTD'><INPUT TYPE='checkbox' NAME='_TCP_IP_DHCP' ></td>
		<td class='FieldCaptionTD'>$tc</td>
        <td class='DataTD'><INPUT TYPE='input' maxlength='20' NAME='_TCP_IP_Reczne' value='$ipval'></td>	
</tr>
</TD></tr>
</table>
</tr>
<tr><td  colspan='2'>
<table border='0' cellpadding='3' cellspacing='1'>
<tr>
        <td class='FieldCaptionTD'>$hd0</td>
        <td class='DataTD'><INPUT TYPE='INPUT' size='6' NAME='_HDD0' onChange=\"this.value=this.value.toUpperCase()\">&nbsp;MB</td>
	    <td class='FieldCaptionTD'>$hd1</td>
        <td class='DataTD'><INPUT TYPE='INPUT' size='6' NAME='_HDD1' onChange=\"this.value=this.value.toUpperCase()\">&nbsp;MB</td>
		<td class='FieldCaptionTD'>$hd2</td>
        <td class='DataTD'><INPUT TYPE='INPUT' size='6' NAME='_HDD2' onChange=\"this.value=this.value.toUpperCase()\">&nbsp;MB</td>
		<td class='FieldCaptionTD'>$hd3</td>
        <td class='DataTD'><INPUT TYPE='INPUT' size='6' NAME='HDD3' onChange=\"this.value=this.value.toUpperCase()\">&nbsp;MB</td>	
</tr>
</TD></tr>
</table></tr>
<tr><td  colspan='2'>
<table border='0' cellpadding='3' cellspacing='1'>
<tr>
	    <td class='FieldCaptionTD'>$ram</td>
        <td class='DataTD'><INPUT TYPE='INPUT' size='6' NAME='_MB_RAM'>&nbsp;MB</td>
	    <td class='FieldCaptionTD'>$music</td>
        <td class='DataTD'><INPUT TYPE='checkbox' NAME='_muzyka'></td>
		<td class='FieldCaptionTD'>$cpu0</td>
        <td class='DataTD'><INPUT TYPE='INPUT' size='10'maxlenght='50' NAME='_Procesor' onChange=\"this.value=this.value.toUpperCase()\">&nbsp;opis</td>
</tr>
</TD></tr>
</table></tr>
<tr><td  colspan='2'>
<table border='0' cellpadding='3' cellspacing='1'>
<tr>
	    <td class='FieldCaptionTD'>$suplayer</td>
        <td class='DataTD'><INPUT TYPE='INPUT' NAME='_Dostawca' onChange=\"this.value=this.value.toUpperCase()\"></td>
		<td class='FieldCaptionTD'>$MODEL</td>
        <td class='DataTD'><INPUT TYPE='INPUT' NAME='_Model' onChange=\"this.value=this.value.toUpperCase()\"></td>
</tr>
</TD></tr>
</table></tr>
	    <tr>
      <td class='FieldCaptionTD' >$DEPART</td>
      <td class='DataTD'>   <select class='Select' name='_Dzial'>
		<option selected value=''></option>";
		  $q = "SELECT lp, dzial FROM `hd_wydzial` order by dzial";

//	$db = new CMySQL;
     if (!$db->Open()) $db->Kill();
  if ($db->Query($q)) 
  {
    while ($row=$db->Row())
    {

          echo "<option value='$row->lp'>$row->dzial</option>";
    }
	} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='3'>SQL Error in depat.</td>
  </tr>";
 $db->Kill();
}
echo " </select>
</td>
    </tr>


      <tr>
        <td class='FieldCaptionTD'>$LOCAL</td>
        <td class='DataTD'><INPUT TYPE='input' class='Input' size='70'  maxlength='70' name='_Lokalizacja' onChange=\"this.value=this.value.toUpperCase()\"></td>
      </tr>


		  	    <tr>
      <td class='FieldCaptionTD' >$USERFULL</td>
      <td class='DataTD'>   <select class='Select' name='_Uzytkownik'>
		<option selected value=''></option>";
		  $q = "SELECT lp, nazwa FROM hd_users order by nazwa";

//	$db = new CMySQL;
     if (!$db->Open()) $db->Kill();
  if ($db->Query($q)) 
  {
    while ($row=$db->Row())
    {

          echo "<option value='$row->lp'>$row->nazwa</option>";
    }
	} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='3'>SQL Error in Users</td>
  </tr>";
 $db->Kill();
}
echo " </select>
</td>
    </tr>

	  <tr>
        <td class='FieldCaptionTD'>$NOCOMP</td>
        <td class='DataTD'><INPUT TYPE='input' class='Input' size='50' maxlength='50' name='_Nr_ewid' ></td>
      </tr>
      <tr>
        <td class='FieldCaptionTD'>$SN0</td>
        <td class='DataTD'><input class='Input' size='50' maxlength='50' name='_Nr_seryjny'  value=''></td>
      </tr>
      <tr>
        <td class='FieldCaptionTD'>$YEARPJC</td>
        <td class='DataTD'><input class='Input' size='4' maxlength='4' name='_Rok_prod'  value=''></td>
      </tr>
      <tr>
        <td class='FieldCaptionTD'>$NETNAME</td>
        <td class='DataTD'><input class='Input' size='50' maxlength='50' name='_Nazwa_sieciowa'  value=''></td>
      </tr>
      <tr>
        <td class='FieldCaptionTD'>$DATWAR</td>
        <td class='DataTD'><input class='Input' maxlength='10' name='_Data_gw_do'  value=''></td>
      </tr>


<tr><td  colspan='2'>
<CENTER><B>$MONITORNAME0</B> </CENTER>

<table border='0' cellpadding='3' cellspacing='1'>
<tr>
	    <td class='FieldCaptionTD'>$suplayer</td>
        <td class='DataTD'><INPUT class='Input' NAME='m_Dostawca' onChange=\"this.value=this.value.toUpperCase()\"></td>
		<td class='FieldCaptionTD'>$MODEL</td>
        <td class='DataTD'><INPUT class='Input' NAME='m_Model' onChange=\"this.value=this.value.toUpperCase()\"></td>
</tr>
</TD></tr>
</table></tr>
  <tr>
        <td class='FieldCaptionTD'>$NOCOMP</td>
        <td class='DataTD'><INPUT TYPE='input' class='Input' size='50' maxlength='50' name='m_Nr_ewid' ></td>
      </tr>
      <tr>
        <td class='FieldCaptionTD'>$SN0</td>
        <td class='DataTD'><input class='Input' size='50' maxlength='50' name='m_Nr_seryjny'  value=''></td>
      </tr>
      <tr>
        <td class='FieldCaptionTD'>$YEARPJC</td>
        <td class='DataTD'><input class='Input' size='4' maxlength='4' name='m_Rok_prod'  value=''></td>
      </tr>

<tr><td  colspan='2'>
<CENTER><B>$PRINTERNAME0</B> </CENTER>
	
<table border='0' cellpadding='3' cellspacing='1'>
<tr>
	    <td class='FieldCaptionTD'>$suplayer</td>
        <td class='DataTD'><INPUT class='Input' NAME='d_Dostawca' onChange=\"this.value=this.value.toUpperCase()\"></td>
		<td class='FieldCaptionTD'>$MODEL</td>
        <td class='DataTD'><INPUT class='Input' NAME='d_Model' onChange=\"this.value=this.value.toUpperCase()\"></td>
</tr>
</TD></tr>
</table></tr>
  <tr>
        <td class='FieldCaptionTD'>$NOCOMP</td>
        <td class='DataTD'><INPUT TYPE='input' class='Input' size='50' maxlength='50' name='d_Nr_ewid' ></td>
      </tr>
      <tr>
        <td class='FieldCaptionTD'>$SN0</td>
        <td class='DataTD'><input class='Input' size='50' maxlength='50' name='d_Nr_seryjny'  value=''></td>
      </tr>
      <tr>
        <td class='FieldCaptionTD'>$YEARPJC</td>
        <td class='DataTD'><input class='Input' size='4' maxlength='4' name='d_Rok_prod'  value=''></td>
      </tr>
<tr>
        <td align='right' colspan='2'>
			<input  name='state' type='hidden' value='1'>
			<input  name='dataogl' type='hidden' value='$dzis'>
			<input class='Button' name='Nowy' type='submit' value='$SAVEBTN'>
			<input class='Button'  type='Button' onclick='javascript:history.back()' value='$BACKBTN'></td>
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

if(isset($Nowy) and $Nowy==strval("$SAVEBTN"))
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
    $query1 =("INSERT INTO hd_drukarka (id_dr, Nr_ewidencyjny, Nr_seryjny, Rok_prod, Producent, Model, id_zest) 
				VALUES(NULL, '$d_Nr_ewid', '$d_Nr_seryjny', '$d_Rok_prod', '$d_Dostawca', '$d_Model', 0)");
	$result1 = mysql_query($query1);
	$iddr=mysql_insert_id();

	if (!$db->Open())$db->Kill();
	$query2 =("INSERT INTO hd_monitor (id_mon, Nr_ewidencyjny, Nr_seryjny, Rok_prod, Producent, Model, id_zest) 
				VALUES(NULL, '$m_Nr_ewid', '$m_Nr_seryjny', '$m_Rok_prod', '$m_Dostawca', '$m_Model', 0)");
	$result2 = mysql_query($query2);
	$idmon=mysql_insert_id();

	if (!$db->Open())$db->Kill();
    $query3 =("INSERT INTO hd_komp (lp, Klawiatura, Mysz, Dzial, Lokalizacja, Uzytkownik, Nr_ewid, Nr_seryjny, Rok_prod, Data_gw_do, Dostawca, Model, TCP_IP_DHCP, TCP_IP_Reczne, Nazwa_sieciowa, Procesor, MB_RAM, muzyka, HDD0, HDD1, HDD2, HDD3, id_zest) VALUES(NULL, '$kbd', '$mysz', '$_Dzial', '$_Lokalizacja', '$_Uzytkownik', '$_Nr_ewid', '$_Nr_seryjny', '$_Rok_prod', '$_Data_gw_do', '$_Dostawca', '$_Model', '$dhcp', '$_TCP_IP_Reczne', '$_Nazwa_sieciowa', '$_Procesor', '$_MB_RAM', '$muzyka', '$_HDD0', '$_HDD1', '$_HDD2', '$_HDD3', 0)");
	$result3 = mysql_query($query3);

	$idkomp=mysql_insert_id();

	if (!$db->Open())$db->Kill();
	$query4 =("INSERT INTO hd_zestaw (Identyfikator, id_komp, id_dr, id_mon ) VALUES(NULL, '$idkomp', '$iddr', '$idmon')");
	$result4 = mysql_query($query4);
	$idz=mysql_insert_id();

	echo "<script language='javascript'>window.location=\"programy.php?idzest=$idz\"</script>";
	}
} 
?>