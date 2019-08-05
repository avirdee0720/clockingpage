<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;

$tytul = 'New staff member';

(!isset($_POST["state"])) ? $state = "0" : $state = $_POST["state"];
(!isset($_POST["_pno"])) ? $_pno = "0" : $_pno = $_POST["_pno"];
(!isset($_POST["_title"])) ? $_title = "" : $_title = $_POST["_title"];
(!isset($_POST["_firstname"])) ? $_firstname = "" : $_firstname = $_POST["_firstname"];
(!isset($_POST["_surname"])) ? $_surname = "" : $_surname = $_POST["_surname"];
(!isset($_POST["_knownas"])) ? $_knownas = "" : $_knownas = $_POST["_knownas"];
(!isset($_POST["_email"])) ? $_email = "" : $_email = $_POST["_email"];
(!isset($_POST["_code"])) ? $_code = "" : $_code = $_POST["_code"];
(!isset($_POST["_stafftype"])) ? $_stafftype = "" : $_stafftype = $_POST["_stafftype"];
(!isset($_POST["_rstafftype"])) ? $_rstafftype = "" : $_rstafftype = $_POST["_rstafftype"];
(!isset($_POST["_status"])) ? $_status = "OK" : $_status = $_POST["_status"];
(!isset($_POST["_cattoname"])) ? $_cattoname = "" : $_cattoname = $_POST["_cattoname"];
if (!isset($jobtitle)) $jobtitle = "";

