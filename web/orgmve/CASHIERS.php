<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;

$tytul='Staff admin';

echo "  <TD ALIGN=JUSTIFY VALIGN=TOP border=0>";

if (!$db->Open()) $db->Kill();

if(!isset($letter)) $letter='%';
else $letter=$letter.'%';

if (!$db->Open()) $db->Kill();
$q = "SELECT `ID`, `pno`, `knownas`, `surname` FROM `nombers` WHERE `status`='OK' ORDER BY `pno`";
  if ($db->Query($q)) 
  {
    while ($row=$db->Row())
    {	//"0005"," ","ABRAMS",3

$dlugosc = strlen($row->pno);

if($dlugosc==1)
	$CLNO="000".$row->pno;
elseif($dlugosc==2)
	$CLNO="00".$row->pno;
elseif($dlugosc==3)
	$CLNO="0".$row->pno;
else
	$CLNO=$row->pno;

     echo "\"$CLNO\",\"&nbsp;\",\"$row->knownas $row->surname\",3<BR>";
	} 
} else {
	echo "error!";
	$db->Kill();
}

for ( $counter = 1; $counter <= 60; $counter+=1) {
	$CLNO = $CLNO + 1;
     echo "\"$CLNO\",\"&nbsp;\",\"New member\",3<BR>";

}

?>

"6666"," ","BEAST",3<BR>
"4018"," ","BHARATI",3<BR>
"4037"," ","HANSA",3<BR>
"4049"," ","PERRY", 3<BR>

<BR>
</td></tr>
</table>

<?php
include_once("./footer.php");
?>
