<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
uprstr($PU,90);

$tytul='Password restet';

if (!isset($_POST['lp'])) {
    if (!isset($_GET['lp'])) $lp = ""; else $lp = $_GET['lp'];    
}
else $lp = $_POST['lp'];

if (!isset($_POST['state'])) $state = 0;
else $state = $_POST['state'];

if (!isset($_POST['_pass1'])) $_pass1 = ""; else $_pass1 = $_POST['_pass1'];
if (!isset($_POST['_pass2'])) $_pass2 = ""; else $_pass2 = $_POST['_pass2'];

// uprstr($PU,98);

if($state==0)
{
echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>

<center>
<!-- BEGIN Record members -->
<form action='$PHP_SELF' method='post' name='ed_czl'>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>";



 if (!$db->Open()) $db->Kill();

 if($lp != ""){
  $q = "SELECT `lp`, `login`, `nazwa`, `passwd` FROM  `hd_users` WHERE `lp`='$lp' LIMIT 1";
  } else { 
  echo "<BR><BR><CENTER><H1>Cos si� zepsu�o!</H1></CENTER><BR><BR>";
  exit;
 }
  if (!$db->Query($q)) $db->Kill();
  
    while ($row=$db->Row())
    {
  echo " <tr>
      <td class='FieldCaptionTD'>$DSNAZWA</td>
      <td class='DataTD'><B>$row->nazwa</B></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$LOGNAME0</td>
      <td class='DataTD'><B>$row->login</B></td>
    </tr>
      <td class='FieldCaptionTD'>Password</td>
      <td class='DataTD'><input type='password' class='Input' name='_pass1' size='20'></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Retype password</td>
      <td class='DataTD'><input type='password' class='Input' name='_pass2' size='20'></td>
    </tr>

    <tr>
      <td align='right' colspan='2'>
		<input name='lp' type='hidden' value='$row->lp'>
		<input name='state' type='hidden' value='1'>";
			
} 
echo "

			<input class='Button' type='submit' name='Delete' value='Save - Update'></td>
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
if ( $_pass1 <> $_pass2 ) { echo "Passwords don't much!"; exit; }

		 $op = "own password reset";
		 $tabela = "hd_users";
		 $logi = "INSERT INTO `hd_log` ( `lp`, `tabela`, `temat`, `kiedy`, `user_id`, `infodod`) VALUES(null, '$tabela', '$op', '$dzis $godz', '$id', '$dzial')";
		 if (!$db->Open()) $db->Kill();
		 if (!$db->Query($logi)) $db->Kill();
// zapis startu loga
$xx = $db->Free();
$PasswdMD5=md5($_pass1);


 $PasswdQuery = ("UPDATE `hd_users` SET `passwd` = '$PasswdMD5'  WHERE `lp` = '$lp' LIMIT 1") ;
   if (!$db->Open()) $db->Kill();
   if (!$db->Query($PasswdQuery)) $db->Kill();
   echo "<script language='javascript'>window.location=\"adm_czl.php\"</script>";


} else {
 echo "<BR><BR><BR>Ostrze�enie!!!!!<BR><BR><BR>",
	 "Ktos z komputera $REMOTE_ADDR probuje sie wlamac<BR>";
} //else state
//} //elseif  state
?>