if ($state == 0)
{    
echo "

	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>

<center>
<form action='$PHP_SELF' method='post' name='ed_czl'>
  <font class='FormHeaderFont'>$tytul</font><br><br>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
";

 if (!$db->Open()) $db->Kill();
  $q = "SELECT MAX(pno) AS pnox FROM nombers";
 if (!$db->Query($q)) $db->Kill();
  $no=$db->Row();
$clno=$no->pnox+1;
$code = _generate_code_string();
  echo "
  <tr>
      <td class='FieldCaptionTD'>Last assigned clocking number:</td>
      <td class='DataTD'>$no->pnox</td>
    </tr>  
  <tr>
      <td class='FieldCaptionTD'>Next clocking number:</td>
      <td class='DataTD'><B>$clno</B></td>
      <input TYPE='hidden' maxlength='20' name='_pno' size='20' value='$clno'>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Title</td>
      <td class='DataTD'>
    <select name=\"_title\" id=\"select\">
      <option value=\"1\">Mr.</option>
      <option value=\"2\">Mrs.</option>
      <option value=\"3\">Miss.</option>
      <option value=\"4\">Ms.</option>
    </select>
      </td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>First name</td>
      <td class='DataTD'><input class='Input' maxlength='20' onChange=\"this.form._knownas.value=this.value; this.form._surname.value=this.value;\" name='_firstname' value=''>
      </td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>Surname<B><FONT COLOR='#FF0000'>*</FONT></B></td>
      <td class='DataTD'><input class='Input' maxlength='20' name='_surname' value=''></td>
    </tr>

    <tr>
      <td class='FieldCaptionTD'>Known as<B><FONT COLOR='#FF0000'>*</FONT></B></td>
      <td class='DataTD'><input class='Input' maxlength='20' name='_knownas' size='20' value=''></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Email</td>
      <td class='DataTD'><input class='Input' maxlength='64' name='_email' size='20' value=''></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Type</td>
      <td class='DataTD'>
      <select name=\"_stafftype\" id=\"stafftype\">
    <option value=\"c\" selected>Casual</option>
    <option value=\"r\">Regular</option>
	<option value=\"u\">Unpaid</option>
  </select>
      </td>
    </tr>
    <tr>
  
      <td class='FieldCaptionTD'>Regular / unpaid type</td>
      <td class='DataTD'>
        <select name=\"_rstafftype\" id=\"rstafftype\" onchange=\"
        if  (this.form._stafftype.value == 'r' && (this.form._rstafftype.value == 'b' || this.form._rstafftype.value == 'ga' || this.form._rstafftype.value == 'gma'))
        this.form._cattoname.value=this.form._rstafftype.value.toUpperCase() + '.';
		else if  (this.form._rstafftype.value == 'ui') this.form._cattoname.value='INTERN'
		else if  (this.form._stafftype.value == 'u' && this.form._rstafftype != 'ui') this.form._cattoname.value='TRIAL DAY';\">
        <option value=\"0\" selected>Choose Regular or Unpaid Type</option>  
        <option value=\"28\">28 office / gma</option>     
        <option value=\"b\">buyer / regular</option>
        <option value=\"con\">contractor</option>
        <option value=\"dir\">director</option>
        <option value=\"e\">enterprise house / acc</option>
        <option value=\"ga\">general assistant</option> 
        <option value=\"gma\">general management assistant</option>
        <option value=\"i\">IT / ga</option>
        <option value=\"m\">maintenance</option>
		<option value=\"ui\">unpaid - internship</option>
    </select><input TYPE='hidden' maxlength='20' name='_status' size='20' value='OK'>
      </td>
    </tr>
    <tr>     <td class='FieldCaptionTD'>Category on Clocking Table<B><FONT COLOR='#FF0000'>*</FONT></td>
	  <td class='DataTD'><input class='Input' size='20' maxlength='50' name='_cattoname' value=\"\"></td>
	</tr>    
     <tr>
      <td class='DataTD' colspan='2'><B><FONT COLOR='#FF0000'>* - mandatory</FONT></B></td>
    </tr>  
    <tr>
      <td align='right' colspan='2'>
		<input name='state' type='hidden' value='1'>
		<input name='_code' type='hidden' value='$code'>
  
			<input class='Button' name='Update' type='submit' value='$SAVEBTN'>
			<input class='Button' type='Button' onclick='window.location=\"t_lista.php\"' value='$LISTBTN'></td>
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
elseif ($state == 1)
{
    if (!$db->Open()) $db->Kill();
    $q = "SELECT * FROM nombers WHERE pno = $_pno";
    if (!$db->Query($q)) $db->Kill();
    if ($db->Rows() != 0) {
        echo "Clocking number $_pno is already in the database!";
    }
    else {
        if (!$db->Open()) $db->Kill();
        $q = "SELECT value FROM defaultvalues WHERE code = 'hourrate'";
        if (!$db->Query($q)) $db->Kill();
        $no = $db->Row();
        $dailyrate = $no->value * 8.5;
        $date1 = date("Y-m-d");

        if ($_surname != "" && $_surname != " " && $_knownas != ""  && $_knownas != " "  && $_cattoname != "" && $_cattoname != " ") {
            $c = false;
            //CASUAL
            if ($_stafftype == "c" && $_rstafftype != "ui") {
                $q = "
                    INSERT INTO nombers
                           (pno, code, app_state, title, firstname, surname, knownas, paystru, `status` , cat, cattoname, `started`, dateforbonus, daylyrate, bonustype)
                    VALUES ($_pno,'$_code', '2', '$_title', '$_firstname', '$_surname', '$_knownas', 'NEW', '$_status', 'c','$_cattoname', '$date1', '$date1', '$dailyrate','NONE')
                ";
                if (!$db->Query($q)) $db->Kill();
                $c = true;
            }
            //UNPAID INTERNSHIP
            elseif ($_stafftype == "u" && $_rstafftype == "ui") {
                $q = "
                    INSERT INTO nombers
                           (pno, code, app_state, title, firstname, surname, knownas, paystru, `status` ,cat, cattoname, `started`, dateforbonus, daylyrate, bonustype)
                    VALUES ($_pno, '$_code', '2', '$_title', '$_firstname', '$_surname', '$_knownas', 'UNPAID', '$_status', '$_rstafftype', '$_cattoname', '$date1', '$date1', '$dailyrate','NONE')
                ";
                if (!$db->Query($q)) $db->Kill();
                $c = true;
            }
            //REGULAR
            elseif ($_stafftype == "r" && $_rstafftype != "0"  && $_rstafftype != "ui") {
                $q = "
                    INSERT INTO nombers
                           (pno, code, app_state, title, firstname, surname, knownas, paystru, `status`, cat, cattoname, `started`, dateforbonus, daylyrate, bonustype )
                    VALUES ($_pno, '$_code', '2', '$_title', '$_firstname', '$_surname', '$_knownas', 'NEW', '$_status', '$_rstafftype', '$_cattoname', '$date1', '$date1', '$dailyrate', 'NONE')
                ";
                if (!$db->Query($q)) $db->Kill();
                $c = true;
            }
            //UNPAID will be REGULAR
            elseif ($_stafftype == "u" && $_rstafftype != "0"  && $_rstafftype != "ui") {                
                $q = "
                    INSERT INTO nombers
                           (pno, code, app_state, title, firstname, surname, knownas, paystru, `status`, cat, cattoname, tempcat, moretrday, `started`, dateforbonus, daylyrate, bonustype)
                    VALUES ($_pno, '$_code', '2', '$_title', '$_firstname', '$_surname', '$_knownas', 'UNPAID', '$_status', 'ut', '$_cattoname', '$_rstafftype', '1', '$date1', '$date1', '$dailyrate', 'NONE')
                ";
                if (!$db->Query($q)) $db->Kill();
                $c = true;
            }
            else
                echo "<b><span style=\"font-size:13.0pt;font-family:Tahoma;color:red;\">Can't save, data is bad! Redo the form please.</span></b></td>";
            if ($c) {
                $query = (
                    "INSERT INTO staffdetails (`no`, email, jobtitle)
                     VALUES ($_pno, '$_email', '$jobtitle')"
                ); 
                $result = mysql_query($query);
                $query = (
                    "INSERT INTO bankdetails (`no`, banknonumber, bankid)
                     VALUES ($_pno, '1', '9999')"
                );
                $result = mysql_query($query);
                echo "<script language='javascript'>window.location=\"stafflista.php\"</script>";
            }

        } // mandatory fields
        else {
            echo "Please fill all mandatory fields.";
        }
    } //if the clocking number already exists
} //if state = 1

function _generate_code_string() {

  $str = strval(microtime());
  return substr(md5($str),rand(0, 15) , 10);
}
?>