<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;

if (!isset($_POST['lp'])) {
    if (!isset($_GET['lp'])) $lp = ""; else $lp = $_GET['lp'];    
}
else $lp = $_POST['lp'];

if (!isset($_POST['state'])) $state = 0; else $state = $_POST['state'];

if (!isset($_POST['login'])) $login = ""; else $login = $_POST['login'];
if (!isset($_POST['pu'])) $pu = 0; else $pu = $_POST['pu'];
if (!isset($_POST['_nazwa'])) $_nazwa = ""; else $_nazwa = $_POST['_nazwa'];
if (!isset($_POST['dzial'])) $dzial = 0; else $dzial = $_POST['dzial'];
if (!isset($_POST['miasto'])) $miasto = 0; else $miasto = $_POST['miasto'];
if (!isset($_POST['woj'])) $woj = ""; else $woj = $_POST['woj'];
if (!isset($_POST['kraj'])) $kraj = ""; else $kraj = $_POST['kraj'];
if (!isset($_POST['tel1'])) $tel1 = ""; else $tel1 = $_POST['tel1'];
if (!isset($_POST['tel2'])) $tel2 = ""; else $tel2 = $_POST['tel2'];
if (!isset($_POST['e'])) $e = ""; else $e = $_POST['e'];
if (!isset($_POST['stanowisko'])) $stanowisko = ""; else $stanowisko = $_POST['stanowisko'];


if($state==0) {
echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>

<center>
<!-- BEGIN Record members -->
<form action='$PHP_SELF' method='post' name='ed_czl'>
  <font class='FormHeaderFont'>User admin</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
";

uprstr($PU,95);

 if (!$db->Open()) $db->Kill();

 if(isset($lp)){
  $q = "SELECT hd_users.lp, login, nazwa, wydzial, email, miasto, woj, kraj, tel1, tel2, PU, stanowisko, hd_wydzial.dzial FROM  hd_users, hd_wydzial WHERE hd_users.wydzial=hd_wydzial.lp AND hd_users.lp='$lp' LIMIT 1";
  } else { 
  echo "<BR><BR><CENTER><H1>Cos si� zepsu�o!</H1></CENTER><BR><BR>";
  exit;
 }

  if (!$db->Query($q)) $db->Kill();
  
    while ($row=$db->Row())
    {
  echo " <tr>
      <td class='FieldCaptionTD'>Login *</td>
      <td class='DataTD'><input class='Input' maxlength='15' name='login' size='15' value='$row->login'></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Rights *00-99</td>
      <td class='DataTD'><input class='Input' maxlength='20' name='pu' value='$row->PU'>

      </td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>Name *</td>
      <td class='DataTD'><input class='Input' maxlength='20' name='_nazwa' value='$row->nazwa'></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD' >Departament</td>
      <td class='DataTD'>   <select class='Select' name='dzial'>
		<option selected value='$row->wydzial'>$row->dzial</option>";
		  $q = "SELECT lp, dzial FROM `hd_wydzial` ORDER BY dzial";

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
    <td class='DataTD' colspan='3'>Error</td>
  </tr>";
 $db->Kill();
}
echo " </select>
</td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Town</td>
      <td class='DataTD'><input class='Input' maxlength='30' name='miasto' size='30' value='$row->miasto'></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>County</td>
      <td class='DataTD'><input class='Input' maxlength='20' name='woj' size='20' value='$row->woj'></td>
    </tr>

    <tr>
      <td class='FieldCaptionTD'>Country</td>
      <td class='DataTD'><input class='Input' maxlength='20' name='kraj' value='$row->kraj'>
      </td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Telefon</td>
      <td class='DataTD'><input class='Input' maxlength='20' name='tel1' value='$row->tel1'></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Mobile</td>
      <td class='DataTD'><input class='Input' maxlength='20' name='tel2' value='$row->tel2'></td>
    </tr>

    <tr>
      <td class='FieldCaptionTD'>Email</td>
      <td class='DataTD'><input class='Input' maxlength='30' name='e' size='50' value='$row->email'></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Position</td>
      <td class='DataTD'><input class='Input' maxlength='30' name='stanowisko' size='50' value='$row->stanowisko'></td>
    </tr>
    <tr>
      <td align='right' colspan='5'>
		<input name='lp' type='hidden' value='$row->lp'>
		<input name='state' type='hidden' value='1'>";
			
} 
echo "
			<input class='Button' name='Update' type='submit' value='$SAVEBTN'>
			<input class='Button'  type='Button' onclick='window.location=\"adm_czl.php\"' value='$LISTBTN'></td>
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

elseif($state==1) {

/*  sprawdzenie uprawnie� do tabeli ladowania ' pakoasortym'
$tabela = "hd_users";
echo "<B>Sprawdzanie uprawnie�</B><BR><BR>";
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
*/
$db =  new CMySQL; 

$op = "edit ";
$tabela = "hd_users";
	if (!$db->Open()) $db->Kill();
	$logi = "INSERT INTO `hd_log` ( `lp`, `tabela`, `temat`, `kiedy`, `user_id`, `infodod`) VALUES( '', '$tabela', '$op', '$dzis $godz', '$id', '$login $nazwa')";
	if (!$db->Query($logi)) $db->Kill();

	$xx = $db->Free();
    // end of logging

	 if (!$db->Open()) $db->Kill();
	 $queryedit = ("UPDATE `hd_users` SET `login` = '$login', `nazwa` = '$_nazwa',`wydzial` = '$dzial',`email` = '$e',`miasto` = '$miasto',`woj` = '$woj',`kraj` = '$kraj',`tel1` = '$tel1', `tel2` = '$tel2', `PU` = '$pu', `stanowisko`='$stanowisko' WHERE `lp` = '$lp' LIMIT 1") ;
	 if (!$db->Query($queryedit)) $db->Kill();

	 echo "<script language='javascript'>window.location=\"adm_czl.php\"</script>";


} //fi state=1

else
{
 echo "<BR><BR><BR>Ostrze�enie!!!!!<BR><BR><BR>",
	 "Ktos z komputera $REMOTE_ADDR probuje sie wlamac<BR>";
} //else state
//} //elseif  state
?>