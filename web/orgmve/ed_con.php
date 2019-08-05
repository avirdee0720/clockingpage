<?php
//this file made by Greg from n_sup.php
// edit contact: ed_con.php?CID=$cid
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;

if (!isset($_POST['state'])) $state = 0; else $state = $_POST['state'];
if (!isset($_GET['cid'])) {
    if (!isset($_POST['cid'])) $state = '-1'; else $cid = $_POST['cid'];
}
else $cid = $_GET['cid'];

if($state == 0)
{
    if (!$db->Open()) $db->Kill();     
    $query =("SELECT * FROM `ContactsTbl`
              WHERE `ConttactID` = '$cid'");
    if (!$db->Query($query)) $db->Kill();
    $contact=$db->Row();

    $_FirstName = $contact->FirstName;
    $_LastName = $contact->LastName;
    $_CompanyName = $contact->CompanyName;
    $_Phone = $contact->Phone;
    $_Fax = $contact->Fax;
    $_Mobile = $contact->Mobile;
    $_Email = $contact->Email;
    $_www = $contact->www;
    $_Address = $contact->Address;
    $_PostalCode = $contact->PostalCode;
    $_Comment = $contact->Comment;
    
    echo "</TABLE>";
    echo "<table width='100%' border=0><tr><td>

<center>
<form action='$PHP_SELF' method='post' name='new_contact'>
<font class='FormHeaderFont'>Edit contact</font>
<br><br>
<table WIDTH=700 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
    <tr>
      <td class='FieldCaptionTD'>First name</td> 
      <td class='DataTD'><input class='Input' maxlength='55' name='_FirstName' size='60' value=\"$_FirstName\"></td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Last name</td> 
      <td class='DataTD'><input class='Input' maxlength='55' name='_LastName' size='60' value=\"$_LastName\"></td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Company Name</td> 
      <td class='DataTD'><input class='Input' maxlength='55' name='_CompanyName' size='60' value=\"$_CompanyName\"></td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Phone</td> 
      <td class='DataTD'><input class='Input' maxlength='35' name='_Phone' size='40' value=\"$_Phone\"></td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Fax</td> 
      <td class='DataTD'><input class='Input' maxlength='35' name='_Fax' size='40' value=\"$_Fax\"></td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Mobile</td> 
      <td class='DataTD'><input class='Input' maxlength='35' name='_Mobile' size='40' value=\"$_Mobile\"></td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Email</td> 
      <td class='DataTD'><input class='Input' maxlength='55' name='_Email' size='60' value=\"$_Email\"></td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Link</td> 
      <td class='DataTD'><B>http://</B><input class='Input' maxlength='255' name='_www' size='60' value=\"$_www\"></td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Address</td> 
      <td class='DataTD'><input class='Input' maxlength='255' name='_Address' size='60' value=\"$_Address\"></td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Postal Code</td> 
      <td class='DataTD'><input class='Input' maxlength='10' name='_PostalCode' size='15' value=\"$_PostalCode\"></td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Comment</td>
      <td class='DataTD'><TEXTAREA NAME='_Comment' ROWS='3' COLS='50'>$_Comment</TEXTAREA></td>
    </tr>
    <tr>
      <td align='right' colspan='2'>
            <input name='state' type='hidden' value='1'>
            <input name='cid' type='hidden' value='$cid'>
            <input class='Button' name='Nowy' type='submit' value='$SAVEBTN'>
            <input class='Button' type='Button' onclick='javascript:history.back()' value='$BACKBTN'>
      </td> 
    </tr>
 
  </table>
</form>

</center>
<BR>
</td>
</tr>
</table>";
        
echo "
</CENTER>
</BODY>
</HTML>";
}

elseif($state == 1)
{
    $cid = $_POST['cid'];
    
    if (!isset($_POST['_FirstName'])) $_FirstName = ''; else $_FirstName = addslashes($_POST['_FirstName']);
    if (!isset($_POST['_LastName'])) $_LastName = ''; else $_LastName = addslashes($_POST['_LastName']);
    if (!isset($_POST['_CompanyName'])) $_CompanyName = ''; else $_CompanyName = addslashes($_POST['_CompanyName']);
    if (!isset($_POST['_Phone'])) $_Phone = ''; else $_Phone = $_POST['_Phone'];
    if (!isset($_POST['_Fax'])) $_Fax = ''; else $_Fax = $_POST['_Fax'];
    if (!isset($_POST['_Mobile'])) $_Mobile = ''; else $_Mobile = $_POST['_Mobile'];
    if (!isset($_POST['_Email'])) $_Email = ''; else $_Email = addslashes($_POST['_Email']);
    if (!isset($_POST['_www'])) $_www = ''; else $_www = addslashes($_POST['_www']);
    if (!isset($_POST['_Address'])) $_Address = ''; else $_Address = addslashes($_POST['_Address']);
    if (!isset($_POST['_PostalCode'])) $_PostalCode = ''; else $_PostalCode = $_POST['_PostalCode'];
    if (!isset($_POST['_Comment'])) $_Comment = ''; else $_Comment = addslashes($_POST['_Comment']);
    
    if (!$db->Open()) $db->Kill();     
        $query = ("UPDATE `ContactsTbl` SET `FirstName` = '$_FirstName', `LastName` = '$_LastName', `CompanyName` = '$_CompanyName', `Phone` = '$_Phone', `Fax` = '$_Fax', `Mobile` = '$_Mobile',
                          `Email` = '$_Email', `www` = '$_www', `Address` = '$_Address', `PostalCode` = '$_PostalCode', `Comment` = '$_Comment'
                   WHERE `ConttactID` = '$cid'");
           
     $result = mysql_query($query);
     if (!$db->Open()) $db->Kill();
     
     echo "<script language='javascript'>window.location=\"contacts.php\"</script>";
}

elseif($state == '-1') {
    echo "<font class='FormHeaderFont'><BR>Invalid CID!<BR>What are you doing???</font>";
}

?>