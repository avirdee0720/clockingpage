<?php
include_once("./header.php");


if(!isset($state))
{
	echo "<form action='$PHP_SELF' method='post' name='zest1'>
	";

   if (!$db->Open()) $db->Kill();

    $q =("SELECT zl_zlec.lp, zl_zlec.nr_zam_pl, zl_zlec.nr_zam_o, zl_zlec.nr_poz, zl_zlec.nr_kom, zl_zlec.obj, zl_zlec.nazwa, zl_zlec.w_z_e, zl_zlec.kurs, zl_zlec.w_z_p, zl_zlec.tn_zam, zl_zlec.uwagi, zl_zlec.data_wp, zl_zlec.id_wpr, zl_zlec.data_popr, zl_zlec.id_popr, zl_zlec.data, zl_zlec.pspelem, zl_zlec.teileno, zl_zlec.id_zam, zl_zlec.data_zam, zl_zlec.id_otw, zl_zlec.data_otw, zl_zlec.zakt, zl_zlec.dostMD, zl_zlec.konserwacja, zl_zlec.TP, zl_zlec.ktermin, zl_zlec.kpartner, zl_zlec.kdata, hd_users.nazwa AS USR FROM zl_zlec	INNER JOIN hd_users ON zl_zlec.id_wpr = hd_users.lp WHERE zl_zlec.lp = $idzl LIMIT 1 ");

    if (!$db->Query($q)) $db->Kill();
    while ($row=$db->Row())
    {
     $wze = $row->w_z_e;

  if (!$db->Open()) $db->Kill();
  $popr = "SELECT hd_users.nazwa FROM hd_users WHERE hd_users.lp='$row->id_popr' LIMIT 1 ";
  if (!$db->Query($popr)) $db->Kill();
  $popr=$db->Row();


    if (!$db->Open()) $db->Kill();
	$sqlprg = ("SELECT  photo_id, id_zlec, photo_alttext, zeichnungsnr, photo_src, photo_desc, photo_endesc, photo_filename, photo_filesize, photo_filetype, photo_path, photo_format, photo_link, data_wp, id_wpr, data_popr, id_popr, data FROM hd_imgcad WHERE hd_imgcad.id_zlec = $idzl ORDER BY hd_imgcad.data_wp");

	if (!$db->Query($sqlprg)) $db->Kill();
		while ($rys=$db->Row())
		{
echo "

<TABLE WIDTH=100% BORDER=1 BORDERCOLOR='#ffffff' CELLPADDING=4 CELLSPACING=0>
	<COL WIDTH=128*>
	<COL WIDTH=128*>
	<THEAD>
		<TR VALIGN=TOP>
			<TD WIDTH=50%>
				<P STYLE='margin-bottom: 0cm'><FONT FACE='Arial, sans-serif'><B>Werkstattaufgabe</B></FONT></P>
				<P STYLE='margin-bottom: 0cm'><FONT FACE='Arial, sans-serif'><FONT SIZE=1>Verteller:	1x
				TK _____________</FONT></FONT></P>
				<P STYLE='margin-bottom: 0cm'><FONT FACE='Arial, sans-serif'><FONT SIZE=1>		1
				x TPP (mit Stuckl. u. Zg. Pause nR. 12)</FONT></FONT></P>
				<P STYLE='margin-bottom: 0cm'><FONT FACE='Arial, sans-serif'><FONT SIZE=1>		1
				x Bearbeiter</FONT></FONT></P>
				<P STYLE='margin-bottom: 0cm'><FONT FACE='Arial, sans-serif'><FONT SIZE=1>		1
				x  TAL</FONT></FONT></P>
				<P STYLE='margin-bottom: 0cm'><FONT FACE='Arial, sans-serif'><FONT SIZE=1>		1
				x TM</FONT></FONT></P>
				<P STYLE='margin-bottom: 0cm'><BR>
				</P>
				<P><FONT FACE='Arial, sans-serif'><FONT SIZE=1 STYLE='font-size: 8pt'><B>Gesamt-/Teil-Aufgabe</B></FONT></FONT></P>
			</TD>
			<TD WIDTH=50%>
				<P><IMG SRC='werk1_html_m6182a52c.gif' NAME='graphics1' ALIGN=LEFT WIDTH=89 HEIGHT=36 BORDER=0>
				<FONT FACE='Arial, sans-serif'><FONT SIZE=4><B>F&ouml;rderanlangen</B></FONT></FONT></P>
				<P> <FONT FACE='Arial, sans-serif'><FONT SIZE=4><B>Magdeburg</B></FONT></FONT></P>
				<P ALIGN=RIGHT><FONT FACE='Arial, sans-serif'><FONT SIZE=1 STYLE='font-size: 8pt'><B>Datum:
				$dzis</B></FONT></FONT></P>
				<P ALIGN=RIGHT><BR>
				</P>
				<P ALIGN=RIGHT><FONT FACE='Arial, sans-serif'><FONT SIZE=1 STYLE='font-size: 8pt'><B>St<FONT FACE='Times New Roman, serif'>&uuml;</FONT>ckl.
				u. Zg. Zu TPP/TM am: _____________</B></FONT></FONT></P>
			</TD>
		</TR>
	</THEAD>
</TABLE>



<P ALIGN=LEFT STYLE='margin-bottom: 0cm; font-weight: medium'><FONT FACE='Arial, sans-serif'><FONT SIZE=2 STYLE='font-size: 9pt'>
Auftraggeber: <BR>
PSP-Element: <B>$row->pspelem</B><BR>
St&uuml;ck: 1 Teile-Nr.: <B>$rys->zeichnungsnr</B><BR>
Benennung: _________<BR>
Masse der Teilaufgabe:  _____ kg;  Gesamtmasse: _____ kg<BR>
Bemerkungen: ____________<BR><BR>

Leiter		Bearbeiter		
<TABLE WIDTH=100% BORDER=1 BORDERCOLOR='#000000' CELLPADDING=4 CELLSPACING=0 FRAME=ABOVE RULES=NONE>
	<COL WIDTH=256*>
	<THEAD>
		<TR>
			<TD WIDTH=100% VALIGN=TOP>
				<P ALIGN=LEFT><BR>
				</P>
				<P ALIGN=LEFT><FONT FACE='Arial, sans-serif'><FONT SIZE=2 STYLE='font-size: 9pt'>Empfangsbest&auml;tigung
				von TPP/TM					Datum		Unterschrift</FONT></FONT></P>
			</TD>
		</TR>
	</THEAD>
	<TBODY>
		<TR>
			<TD WIDTH=100% VALIGN=TOP>
				<P ALIGN=LEFT><BR>
				</P>
			</TD>
		</TR>
	</TBODY>
</TABLE>
<P ALIGN=LEFT STYLE='font-weight: medium'><BR>
</P>
<P STYLE='margin-bottom: 0cm'><BR>
</P>
<P STYLE='margin-bottom: 0cm'><BR>
</P>
<P STYLE='margin-bottom: 0cm'><BR>
</P>
<P STYLE='margin-bottom: 0cm'><BR>
</P>
";
}
include("./footer.php");
	}}
elseif($state==1)
{


} 
?>