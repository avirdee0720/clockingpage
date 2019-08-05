<?
include("inc/mysql.inc.php");
$db = new CMySQL();
//$db->PHPSESSID_tmp=$PHPSESSID;
include_once("./config.php");
include("./languages/$LANGUAGE.php");

echo "<HTML><HEAD>
<META HTTP-EQUIV=\"Content-type\" CONTENT=\"text/html; charset=windows-1250\">
<META HTTP-EQUIV='Content-Language' CONTENT='pl'>
<META HTTP-EQUIV='Pragma' CONTENT='no-cache'>
<meta HTTP-EQUIV='cache-control' CONTENT='no-cache, must-revalidate'>
<meta name=description content=magazyn>
<meta name=keywords content=magazyn>
<META NAME='Robots' CONTENT='INDEX, FOLLOW'>
<LINK REL='stylesheet' HREF='style/dupa.css' TYPE='text/css'>
<LINK REL='stylesheet' HREF='style/mb/style.css' TYPE='text/css'>
</HEAD><title>:: magazyn ::</TITLE>

<body margintop=0 marginleft=0 marginbottom=0 marginright=0 bgcolor=\"#336699\" >
      <div id=\"menu\"><CENTER>
      <TABLE algin=center> <TR>";

if(!isset($menu)){
    $q="SELECT * FROM hd_menu1 WHERE mnu_nr='0'";

           if (!$db->Open()) $db->Kill();

           if($db->Query($q))
           {
             while ($row=$db->Row())
             {
              echo "<TD class='ColumnTD'> 
                 <UL> 
           	 <LI>
				<a href=\"opcje.php?menu=$row->lp&name=$name\" >
	            <span class='menulink'>$row->mnu_nazwa</span></a>
                </UL> </TD> ";
             }
           } else 	{
              echo "SPADAJ!";
              $db->Kill();
           }
	       echo "<TD class='ColumnTD'> 
         <UL> 
	     <LI><a href=\"logout.php\" >
	     <span class=\"menulink\">$EXITBTN</span></a>
         </UL> </TD>";
} else {
    $q="SELECT * FROM hd_menu1 WHERE mnu_nr='$menu'";

     if (!$db->Open()) $db->Kill();

      if($db->Query($q))
        {
         while ($row=$db->Row())
         {
        echo "<TD class='ColumnTD'> 
         <UL><LI><a href=\"$row->mnu_plik\" target='GLOWNA'>
    	 <span class='menulink'>$row->mnu_nazwa</span></a>
        </UL> </TD> ";
        }
     } else 	{
       echo "SPADAJ!";
       $db->Kill();
    }
	echo "<TD class='ColumnTD'> 
      <UL> 
	 <LI><a href=\"opcje.php?name=$name\" >
	 <span class=\"menulink\">$EXITBTN</span></a>
     </UL> </TD>";
}

 

echo " 	 </TR> </TABLE>";
echo "	</CENTER>  </div>
";
echo"
<FONT SIZE=\"2\" COLOR=\"#FFFF00\">Uzytkownik:<B>$name</B>	
</FONT></body></HTML>";
?>