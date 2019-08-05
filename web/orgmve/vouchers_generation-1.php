<?php
ini_set("display_errors","2");
//ERROR_REPORTING(E_ALL);

include_once("./header.php");
$tytul='Voucher Generation<BR>';
//include("./inc/uprawnienia.php");
include("./config.php");
$PHP_SELF = $_SERVER['PHP_SELF'];

$db = new CMySQL;
if (!$db->Open()) $db->Kill();

if (!isset($_POST['state'])) $state = 0; else $state = $_POST['state'];
if (!isset($_POST['_pvno'])) $_pvno = 0; else $_pvno = $_POST['_pvno'];
     
if($state==0)
{

   $q="SELECT DISTINCT `month_id` FROM `voucherslips`
         ORDER BY `load_id` DESC";   
   
   $payslipscode = "<select class='Select' name='_pvno'>\n";  
   
   
  if ($db->Query($q)) 
  {
    while ($r=$db->Row())
    {
        $selectmonth = substr("$r->month_id", 0, 2);
        $selectyear = substr("$r->month_id", 2, 4);
        
        //Setting last month text
        switch ($selectmonth) {
            case '01': $selectmonthtxt = 'January'; break;
            case '02': $selectmonthtxt = 'February'; break;
            case '03': $selectmonthtxt = 'March'; break;
            case '04': $selectmonthtxt = 'April'; break;
            case '05': $selectmonthtxt = 'May'; break;
            case '06': $selectmonthtxt = 'June'; break;
            case '07': $selectmonthtxt = 'July'; break;
            case '08': $selectmonthtxt = 'August'; break;
            case '09': $selectmonthtxt = 'September'; break;
            case '10': $selectmonthtxt = 'October'; break;
            case '11': $selectmonthtxt = 'November'; break;
            case '12': $selectmonthtxt = 'December'; break;
            default: $selectmonthtxt = '';
        }        
        $payslipscode .="<option value='$r->month_id'>$selectmonthtxt, 20$selectyear</option>\n";
        
    }
	} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='3'>SQL Error 1a</td>
  </tr>";
 $db->Kill();
}

      $payslipscode .= "</select>\n";
  


echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>

<center>
<form action='$PHP_SELF' method='post' name='ed_czl'>
  <font class='FormHeaderFont'>$tytul</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
  
  <tr>
      <td class='FieldCaptionTD'></td>
        $payslipscode

</td></tr>
     
   <tr>
      <td align='right' colspan='2'>
		<input name='state' type='hidden' value='1'>

			<input class='Button' name='Update' type='submit' value='$OKBTN'>
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
   echo "<script language='javascript'>window.location=\"vouchers_generation-2.php?pvno=$_pvno\"</script>";
} //if state=1
else
{
 echo "<BR><BR><BR>Ostrze�enie!!!!!<BR><BR><BR>",
	 "Oy! What are you doing? $REMOTE_ADDR <BR>";
} //else state
?>