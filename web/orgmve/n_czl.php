<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$tytul='';
//include("./inc/uprawnienia.php");
uprstr($PU,99);

if (!isset($_POST['state'])) $state = 0;
else $state = $_POST['state'];

if (!isset($_POST['login'])) $login = ""; else $login = $_POST['login'];
if (!isset($_POST['passwd'])) $passwd = ""; else $passwd = $_POST['passwd'];
if (!isset($_POST['pu'])) $pu = 0; else $pu = $_POST['pu'];
if (!isset($_POST['_nazwa'])) $_nazwa = ""; else $_nazwa = $_POST['_nazwa'];
if (!isset($_POST['dzial'])) $dzial = 0; else $dzial = $_POST['dzial'];
if (!isset($_POST['miasto'])) $miasto = 0; else $miasto = $_POST['miasto'];
if (!isset($_POST['woj'])) $woj = ""; else $woj = $_POST['woj'];
if (!isset($_POST['kod'])) $kod = ""; else $kod = $_POST['kod'];
if (!isset($_POST['kraj'])) $kraj = ""; else $kraj = $_POST['kraj'];
if (!isset($_POST['tel1'])) $tel1 = ""; else $tel1 = $_POST['tel1'];
if (!isset($_POST['tel2'])) $tel2 = ""; else $tel2 = $_POST['tel2'];
if (!isset($_POST['em'])) $em = ""; else $em = $_POST['em'];
if (!isset($_POST['stanowisko'])) $stanowisko = ""; else $stanowisko = $_POST['stanowisko'];	

if($state==0)
{
	echo "<table width='100%' border=0><tr><td>

<center>
<!-- BEGIN Record officers -->
<form action='$PHP_SELF' method='post' name='n_czl'>
  <font class='FormHeaderFont'>Add user</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
    <tr>
      <td class='FieldCaptionTD'>Login *</td>
      <td class='DataTD'><input class='Input' maxlength='15' name='login' size='15' value=''></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Password *</td>
      <td class='DataTD'><input class='Input' maxlength='15' name='passwd' size='15' type='password' value=''></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Rights *00-99</td>
      <td class='DataTD'><input class='Input' maxlength='20' name='pu' value=''>

      </td>
    </tr>

    <tr>  
      <td class='FieldCaptionTD'>Name *</td>
      <td class='DataTD'><input class='Input' maxlength='20' name='_nazwa' value=''></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD' >Departament</td>
      <td class='DataTD'>   <select class='Select' name='dzial'>
		<option selected value=''></option>";
		  $q = "SELECT lp, dzial FROM `hd_wydzial` ";

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
    <td class='DataTD' colspan='3'>error</td>
  </tr>";
 $db->Kill();
}
echo " </select>
</td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Town</td>
      <td class='DataTD'><input class='Input' maxlength='30' name='miasto' size='30' value=''></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>County</td>
      <td class='DataTD'><input class='Input' maxlength='20' name='woj' size='20' value=''></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Post code</td>
      <td class='DataTD'><input class='Input' maxlength='10' name='kod' size='10' value=''></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Country</td>
      <td class='DataTD'><input class='Input' maxlength='20' name='kraj' value='UK'>

      </td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Telefon</td>
      <td class='DataTD'><input class='Input' maxlength='20' name='tel1' value=''></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Miobile</td>
      <td class='DataTD'><input class='Input' maxlength='20' name='tel2' value=''></td>
    </tr>

    <tr>
      <td class='FieldCaptionTD'>Email</td>
      <td class='DataTD'><input class='Input' maxlength='30' name='em' size='50' value=''></td>
    </tr>
	<tr>
      <td class='FieldCaptionTD'>Position</td>
      <td class='DataTD'><input class='Input' maxlength='30' name='stanowisko' size='50' value=''></td>
    </tr>
    <tr>
      <td align='right' colspan='2'>
			<input  name='state' type='hidden' value='1'>
			<input class='Button' name='Nowy' type='submit' value='$SAVEBTN'>
			<input class='Button'  type='Button' onclick='javascript:history.back()' value='$BACKBTN'>
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
//if(isset($Nowy) and $Nowy=='$SAVEBTN')
// {  //$kto=$id." ".$dzis." ".$godz;
//$passwd="x";
$passwd1=md5("$passwd");
    $db1 = new CMySQL;
    if (!$db1->Open())$db1->Kill();
    $query =("INSERT INTO `hd_users` ( `lp` , `login` , `nazwa` , `wydzial` , `adm` , `passwd` , `email` , `miasto` , `woj` , `kraj` , `tel1` , `tel2` , `security_level_id` , `PU`, `stanowisko` ) VALUES ('', '$login', '$_nazwa', '$dzial', '0', '$passwd1' , '$em', '$miasto', '$woj', '$kraj', '$tel1', '$tel2', '0', '$pu', '$stanowisko')");
	if (!$db1->Query($query)) $db1->Kill();

	echo "<script language='javascript'>window.location=\"adm_czl.php\"</script>";
//	}
} 
?>