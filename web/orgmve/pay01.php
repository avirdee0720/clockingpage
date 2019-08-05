<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$db1 = new CMySQL;


//uprstr($PU,90);
$cln=$_GET['cln'];
$tytul='Pays of Employee';

if (!$db1->Open()) $db1->Kill();
$prac1 =("SELECT `ID`, `pno`, `firstname`, `surname`, `knownas`, `status` FROM `nombers` WHERE `pno`='$cln' LIMIT 1;");
if (!$db1->Query($prac1)) $db1->Kill();
   while ($row1=$db1->Row())
    {
    echo "
	<TABLE><TR><TD>
<div id='name'>
<font class='FormHeaderFont'>$tytul $cln</font> 

		<table>
    <tr>
      <td class='FieldCaptionTD'>Clocking in number</td><td class='DataTD'><FONT COLOR='#000099'><B>$row1->pno</B></FONT></td>
	  <td class='FieldCaptionTD'>Known as</td><td class='DataTD'>$row1->knownas</td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>First name</td><td class='DataTD'>$row1->firstname</td>
      <td class='FieldCaptionTD'>Surname</td><td class='DataTD'>$row1->surname</td>
    </tr>   
   </table>";
	}
?>
<script type="text/javascript" language="javascript">
    function makeRequest(url) {
        var http_request = false;

        if (window.XMLHttpRequest) { // Mozilla, Safari, ...
            http_request = new XMLHttpRequest();
            if (http_request.overrideMimeType) {
                http_request.overrideMimeType('text/xml');
                // See note below about this line
            }
        } else if (window.ActiveXObject) { // IE
            try {
                http_request = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
                try {
                    http_request = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (e) {}
            }
        }

        if (!http_request) {
            alert('Giving up :( Cannot create an XMLHTTP instance');
            return false;
        }
		
		// http.open('get', 'list.php');
		// http.onreadystatechange = handleResponse;

        //http_request.onreadystatechange = function() { alertContents(http_request); };
        http_request.open('GET', url, true);
		http_request.onreadystatechange = handleResponse;
        http_request.send(null);

    }
function handleResponse() {
if(http.readyState == 4) {
var response = http.responseText;
document.getElementById('pay').innerHTML = response;
}
}
    function alertContents(http_request) {

        if (http_request.readyState == 4) {
            if (http_request.status == 200) {
                alert(http_request.responseText);
            } else {
                alert('There was a problem with the request.');
            }
        }

    }
</script>
<?php
echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
<center>
&nbsp;

</TD><TD>
<div id='list'>

<table border='0' cellpadding='3' cellspacing='1' >
  <tr>
  <td class='ColumnTD' nowrap>DATE </td>
  <td class='ColumnTD' colspan='5' nowrap>TOTAL GROSS	</td>
  </tr>";

if (!$db->Open()) $db->Kill();
$sql = "SELECT `id`, SUM(`monetarytotal`) AS total, DATE_FORMAT( `date1`,\"%d/%m/%Y\") AS date2 FROM `paygross` WHERE `no`='$cln' GROUP BY `date1` ORDER BY `date1` DESC";

  if ($db->Query($sql)) 
  {
    while ($row=$db->Row())
    {
     echo "<tr>
		<td class='DataTD'>$row->date2</td>
		<td class='DataTD'>&pound; <B>".number_format($row->total,2,'.',' ')."</B></td>
		<td class='DataTD'><A HREF='#' onClick='window.open(\"disp_voucher.php?cln=$cln&endd=$row->date2\", 300, 200);'>Display</A></td>
	  </tr>  ";
  } 
} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='5'>Error</td>
  </tr>";
 $db->Kill();
}
echo "
  <tr>
    <td align='left' class='FooterTD' nowrap>&nbsp;</td>
    <td align='middle' class='FooterTD' colspan='5' nowrap>&nbsp;</td>
  </tr>
</table>

</DIV>

<TD></TD>

<TABLE>
<TR>
<TD>
&nbsp;</TD>

</TR>
</TABLE>

</TD></TR></TABLE>

</center><BR></td></tr></table>";
include_once("./footer.php");
?>