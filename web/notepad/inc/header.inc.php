<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.0 Transitional//EN'>
<HTML>
<HEAD>
<?php
include("config.php");
include("mysql.inc.php");

$logow = new CMySQL;
if (!$logow->Open()) $logow->Kill();
     $nowy="INSERT INTO `log` ( `pl` , `SCRIPT_NAME ` , `SCRIPT_FILENAME` , `REQUEST_URI` , `REQUEST_METHOD` , `REMOTE_PORT` , `REMOTE_ADDR` , `HTTP_USER_AGENT` , `HTTP_CONNECTION` , `HTTP_ACCEPT_LANGUAGE` , `HTTP_ACCEPT_ENCODING` , `HTTP_ACCEPT`, `datat` )
VALUES ('', '$SCRIPT_NAME', '$SCRIPT_FILENAME', '$REQUEST_URI', '$REQUEST_METHOD', '$REMOTE_PORT', '$REMOTE_ADDR', '$HTTP_USER_AGENT', '$HTTP_CONNECTION', '$HTTP_ACCEPT_LANGUAGE', '$HTTP_ACCEPT_ENCODING', '$HTTP_ACCEPT', '$logtime');";
if (!$logow->Query($nowy)) $logow->Kill();

//$logow = new CMySQL;
if (!$logow->Open()) $logow->Kill();
$cnf="SELECT kolorTekstu, kolorTlaRamki, kolorTlaWew, kolorWewTabel, szerokoscRamkiGL, szerKolleft, szerKolmidl, szerKolRight, tloplik  FROM `conf` LIMIT 1";
        if (!$logow->Query($cnf)) $logow->Kill();

while($w=$logow->Row())
{
$kolorTekstu = $w->kolorTekstu;
$kolorTlaRamki = $w->kolorTlaRamki;
$kolorTlaWew = $w->kolorTlaWew;
$kolorWewTabel = $w->kolorWewTabel;
$szerokoscRamkiGL = $w->szerokoscRamkiGL;
$szerKolleft=$w->szerKolleft;
$szerKolmidl=$w->szerKolmidl;
$szerKolRight=$w->szerKolRight;
$tloGL=$w->tloplik;
}
//SELECT uklad.place, modules.mod_file, modules.mod_name
//FROM uklad INNER JOIN modules ON uklad.modules_id = modules.lp;

?>
<META HTTP-EQUIV=\"Content-type\" CONTENT=\"text/html; charset=iso-8859-2\">
<META HTTP-EQUIV='Content-Language' CONTENT='pl'>
<META HTTP-EQUIV='Pragma' CONTENT='no-cache'>
<meta HTTP-EQUIV='cache-control' CONTENT='no-cache, must-revalidate'>
<meta name=description content=plastycy>
<meta name=keywords content=zdrowie,walbrzych,Wa³brzych>
<META NAME='Robots' CONTENT='INDEX, FOLLOW'>
<LINK REL=stylesheet HREF=./style/dupa.css TYPE='text/css'>
<title>:: www.plastycy.pl</TITLE>
<SCRIPT language=JavaScript src="skrypty/fw_plastycy.js"></SCRIPT>
<SCRIPT language=JavaScript1.2 src="skrypty/fw_menu.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript">
<!--
function display(url, width, height) {
        var Win = window.open(url,'displayWindow','width=' + width + ',height=' + height + ',resizable=0,scrollbars=yes,menubar=no' );
}

function selecturl(s) {
        var gourl = s.options[s.selectedIndex].value;        window.top.location.href = gourl;
}

function bookmarkit(){
window.external.addFavorite('http://www.plastycy.pl','Portal plastycy.pl')
}
//-->
</SCRIPT>
</HEAD>

<BODY BGCOLOR='#FFFFFF' TEXT='#000000' LINK='$kolorTlaRamki' LEFTMARGIN=5 RIGHTMARGIN=5 TOPMARGIN=0 BOTTOMMARGIN=0 MARGINWIDTH=5 MARGINHEIGHT=5>

<SCRIPT language=JavaScript1.2>fwLoadMenus();</SCRIPT>
<CENTER>
<TABLE WIDTH=<?php echo "$szerokoscRamkiGL"; ?> cellSpacing=0 cellPadding=0 BORDER=0>

<TR>
<TD border=0 BGCOLOR=<?php echo "$kolorTlaRamki"; ?> >
<p align=center>
<?php
include("./inc/menugl.inc.php");

echo "</TD>
</TR>

</TABLE>
<!--  tabela na naglowek  -->

<TABLE WIDTH=$szerokoscRamkiGL BORDER=0 BACKGROUND=$tloGL bordercolor='#FFFFFF'>
<TR>
        <TD ALIGN=CENTER VALIGN=TOP bgcolor='' border=0>
               <p align=left>
     <FONT SIZE='-4' COLOR='red'>
     Dzisiaj jest <b>$dz_tyg</b>,
     <b>$dzis</b>, <br>
     Imieniny:<b> ";echo $imieniny[$dzien-1];
     echo "</B>
        </TD>
        <TD ALIGN=CENTER VALIGN=TOP border=0>

<!-- logo -->
<P ALIGN='left'>   <br>
<FONT SIZE='+1' COLOR=#004080 > www.plastycy.pl</FONT > <br>
<!--width=471 <img src='images/logo.jpg' border='0' alt='Plastycy' title='www.plastycy.pl' /> -->
</TD>
           <TD width=60% ALIGN=RIGHT VALIGN=middle border=0>

<!-- banner       -->

<CENTER>
<iframe SRC='banner.php' width=468 height=50 scrolling=no frameborder=0 align=center valign=center target=_blank>
</IFRAME>
</CENTER>
</TD>

</TR>
</TABLE>


<!--  tabela na kolumny  -->
<TABLE WIDTH=$szerokoscRamkiGL HEIGHT=100% BORDER=0 bordercolor='#EEEEEE'>
<TR>
<TD width=$szerKolleft ALIGN=LEFT VALIGN=TOP bgcolor='#FFFFFF' border=0>

<!-- lewa  -->";
//include("dzien.inc.php");

include("news.inc.php");
include("zda.inc.php");
include("gal.inc.php");
include("google.inc.php");

echo "

   </TD>
<!-- glowna -->
";
//========================================================
//if(!isset($adr)) $adr="main_gl.php";
//include($adr);
?>