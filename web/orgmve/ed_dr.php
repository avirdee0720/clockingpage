<?php
//if(!isset($id) && !isset($pw))
//{header("Location: index.html");exit;}

include_once("./header.php");
$tytul='<BR><BR>Edycja monitora<BR>';
$idzestawu=$idzest;

if(!isset($state))
{

 if (!$db->Open()) $db->Kill();

 if(isset($iddr)){
  $q = "SELECT id_dr, Nr_seryjny, MOdel, Nr_ewidencyjny, Producent, Rok_prod, id_zest FROM hd_drukarka  WHERE id_dr='$iddr' LIMIT 1";
  } else { 
  echo "<BR><BR><CENTER><H1>Cos siê zepsu³o!</H1></CENTER><BR><BR>";
  exit;
 }

  if (!$db->Query($q)) $db->Kill();
  
    while ($row=$db->Row())
    {
		echo "	
<center>
<form action='$PHP_SELF' method='get' name='n_art'>
  <font class='FormHeaderFont'>$tytul</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
    <tbody>
<INPUT type='hidden' NAME='iddr' value='$row->id_dr'>

<tr><td  colspan='2'>
<table border='0' cellpadding='3' cellspacing='1'>
<tr>
	    <td class='FieldCaptionTD'>Dostawca</td>
        <td class='DataTD'><INPUT class='Input' size='50' NAME='_Dostawca' value='$row->Producent' onChange=\"this.value=this.value.toUpperCase()\"></td>
		<td class='FieldCaptionTD'>Model</td>
        <td class='DataTD'><INPUT class='Input' size='50'  NAME='_Model' value='$row->MOdel' onChange=\"this.value=this.value.toUpperCase()\"></td>
</tr>
</TD></tr>
</table></tr>
  <tr>
        <td class='FieldCaptionTD'> Nr_ewid</td>
        <td class='DataTD'><INPUT TYPE='input' class='Input' size='50' maxlength='50' name='_Nr_ewid'  value='$row->Nr_ewidencyjny' onChange=\"this.value=this.value.toUpperCase()\"></td>
      </tr>
      <tr>
        <td class='FieldCaptionTD'>Nr_seryjny</td>
        <td class='DataTD'><input class='Input' size='50' maxlength='50' name='_Nr_seryjny' value='$row->Nr_seryjny' onChange=\"this.value=this.value.toUpperCase()\"></td>
      </tr>
      <tr>
        <td class='FieldCaptionTD'>Rok_prod</td>
        <td class='DataTD'><input class='Input' size='4' maxlength='4' name='_Rok_prod'  value='$row->Rok_prod'  onChange=\"this.value=this.value.toUpperCase()\"></td>
      </tr>
<tr>
        <td align='right' colspan='2'>
			<input  name='state' type='hidden' value='1'>
			<input  name='dataogl' type='hidden' value='$dzis'>
			<input  name='idz' type='hidden' value='$idzestawu'>
			<input class='Button' name='Nowy' type='submit' value='Zapisz'>
		    <INPUT class='Button' TYPE=SUBMIT name='zmk' value=' Wracaj '>	</td>
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

if(isset($zmk))
{ echo "<script language='javascript'>window.location=\"zestaw1.php?idzest=$idz\"</script>";
}

if(isset($Nowy) and $Nowy=='Zapisz')
    {  

	if (!$db->Open())$db->Kill();
    $query =("UPDATE hd_drukarka SET  Nr_ewidencyjny='$_Nr_ewid', Nr_seryjny='$_Nr_seryjny', 		  Rok_prod='$_Rok_prod', Producent='$_Dostawca', MOdel='$_Model' WHERE id_dr='$iddr' LIMIT 1 ");
	$result = mysql_query($query);
	$idkomp=mysql_insert_id();
	echo "<script language='javascript'>window.location=\"ed_dr.php?iddr=$iddr&idzest=$idz\"</script>";
	}
} 
?>