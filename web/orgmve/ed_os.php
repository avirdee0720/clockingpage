<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$tytul='Update staff';

(!isset($_POST['state'])) ? $state = 0 : $state = $_POST['state'];
(!isset($_POST['lp'])) ? $lp = $_GET['lp'] : $lp = $_POST['lp'];
(!isset($_POST['recid'])) ? $recid = 0 : $recid = $_POST['recid'];
(!isset($_POST['_firstname'])) ? $_firstname = "" : $_firstname = $_POST['_firstname'];
(!isset($_POST['_surname'])) ? $_surname = "" : $_surname = $_POST['_surname'];
(!isset($_POST['_knownas'])) ? $_knownas = 0 : $_knownas = $_POST['_knownas'];
(!isset($_POST['_status'])) ? $_status = 0 : $_status = $_POST['_status'];

if($state==0)
{
$lp=$_GET['lp'];
echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>

<center>
<!-- BEGIN Record members -->
<form action='$PHP_SELF' method='post' name='ed_czl'>
  <font class='FormHeaderFont'>$tytul</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
";

//uprstr($PU,95);

 if (!$db->Open()) $db->Kill();
  $q = "SELECT MAX(pno) AS pnox FROM nombers";
 if (!$db->Query($q)) $db->Kill();
  $no=$db->Row();

 if (!$db->Open()) $db->Kill();
 if(isset($lp)){
  $q = "SELECT `ID`, `pno`, `firstname`, `surname`, `knownas`, `status` FROM `nombers` WHERE `pno`=$lp LIMIT 1";
  } else { 
  echo "<BR><BR><CENTER><H1>Error in $PHP_SELF</H1></CENTER><BR><BR>";
  exit;
 }
  if (!$db->Query($q)) $db->Kill();
  
    while ($row=$db->Row())
    {
  echo "
 
  <tr>
      <td class='FieldCaptionTD'>Clocking in number</td>
      <td class='DataTD'><B>$row->pno</B></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>First name</td>
      <td class='DataTD'><input class='Input' maxlength='20' name='_firstname' value='$row->firstname'>

      </td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>Surname</td>
      <td class='DataTD'><input class='Input' maxlength='20' name='_surname' value='$row->surname'></td>
    </tr>

    <tr>
      <td class='FieldCaptionTD'>Known as</td>
      <td class='DataTD'><input class='Input' maxlength='20' name='_knownas' size='20' value='$row->knownas'></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>STATUS</td>
      <td class='DataTD'><input class='Input' maxlength='20' name='_status' size='20' value='$row->status'></td>
    </tr>
   
    <tr>
      <td align='right' colspan='2'>
		<input name='recid' type='hidden' value='$row->ID'>
                <input name='lp' type='hidden' value='$lp'>
		<input name='state' type='hidden' value='1'>";
			
} 
echo "
			<input class='Button' name='Update' type='submit' value='$SAVEBTN'>
			<input class='Button'  type='Button' onclick='window.location=\"t_lista.php\"' value='$LISTBTN'></td>
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

// if(isset($Update) and $Update=='$SAVEBTN'){ 
    if (!$db->Open()) $db->Kill();
	$query = ("UPDATE `nombers` SET `firstname`='$_firstname', `surname`='$_surname', `knownas`='$_knownas', `status`='$_status' WHERE `ID` = '$recid' LIMIT 1") ;
//echo $query;
   if (!$db->Open()) $db->Kill();
   $result = mysql_query($query);
   echo "<script language='javascript'>window.location=\"t_lista.php\"</script>";
//   }

//if(isset($Insert) and $Insert=='$NEWBTN')
// { echo "<script language='javascript'>window.location=\"n_os.php\"</script>";   }

} //if state=1
else
{
 echo "<BR><BR><BR>Ostrze�enie!!!!!<BR><BR><BR>",
	 "Ktos z komputera $REMOTE_ADDR probuje sie wlamac<BR>";
} //else state
//} //elseif  state
?>