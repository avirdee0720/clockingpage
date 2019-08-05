<?php
//if(!isset($id) && !isset($pw))
//{header("Location: index.html");exit;}

include_once("./header.php");

if(!isset($state))
{
echo "	
<center>
<form action='$PHP_SELF' method='post' name='oldcad'>
  <font class='FormHeaderFont'>$ORTYT</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
    <tbody>

<tr><td  colspan='2'>
<table border='0' cellpadding='3' cellspacing='1'>
<tr>

	    <td class='FieldCaptionTD'>$ZLZNR</td>
        <td class='DataTD'><INPUT class='Input' size='11' NAME='_Zeichnungsnr' value='%'></td>
	</tr><tr>
		<td class='FieldCaptionTD'>$ZLPD</td>
        <td class='DataTD'><INPUT class='Input' size='50'  NAME='_Name' value='%'></td>
	</tr><tr>
		<td class='FieldCaptionTD'>$ZLPEND</td>
        <td class='DataTD'><INPUT class='Input' size='50'  NAME='_enName' value='%'></td>
	</tr><tr>
		<td class='FieldCaptionTD'>$ZLPP</td>
        <td class='DataTD'><INPUT class='Input' size='50'  NAME='_Adresse' value='%'></td>
	</tr><tr>
		<td class='FieldCaptionTD'>$ZLPFN</td>
        <td class='DataTD'><INPUT class='Input' size='30'  NAME='_Unteradresse' value='%'></td>
	</tr><tr>
		<td class='FieldCaptionTD'>$ZLPF</td>
        <td class='DataTD'><INPUT class='Input' size='5'  NAME='_Format' value='%'></td>
</tr>
</table></tr>

<tr>
        <td align='right' colspan='2'>
			<input  name='state' type='hidden' value='1'>
			<input  name='dataogl' type='hidden' value='$dzis'>
			<input class='Button' name='Nowy' type='submit' value='$SEARCHBTN'>
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
 <TD width=70%><font class='FormHeaderFont'>$ORTYT</font><BR>$dzis.</TD>
</TR>
</TABLE>
	
</TD>
</TR><TR>
 <TD>	";


  	echo "<table border='0' cellpadding='1' cellspacing='0'>
         <tr>
		  <td class='FieldCaptionTD'>$ZLZNR</td>
		  <td class='FieldCaptionTD'>$ZLPD</td>
		  <td class='FieldCaptionTD'>$ZLPEND</td>
		  <td class='FieldCaptionTD'>$ZLPP</td>
		  <td class='FieldCaptionTD'>$ZLPFN</td>
		  <td class='FieldCaptionTD'>$ZLPF</td>
		 </tr>";

	if (!$db->Open()) $db->Kill();
    $query =("SELECT Zeichnungsnr, Name, enName, Adresse, Unteradresse, Format FROM `old_cad` WHERE Zeichnungsnr LIKE '$_Zeichnungsnr' AND Name LIKE '$_Name' AND enName LIKE '$_enName' AND Adresse LIKE '$_Adresse' AND Unteradresse LIKE '$_Unteradresse' AND Format LIKE '$_Format' ORDER BY Zeichnungsnr DESC");
    if (!$db->Query($query)) $db->Kill();

    while ($row=$db->Row())
    {

	echo "<tr>
			<td class='DataTD'>$row->Zeichnungsnr</td>
			<td class='DataTD'>$row->Name</td>
			<td class='DataTD'>$row->enName</td>
			<td class='DataTD'>$row->Adresse</td>
            <td class='DataTD'><small>$row->Unteradresse</small></td>
            <td class='DataTD'><small>$row->Format</small></td>
		 </tr>";

	} //end while
echo "</table>
</TD>
</TR>
</TABLE>";
//include_once("./footer.php");
} 
?>