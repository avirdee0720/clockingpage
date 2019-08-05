<?php
//if(!isset($id) && !isset($pw))
//{header("Location: index.html");exit;}

include_once("./header.php");
include("./languages/$LANGUAGE.php");
$idzestawu=$idzest;

if(!isset($state))
{

 if (!$db->Open()) $db->Kill();

 if(isset($idkomp)){
  $q = "SELECT id, date1, intime, outtime, no, ipadr, checked FROM `inout` WHERE id LIMIT 1";
  } else { 
  echo "<BR><BR><CENTER><H1>SQL Error</H1></CENTER><BR><BR>";
  exit;
 }

  if (!$db->Query($q)) $db->Kill();
  
    while ($row=$db->Row())
    {
echo "<center>
<form action='$PHP_SELF' method='get' name='xx'>
  <font class='FormHeaderFont'>$tytulejc <B>$idzestawu</B></font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
    <tbody>
<tr><td  colspan='2'>
<table border='0' cellpadding='3' cellspacing='1'>
<tr>
        <td class='FieldCaptionTD'>$kbd</td>
        <td class='DataTD'>";

if ($row->Klawiatura=="1"){ $kbstaus="checked"; }
else{ $kbstaus=""; }	
echo "<INPUT TYPE='checkbox' NAME='_Klawiatura' $kbstaus>";

echo "</td>
	    <td class='FieldCaptionTD'>$mouse</td>
        <td class='DataTD'>";

if ($row->Mysz=="1"){ $mstaus="checked"; }
else{ $mstaus=""; }	
echo "<INPUT TYPE='checkbox' NAME='_Mysz' $mstaus>";

echo "</td>
		<td class='FieldCaptionTD'>$tcd</td>
        <td class='DataTD'>";

if ($row->Mysz=="1"){ $tstaus="checked"; }
else{ $tmstaus=""; }	
echo "<INPUT TYPE='checkbox' NAME='_TCP_IP_DHCP' $tstaus>";

echo "
			
		</td>
		<td class='FieldCaptionTD'>$tc</td>
        <td class='DataTD'><INPUT TYPE='input' maxlength='20' NAME='_TCP_IP_Reczne' VALUE='$row->TCP_IP_Reczne'></td>	
</tr>
</TD></tr>
</table>
</tr>
<tr><td  colspan='2'>
<table border='0' cellpadding='3' cellspacing='1'>
<tr>
        <td class='FieldCaptionTD'>$hd0</td>
        <td class='DataTD'><INPUT TYPE='INPUT' size='6' NAME='_HDD0' VALUE='$row->HDD0' onChange=\"this.value=this.value.toUpperCase()\">&nbsp;MB</td>
	    <td class='FieldCaptionTD'>$hd1</td>
        <td class='DataTD'><INPUT TYPE='INPUT' size='6' NAME='_HDD1' VALUE='$row->HDD1' onChange=\"this.value=this.value.toUpperCase()\">&nbsp;MB</td>
		<td class='FieldCaptionTD'>$hd2</td>
        <td class='DataTD'><INPUT TYPE='INPUT' size='6' NAME='_HDD2' VALUE='$row->HDD2' onChange=\"this.value=this.value.toUpperCase()\">&nbsp;MB</td>
		<td class='FieldCaptionTD'>$hd3</td>
        <td class='DataTD'><INPUT TYPE='INPUT' size='6' NAME='_HDD3' VALUE='$row->HDD3' onChange=\"this.value=this.value.toUpperCase()\">&nbsp;MB</td>	
</tr>
</TD></tr>
</table></tr>
<tr><td  colspan='2'>
<table border='0' cellpadding='3' cellspacing='1'>
<tr>
	    <td class='FieldCaptionTD'>$ram</td>
        <td class='DataTD'><INPUT TYPE='INPUT' size='6' NAME='_MB_RAM' VALUE='$row->MB_RAM'>&nbsp;MB</td>
	    <td class='FieldCaptionTD'>$music</td>
        <td class='DataTD'>";

if ($row->Mysz=="1"){ $muzastaus="checked"; }
else{ $muzastaus=""; }	
echo "<INPUT TYPE='checkbox' NAME='_Muzyka' $muzastaus>";
echo "</td>
		<td class='FieldCaptionTD'>$cpu0</td>
        <td class='DataTD'><INPUT TYPE='INPUT' size='10'maxlenght='50' NAME='_Procesor' VALUE='$row->Procesor' onChange=\"this.value=this.value.toUpperCase()\">&nbsp;opis</td>
</tr>
</TD></tr>
</table></tr>
<tr><td  colspan='2'>
<table border='0' cellpadding='3' cellspacing='1'>
<tr>
	    <td class='FieldCaptionTD'>$suplayer</td>
        <td class='DataTD'><INPUT TYPE='INPUT' NAME='_Dostawca' VALUE='$row->Dostawca' onChange=\"this.value=this.value.toUpperCase()\"></td>
		<td class='FieldCaptionTD'>$MODEL</td>
        <td class='DataTD'><INPUT TYPE='INPUT' NAME='_Model' VALUE='$row->Model'></td>
</tr>
</TD></tr>
</table></tr>


<tr>
      <td class='FieldCaptionTD' >$DEPART</td>
      <td class='DataTD'>   <select class='Select' name='_Dzial'>
		<option selected value='$row->Dzial'>$row->dzial</option>";
		  $q = "SELECT lp, dzial FROM `hd_wydzial` order by dzial";

//	$db = new CMySQL;
     if (!$db->Open()) $db->Kill();
  if ($db->Query($q)) 
  {
    while ($r=$db->Row())
    {

          echo "<option value='$r->lp'>$r->dzial</option>";
    }
	} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='3'>SQL Error</td>
  </tr>";
 $db->Kill();
}
echo " </select>
</td>
    </tr>



      <tr>
        <td class='FieldCaptionTD'>$LOCAL</td>
        <td class='DataTD'><INPUT TYPE='input' class='Input' size='70'  maxlength='70' name='_Lokalizacja' VALUE='$row->Lokalizacja'></td>
      </tr>

		  		  	    <tr>
      <td class='FieldCaptionTD' >$USERFULL</td>
      <td class='DataTD'>   <select class='Select' name='_Uzytkownik'>
		<option selected value='$row->Uzytkownik'>$row->nazwa</option>";
		  $q = "SELECT lp, nazwa FROM hd_users order by nazwa";

//	$db = new CMySQL;
     if (!$db->Open()) $db->Kill();
  if ($db->Query($q)) 
  {
    while ($r1=$db->Row())
    {

          echo "<option value='$r1->lp'>$r1->nazwa</option>";
    }
	} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='3'>SQL Error</td>
  </tr>";
 $db->Kill();
}
echo " </select>
</td>
    </tr>

	  <tr>
        <td class='FieldCaptionTD'>$NOCOMP</td>
        <td class='DataTD'><INPUT TYPE='input' class='Input' size='50' maxlength='50' name='_Nr_ewid' VALUE='$row->Nr_ewid'></td>
      </tr>
      <tr>
        <td class='FieldCaptionTD'>$SN0</td>
        <td class='DataTD'><input class='Input' size='50' maxlength='50' name='_Nr_seryjny'  VALUE='$row->Nr_seryjny'></td>
      </tr>
      <tr>
        <td class='FieldCaptionTD'>$YEARPJC</td>
        <td class='DataTD'><input class='Input' size='4' maxlength='4' name='_Rok_prod'  VALUE='$row->Rok_prod'></td>
      </tr>
      <tr>
        <td class='FieldCaptionTD'>$NETNAME</td>
        <td class='DataTD'><input class='Input' size='50' maxlength='50' name='_Nazwa_sieciowa' VALUE='$row->Nazwa_sieciowa'></td>
      </tr>
      <tr>
        <td class='FieldCaptionTD'>$DATWAR</td>
        <td class='DataTD'><input class='Input' maxlength='10' name='_Data_gw_do' VALUE='$row->Data_gw_do'></td>
      </tr>
