<?
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
if (!isset($intplik)) $intplik='';
$name=$_COOKIE['nazwa'];

if (isset($_GET['menu'])) $menu=$_GET['menu'];

echo "<HTML><HEAD>
<META HTTP-EQUIV='Content-type' CONTENT='text/html; charset=ISO-8859-1'>
<META HTTP-EQUIV='Pragma' CONTENT='no-cache'>
<meta HTTP-EQUIV='cache-control' CONTENT='no-cache, must-revalidate'>
<LINK REL='stylesheet' HREF='style/dupa.css' TYPE='text/css'>
</HEAD><title>:: MVE ::</TITLE>
<SCRIPT LANGUAGE=\"JavaScript\">
<!--
function intro(){
";
if($intplik){
echo "top.window.GLOWNA.window.location=\"$intplik\"";
}
echo "
}
//-->
</SCRIPT>
<body margintop=0 marginleft=0 marginbottom=0 marginright=2 bgcolor='#33FFCC' onload='intro()'>
     <TABLE vAlign=top align=left > <TR>
 <TD width=10%><IMG SRC='images/logo.gif' HEIGHT='20' BORDER='0' ></TD>
 <TD width=70%>
      <TABLE vAlign=top align=left>
	   <TR>";
	   
$tloTB="#99FFFF";


if(!isset($menu)){
 if (!$db->Open()) $db->Kill();

    $q="SELECT * FROM `hd_menu1` WHERE `hd_menu1`.`mnu_nr`='0' ORDER BY `kol`, `mnu_nazwa`";
    
           if($db->Query($q))
           {
             while ($row=$db->Row())
             {
            if (($row->lp != 87) || (($name == "Chris R") || ($name == "Test User") || ($name == "Duarte Novaes") || ($name == "Janos Bodony") || ($name == "Anna Warchol")   || ($name == "Greg Filep") || ($name == "Lorna Kelly") || ($name == "Gosia") )) {
                if (($row->lp != 8) || ($name == "Payroll") || ($name == "Chris R") || ($name == "Janos Bodony") || ($name == "Greg Filep"))  {
              echo "<TD style='BORDER: #000000 1px solid' bgcolor=$tloTB>
				<a style='linkm' href='opcje.php?menu=$row->lp&name=$name&intplik=$row->mnu_plik' >
	            &nbsp;$row->mnu_nazwa&nbsp;
				</a>
                </TD> ";
                 }
              
              }
                
             }
           } else 	{
              echo "Login error!";
              $db->Kill();
           }
	       echo "<TD style='BORDER: #000000 1px solid' bgcolor=$tloTB> 
         <a href='logout.php?id=$id' target='_top'>
	     <span>&nbsp;$EXITBTN&nbsp;</span></a>
          </TD>";

	
 
} else {
    
  if (!$db->Open()) $db->Kill();
$db->Query("UPDATE hd_users SET menu='$menu' WHERE lp='$id'");



    $q="SELECT * FROM hd_menu1 WHERE mnu_nr='$menu' ORDER BY `hd_menu1`.`kol`";

      if($db->Query($q))
        {
         while ($row=$db->Row())
         {

        echo "<TD style='BORDER: #000000 1px solid' bgcolor=$tloTB> 
         <a href='$row->mnu_plik' target='GLOWNA' >
    	 &nbsp;$row->mnu_nazwa&nbsp;</a>
         </TD> ";
        }
     } else 	{
       echo "Login error 2!";
       $db->Kill();
    }
	echo "<TD style='BORDER: #000000 1px solid' bgcolor=$tloTB> 
      <a href='opcje.php?name=$name&intplik=admin.php' >
	 <span>&nbsp;$EXITBTN&nbsp;</span></a>
     </TD>";
}

echo " 	 </TR> </TABLE>
</TD><TD width=20% algin=right>

<SMALL><FONT COLOR='#000000'>$RPNUSER:<B>$nazwa</B>
</FONT></SMALL>
</TD></TR></TABLE>
</body>
</HTML>";
?>