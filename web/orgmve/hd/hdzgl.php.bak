<?php
include("../inc/mysql.inc.php");
//$naglowek='naglowek.php';
$stopka='hdstopka.php';
//include ($naglowek);
$data=date("Y-m-d");
$teraz=date("H:i");
$adres  = 'pz@mveshops.co.uk';

$baza = new CMySQL;

if(!isset($state))
{

print "  <CENTER>
<table border=0 cellspacing=0 cellpadding=2  style='background:#EFEFEF' width=95%>
   <tr><td valign=top>
 <FORM METHOD=post ACTION='hdzgl.php'>

	<SMALL>Your name:</SMALL>
    </TD><td><INPUT SIZE='40' TYPE='text' NAME='kto' VALUE=''> <SMALL>Write or chose from the list.</SMALL>
   <select class='Select' name='_Uzytkownik' onChange=\"kto.value = this.value \">
		<option selected value=''></option>";
		  $q = "SELECT lp, nazwa FROM hd_users order by nazwa";

	$db = new CMySQL;
     if (!$db->Open()) $db->Kill();
  if ($db->Query($q)) 
  {
    while ($row=$db->Row())
    {

          echo "<option value='$row->nazwa'>$row->nazwa</option>";
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

    <tr> <td>Category:</td><td>
    <input type='radio' checked name='kategoria' VALUE='Sprzet'>Hardware,
    <input type='radio'  name='kategoria' VALUE='aCad'>Network,
    <input type='radio'  name='kategoria' VALUE='Programy inne'>Programs,
    <input type='radio'  name='kategoria' VALUE='OS'>Windows,
    <input type='radio'  name='kategoria' VALUE='Siec-Serwer'>Server
    </td> </tr>

    <tr><td>Date:</td><td><INpUT NAME='data' SIZE='10' TYPE='text' VALUE='$data'>
    &nbsp;&nbsp;Time:<INPUT NAME='czas' SIZE='10' TYPE='text' VALUE='$teraz'>
    &nbsp;&nbsp;Weight:<INPUT NAME='waga' SIZE='1' TYPE='text' VALUE='9'>
    </td></tr>

    <tr><td><small>Desctription:</small>
		</td><td><texTAREA COLS='70' NAME='opis' ROWS='10'></texTAREA></td></tr>
    <tr><td>Departament:</td><td class='DataTD'>   <select class='Select' name='_Dzial'>
		<option selected value=''></option>";
		  $q = "SELECT lp, dzial FROM `hd_wydzial` order by dzial";

//	$db = new CMySQL;
     if (!$db->Open()) $db->Kill();
  if ($db->Query($q)) 
  {
    while ($row=$db->Row())
    {

          echo "<option value='$row->dzial'>$row->dzial</option>";
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
	
	<tr><td>
	   <INpUT NAME='state' TYPE='hidden' VALUE='1'>
	   <div align='right'><INPUT TYPE='submit' value='Send'></div></td>
    <td><div align='left'><input type='reset' value='Cancel'></div>
		</td></tr>
    </TD></TH></TABLE></CENTER>
   </FORM>";
		    
//include ($stopka);

}
elseif($state==1)
{


    if (!$baza->Open()) $baza->Kill();
        $pyt = ("INSERT INTO hd_zgloszenie (lp,kto,kategoria, data, czas, waga, opis, lokalizacja, stan) VALUES (NULL,'$kto','$kategoria','$data','$czas','$waga', '$opis', '$_Dzial', '0')") ;
    if (!$baza->Query($pyt))  $baza->Kill();
 //$result = mysql_query($pyt);
   print(" <table ALIGN='center' border=0 cellspacing=1 cellpadding=0 width=100%>
    <th>
         <i><div align='left'>HD Message</div></i>
    </th>
    <tr>
    <td valign=top style='background:#EFEFEF'>
     <CENTER>");
	global $kto, $kategoria, $opis, $data, $czas, $adres;
    $eTemat       = "Help Desk - category: $kategoria, z: $_Dzial";
    $trescListu  = "\n Message from: ";
    $trescListu .= $kto;
    $trescListu .= " ";
    $trescListu .= "day: ";
    $trescListu .= $data;
    $trescListu .= ", ";
    $trescListu .= $czas;
    $trescListu .= "<BR> Message description: ";
    $trescListu .= $opis;
    mail($adres, $eTemat, $trescListu);

    echo "<p><FONT SIZE=\"4\" COLOR=\"#FF0000\"><B>$eTemat</B></FONT><br>
	Your error message has been sent  to IT SYSADM.<br>
		<table border=0>
    <tr>
		<Td valign=top>Nazwisko i imie: </Td>
		<Td><B>$kto</B><br></td></Tr>
    <tr>
		<Td valign=top>Tre¶æ zg³oszenia: </Td>
	    <Td><B>$trescListu</B><br></td></Tr>
    <tr>
		<Td valign=top>&nbsp;</Td>
	    <Td>&nbsp;</td>
	</Tr>
	<tr>
		<Td valign=top><a HREF=javascript:history.back()><B>BACK</B></A>.</Td>
	    <Td valign=top>\if you think you have to samethink more to say.
		Click \"BACK\", write it, and then send it again.</td>
	</Tr>
    </TABLE>
      </CENTER>
    </td>
    </tr>
    </table>
 ";

} //elseif 
?>