<tr>
        <td align='right' colspan='2'>
			<input  name='lp' type='hidden' value='$row->lp'>
			<input  name='idz' type='hidden' value='$idzestawu'>
			<input  name='state' type='hidden' value='1'>
			<input  name='dataogl' type='hidden' value='$dzis'>
			<input class='Button' name='saveit' type='submit' value='$SAVEBTN'>
		    <INPUT class='Button' TYPE=SUBMIT name='zmk' value='$BACKBTN'>		
		</td>
      </tr>
    </form>
  </tbody>
</table>
</center>
<BR>
</td></tr>
</table>";
}
include_once("./footer.php");
}
elseif($state==1)
{
include("./languages/$LANGUAGE.php");

if(isset($zmk))
{ 
	echo "<script language='javascript'>window.location=\"zestaw1.php?idzest=$idz\"</script>";
}

if(isset($saveit) and $saveit==strval("$SAVEBTN"))
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
    $query =("UPDATE hd_komp SET Klawiatura='$kbd', Mysz='$mysz', Dzial='$_Dzial', Lokalizacja='$_Lokalizacja', Uzytkownik='$_Uzytkownik', Nr_ewid='$_Nr_ewid', Nr_seryjny='$_Nr_seryjny', Rok_prod='$_Rok_prod', Data_gw_do='$_Data_gw_do', Dostawca='$_Dostawca', Model='$_Model', TCP_IP_DHCP='$dhcp', TCP_IP_Reczne='$_TCP_IP_Reczne', Nazwa_sieciowa='$_Nazwa_sieciowa', Procesor='$_Procesor', MB_RAM='$_MB_RAM', muzyka='$muzyka', HDD0='$_HDD0', HDD1='$_HDD1', HDD2='$_HDD2', HDD3='$_HDD3' WHERE lp='$lp' LIMIT 1 ");
	$result = mysql_query($query);
	$idkomp=mysql_insert_id();
	echo "<script language='javascript'>window.location=\"ed_jc.php?idkomp=$lp&idzest=$idz\"</script>";
	}
} 
?>