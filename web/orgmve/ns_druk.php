<?php
//if(!isset($id) && !isset($pw))
//{header("Location: index.html");exit;}

include_once("./header.php");
$tytul='Nowa drukarka';

if(!isset($state))
{
echo "	


<center>
<form action='$PHP_SELF' method='get' name='n_art'>
  <font class='FormHeaderFont'>$tytul</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
    <tbody>

<tr><td  colspan='2'>
<table border='0' cellpadding='3' cellspacing='1'>
<tr>
	    <td class='FieldCaptionTD'>Dostawca</td>
        <td class='DataTD'><INPUT class='Input' NAME='_Dostawca'></td>
		<td class='FieldCaptionTD'>Model</td>
        <td class='DataTD'><INPUT class='Input' NAME='_Model'></td>
</tr>
</TD></tr>
</table></tr>
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
        <td align='right' colspan='2'>
			<input  name='state' type='hidden' value='1'>
			<input  name='dataogl' type='hidden' value='$dzis'>
			<input class='Button' name='Nowy' type='submit' value='Zapisz'>
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
if(isset($Nowy) and $Nowy=='Zapisz')
    {  
    if (!$db->Open())$db->Kill();
	//id_mon  Nr_seryjny  MOdel  Nr_ewidencyjny  Producent  Rok_prod 
    $query =("INSERT INTO drukarka (id_dr, Nr_ewidencyjny, Nr_seryjny, Rok_prod, Producent, Model, id_zest) VALUES(NULL, '$_Nr_ewid', '$_Nr_seryjny', '$_Rok_prod', '$_Dostawca', '$_Model', 1)");
	$result = mysql_query($query);
	$iddr=mysql_insert_id();
	echo "<script language='javascript'>window.location=\"ns_druk.php\"</script>";
	//header("Location: adm_art.php");
	}
} 
?>