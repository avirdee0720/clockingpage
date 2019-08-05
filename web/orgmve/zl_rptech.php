<?php
//if(!isset($id) && !isset($pw))
//{header("Location: index.html");exit;}

include_once("./header.php");

if(!isset($state))
{
echo "	
<center>
<form action='$PHP_SELF' method='get' name='n_art'>
  <font class='FormHeaderFont'>$ZLRPTECH1</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
    <tbody>

<tr><td  colspan='2'>
<table border='0' cellpadding='3' cellspacing='1'>
<tr>
	    <td class='FieldCaptionTD'>$RPNDATAOD</td>
        <td class='DataTD'><INPUT class='Input' size='10' NAME='_od' value='$dzis'></td>
		<td class='FieldCaptionTD'>$RPNDATADO</td>
        <td class='DataTD'><INPUT class='Input' size='10'  NAME='_do' value='$dzis'></td>

</tr>
</table></tr>

<tr>
        <td align='right' colspan='2'>
			<input  name='state' type='hidden' value='1'>
			<input  name='dataogl' type='hidden' value='$dzis'>
			<input class='Button' name='Nowy' type='submit' value='$BTNWYDR2'>
		    <INPUT class='Button' TYPE=button name='zmk'  onclick='javascript:history.back()' value='$BACKBTN'>	</td>
      </tr>
    </form>
  </tbody>
</table>
</center>
<BR>
</td></tr>
</table>";

include_once("./footer.php");
}
elseif($state==1)
{
//include_once("./header.php");
echo "
<TABLE vAlign=top align=left> 
<TR>
 <TD>
<TABLE vAlign=top align=left> 
<TR>
 <TD width=10%><IMG SRC='images/logo.gif' HEIGHT='20' BORDER='0' ></TD>
 <TD width=70%><font class='FormHeaderFont'>$ZLRPTECH1</font><BR>$RPNDATAOD $_od $RPNDATADO $_do.</TD>
</TR>
</TABLE>
	
</TD>
</TR><TR>
 <TD>	";



  	echo "<table border='0' cellpadding='1' cellspacing='0'>
         <tr>
		  <td class='FieldCaptionTD'>$ZLNRZAMDE1</td>
		  <td class='FieldCaptionTD'>$ZLNRPOZ</td>
		  <td class='FieldCaptionTD'>$ZLNRZAMPL1</td>
		  <td class='FieldCaptionTD'>$ZLNRK</td>
		  <td class='FieldCaptionTD'>$ZLUWAGI</td>
		  <td class='FieldCaptionTD'>$RPNDATE</td>
		 </tr>";

$d=new CMySQL;
	if (!$db->Open())$db->Kill();
    $query1 =("SELECT * FROM `zl_tech` WHERE `lastuse` > '$_od' AND `lastuse` < '$_do' ORDER BY lastuse DESC");
	  if (!$db->Query($query1)) $db->Kill();

    while ($row=$db->Row())
    {

	  if (!$d->Open())$d->Kill();
      $query2 =("SELECT lp, nr_zam_pl, nr_zam_o, nr_poz, nr_kom FROM `zl_zlec` WHERE lp='$row->id_zlec'");
	  if (!$d->Query($query2)) $d->Kill();
		$zlecenie=$d->Row();

	echo "<tr>
			<td class='DataTD'>$zlecenie->nr_zam_o</td>
			<td class='DataTD'>$zlecenie->nr_poz</td>
			<td class='DataTD'>$zlecenie->nr_zam_pl</td>
			<td class='DataTD'>$zlecenie->nr_kom</td>
            <td class='DataTD'><small>$row->uwagi</small></td>
            <td class='DataTD'><small>$row->data_wp</small></td>
		 </tr>";

	} //end while
echo "</table>
</TD>
</TR>
</TABLE>";
//include_once("./footer.php");
} 
?>