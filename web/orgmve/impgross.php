</body>
</html> 
<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$title="Import gross apy file to produce shops' costs";

if(!isset($state))
{
?>
<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>

<center>
<!-- <form action='$PHP_SELF' method='post' name='ed_czl'> -->
  <font class='FormHeaderFont'><?php echo $title; ?></font><BR><BR><BR>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
	<TR>
		<TD>File to import:</TD>
		<TD><form enctype="multipart/form-data" action="impgross.php" method="post">
  <input type="hidden" name="MAX_FILE_SIZE" value="10000000">
<input name="plikuzytkownika" type="file">

</TD>
	</TR>
	<TR>
		<TD>Pepare the file:</TD>
		<TD>Export from SAGE PEYROLL gross pay to CSV file</TD>
	</TR>
	<TR>
		<TD>File structure:</TD>
		<TD>column1 - Clocking IN number<BR>column4 - date of pay <BR>column5 - gross pay<BR>column6 - ERS<BR>column7 - EES <BR></TD>
	</TR>
	</TABLE>
<BR><BR>


		<input name='state' type='hidden' value='1'>
		<input class='Button' type='submit' name='ok' onclick=\"return confirm('Are you shure? Do you know what are you are doing?')\" value='IMPORT'>
	</td>
    </tr>
  </table>
</form>
</center>

<?php
}
elseif($state==1)
{
$plik =  $_FILES['plikuzytkownika']['name'];
echo "<H1>$plik</H1>";

if ($_FILES['plikuzytkownika']['error'] > 0)
  {
    echo 'Problem: ';
    switch ($_FILES['plikuzytkownika']['error'])
    {
      case 1: echo 'Size of the file is biger than value of upload_max_filesize'; break;
      case 2: echo 'Size of the file  is biger than value of max_file_size'; break;
      case 3: echo 'File sent only partly'; break;
      case 4: echo 'No file has been sent'; break;
    }
    exit;
  }

// czy plik ma prawid³owy typ MIME?

  if ($_FILES['plikuzytkownika']['type'] != 'application/vnd.ms-excel')
  {
    echo 'ERROR: not MS Excel CSV file';
    exit;
  }

// umieszczenie pliku w po¿¹danej lokalizacji
  $lokalizacja = '/tmp/'.$_FILES['plikuzytkownika']['name'];

  if (is_uploaded_file($_FILES['plikuzytkownika']['tmp_name'])) 
  {
     if (!move_uploaded_file($_FILES['plikuzytkownika']['tmp_name'], $lokalizacja))
     {
        echo 'ERROR: Can not copy the file';
        exit;
     }
  } 
  else 
  {
    echo 'ERROR: Posible attack while sending the file: ';
    echo $_FILES['plikuzytkownika']['name'];
    exit;
  }

  echo 'File sent<br><br>'; 

// ponowne sformatowanie zawartoœci pliku
  $wp = fopen($lokalizacja, 'r');
  $zawartosc = fread ($wp, filesize ($lokalizacja));
  fclose ($wp);
 
  $zawartosc = strip_tags($zawartosc);
  $wp = fopen($lokalizacja, 'w');
  fwrite($wp, $zawartosc);
  fclose($wp);
// pokazanie, co zosta³o wys³ane
  //echo 'File contents:<br><hr>';
  //echo $zawartosc;
  //echo '<br><hr>';


$db = new CMySQL;
$fcontents = file ($lokalizacja); 
for($i=0; $i<sizeof($fcontents); $i++) { 
		$line = trim($fcontents[$i]); 
		$arr = explode(",", $line); 
		$cln=$arr[0];
		$dataprzed=substr($arr[3],1,10);
		$gross=$arr[4];
		$ers=$arr[5];
		$ees=$arr[6];

			//echo "$cln $arr[1] $arr[3] <BR>";
list($day1, $month1, $year1) = explode("/",$dataprzed);
$dnia= "$year1-$month1-$day1";
		
				//echo "IMPORTING: $cln,$dnia, $gross,$ers,$ees <BR>";

		// data has been prepared ---------------------- using rules
		if (!$db->Open()) $db->Kill();
		$spr1r = "INSERT INTO `pay` ( `id` , `no` , `date1` , `gross` ,  `ERSNIC` , `EESNIC`) VALUES ( '', '$cln', '$dnia', '$gross',  '$ers', '$ees');";
		if (!$db->Query($spr1r)) $db->Kill(); 


//} else { echo "$cln,ERROR!!! $dnia, $gross,$ers,$ees ERROR !!!!<BR>"; }

} //for
echo "<H2>Gross pay details (CL NO, DATE, GROSS,ERS and EES)<BR>for $dnia has been imported.</H2>";

echo "</TABLE><BR>
<BR><A HREF='#' onclick=\"window.close();\"><IMG SRC='images/end.jpg' WIDTH='22' BORDER='0' ALT='Close this window'></A>&nbsp;<A HREF='#' onclick=\"window.print();\"><IMG SRC='images/print.png' WIDTH='22' BORDER='0' ALT='Print'></A>";

} else {
 echo "<BR><BR><BR><BR>";
} //else state
//} //elseif  state
?>
 </BODY>
</HTML>
