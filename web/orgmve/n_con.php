<?php
//this file made by Greg from n_sup.php
// edit contact: ed_con.php?CID=$cid
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;

if (!isset($_POST['state'])) $state = 0; else $state = $_POST['state'];

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


if($state == 0)
{
    echo "</TABLE>";
    echo "<table width='100%' border=0><tr><td>

<center>
<form action='$PHP_SELF' method='post' name='new_contact'>
<font class='FormHeaderFont'>Add new contact</font>
<br><br>
<table WIDTH=700 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
    <tr>
      <td class='FieldCaptionTD'>First name</td> 
      <td class='DataTD'><input class='Input' maxlength='55' name='_FirstName' size='60' value=''></td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Last name</td> 
      <td class='DataTD'><input class='Input' maxlength='55' name='_LastName' size='60' value=''></td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Company Name</td> 
      <td class='DataTD'><input class='Input' maxlength='55' name='_CompanyName' size='60' value=''></td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Phone</td> 
      <td class='DataTD'><input class='Input' maxlength='35' name='_Phone' size='40' value=''></td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Fax</td> 
      <td class='DataTD'><input class='Input' maxlength='35' name='_Fax' size='40' value=''></td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Mobile</td> 
      <td class='DataTD'><input class='Input' maxlength='35' name='_Mobile' size='40' value=''></td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Email</td> 
      <td class='DataTD'><input class='Input' maxlength='55' name='_Email' size='60' value=''></td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Link</td> 
      <td class='DataTD'><B>http://</B><input class='Input' maxlength='255' name='_www' size='60' value=''></td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Address</td> 
      <td class='DataTD'><input class='Input' maxlength='255' name='_Address' size='60' value=''></td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Postal Code</td> 
      <td class='DataTD'><input class='Input' maxlength='10' name='_PostalCode' size='15' value=''></td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Comment</td>
      <td class='DataTD'><TEXTAREA NAME='_Comment' ROWS='3' COLS='50'></TEXTAREA></td>
    </tr>
    <tr>
      <td align='right' colspan='2'>
            <input name='state' type='hidden' value='1'>
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

     if (!$db->Open())$db->Kill();     
     $query =("INSERT INTO ContactsTbl (ConttactID, FirstName, LastName, CompanyName, Phone, Fax, Mobile, Email, www, Address, PostalCode, Comment, Valid)
                                 VALUES (NULL, '$_FirstName', '$_LastName', '$_CompanyName', '$_Phone', '$_Fax', '$_Mobile', '$_Email', '$_www', '$_Address', '$_PostalCode', '$_Comment', '1' )");
     $result = mysql_query($query);
     if (!$db->Open())$db->Kill();
  	 $cid=mysql_insert_id();
         
     echo "<script language='javascript'>window.location=\"contacts.php\"</script>";

} 

?>