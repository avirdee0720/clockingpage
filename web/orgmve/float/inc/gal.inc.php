<?php
echo "
<TABLE WIDTH=100% BORDER=0 align=center>
<TR BGCOLOR='$kolorTlaRamki'>
        <TH><p><FONT COLOR='$kolorTekstu'>&nbsp;<img src='images/kropka.png' border=0>&nbsp;Wyda¿enia</FONT>
        </TH>
</TR>
<TR>
        <TD bgcolor='$kolorWewTabel' align=center><p align=left>";

if (!$baza->Open()) $baza->Kill();
$q = "SELECT photo_id, artykul_id, photo_alttext, photo_desc, photo_filename, photo_filesize, photo_filetype, photo_link FROM galeria ORDER BY  photo_id";



$baza->Query($q);
$numrows=$baza->Rows();
echo " Wszystkich: <b>$numrows</b><br>";
if(!isset($start) or $start=="") $start=0;

//limitowanie iloœci wierszy $rown=5 

  if ($baza->Query($q)) 
  {
    while ($row=$baza->Row())
    {

echo "

<div align=\"left\"><a href='gal.php?lp=$row->photo_id'>$row->photo_filename</a><br>
Start: $row->photo_desc<br>
</div>
<br><HR SIZE=1 WIDTH='40%' NOSHADE> <br>
";
	}
} else {
echo " Brak gal ";
 $baza->Kill();
}
echo" 
        </TD>
</TR>
</TABLE>
";
?>