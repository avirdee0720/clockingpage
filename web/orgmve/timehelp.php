<?php
include_once("./header.php");
include("./config.php");
$tytul='Start';
echo "	<TD width='100%' ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>
	<center>
<TABLE>
 <TR>
 	<TD>

<TABLE>
 <TR>
 	<TD><FONT COLOR='#3366FF'><H3>End of the month</H3></FONT></TD>
</TR>
 <TR>
 	<TD>	<OL>
		<LI>Collect all data! From shops in Birmingham & Plymouth
		<LI>Reports -> Empty hours should be cleared ! <A HREF='t_r_et.php'>Check</A> choose the dates: first of the month and the last day of the month
		<LI>Check logical mistakes in personel table (First step on the end of the month) <A HREF='check_pr.php'>OK</A>
		<LI>Click: End_month -> PREPARE TABLES! FIRST STEP! <A HREF='ttp_date.php'>OK</A> choose the dates: first of the month and the last day of the month
		<LI>Then click: End_month -> Prepare table for Paid Leave <A HREF='prep_week1.php'>OK</A> choose year and month
		<U><LI>If the month is 11 (november) you have to add to every employee one day of Paid Leave to count entitlement left <BR>
		Then choose : End_month -> Add day! enter the day (last day of november)
</U>		<LI>Then click: End_month -> Holidays COUNT <A HREF='holidcount1.php'>OK</A> choose year and month
		<BR><FONT  COLOR='#FF0000'>If you have done all of the above:</FONT>
		<LI>Then click: End_month -> Export 
			<LI>Then click: End_month -> Export hours given (it will produce file with sum hours given for every emploee who had PLs) 
		<U><LI>If the month is 11 (november)  then you must subtract the additional day, <BR>which was added in step 6 from the employees Entitlement.
</U>		<LI>Then click: End_month -> Entitlement 
		<LI><H3>Finally, save the Export and Entitlement files into Excel, from here everything is completed in excel</H3> 
	</OL></TD>

 </TR>
 </TABLE>

<TABLE>
 <TR>
 	<TD><FONT COLOR='#3366FF'><H3>CASHIERS</H3></FONT></TD>
</TR>
 <TR>
 	<TD>	<OL>
		<LI>List of current employees to put into CASHIERS.DAT file on computer tills TEAC (Stage&Screen, 38NHG, ...)
		<LI>ON the till: in windows notepad open file C:\SiAMTill\CASHIERS.DAT and delete all it's contents
		<LI>copy all contents from screen CASHIERS (this program) to the file CASHIERS.DAT
		<LI>Save the file CASHIERS.DAT, restart the till program

	</OL></TD>

 </TR>
 </TABLE>

<TABLE>
 <TR>
 	<TD><FONT COLOR='#3366FF'><H3>What to click</H3></FONT></TD>
</TR>
 <TR>
 	<TD><OL>
		<LI><IMG SRC='images/print.png' BORDER='0' ALT='Print/Druk'> - Print
		<LI><IMG SRC='images/zamknij.png' BORDER='0' ALT='Zamknij/Close'> - Close order or techn. part of the order
		<LI><IMG SRC='images/edit.png' BORDER='0' ALT='Edit/Popraw'> -  Edit record
		<LI><IMG SRC='images/drop.png' BORDER='0' ALT='Delete/Skasuj'> -  Delete record
	</OL></TD>
 </TR>
 </TABLE>
";
echo ToolPMenu(0,0) ;
echo "
</TD>
 </TR>
 </TABLE>
 ";


echo "</center>
<BR>
</td></tr>
</table>";
include_once("./footer.php");
?>