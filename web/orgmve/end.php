<?php
$tytul='Start';
echo "	<TD width='100%' ALIGN=JUSTIFY VALIGN=TOP border=0>";
if(!isset($_POST['startd']) || isset($_GET['startd'])) { $wysw=""; }
else {
    $startd=$_GET['startd'];
    $endd=$_GET['endd'];
    
    $wysw="$startd to $endd.";
}  

echo "	<center>
<BR><BR><BR>
<FONT COLOR='#0000FF'><H1>End of the task. $wysw

</H1></FONT>	 
<BR><BR>
	 <BR><BR>
";


echo "</center>
<BR>
</td></tr>
</table>";
?>
