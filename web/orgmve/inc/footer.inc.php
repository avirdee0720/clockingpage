<?php
echo "
<HR ALIGN=CENTER SIZE=1 WIDTH='100%' NOSHADE>
";
//========================================================
echo "
        </TD>

<!-- prawa ramka usunieta - A. Majewski 20031230 -->
<TD width=$szerKolRight ALIGN=RIGHT VALIGN=TOP bgcolor='#FFFFFF' border=0>

<!-- lewa  -->";
include("garace.inc.php");
include("protegowani.inc.php");
include("prawne.inc.php");
include("dodatki.inc.php");

echo "

   </TD>

<CENTER>";



echo "
</center>
        </TD>
</TR>
</TABLE>

        <!-- tabela na stopke -->

        <TABLE WIDTH=$szerokoscRamkiGL BORDER=0 bordercolor='#EEEEEE'>
        <TR>
        <TD width=50% ALIGN=left VALIGN=TOP><center>
        <P><BR><A href='forum/'>Forum</A>
        - <A href='konto/'>Wpis do bazy plastyków</A>
        - <A href='aktualnosci/'>Aktualno¶ci</A>
        - <A href='prasa/'>Przegl±d prasy</A>
        - <A href='czasopisma/'>Czasopisma</A>
        - <A href='praca/'><BR>Praca</A>
        - <A href='ogloszenia/'>Og³oszenia</A>
        - <A href='organizacje/'>Organizacje</A>
        - <A href='szkolywyzsze/'>Szko³y wy¿sze</A>

         </center> </TD>
         </TR><TR>
        <TD width=50% ALIGN=left VALIGN=TOP>
        <center>
        <p>
        <A HREF='index.php?adr=./prawo.php' TITLE='Zastrzenia prawne'>Zastrzenia prawne</A><br>
        Copyright &copy; 2004 plastycy.pl, Wykonanie: <A HREF='mailto:zolty@wanet.pl' TARGET='_top'>¯ó³ty</A> &nbsp;&nbsp;
        <br><a href=\"adm/\">&Pi;</a>
        W sprawach zwiazanych ze srtronami kontaktuj sie z <A HREF='mailto:zolty@wanet.pl' TARGET='_top'>¯ó³ty</A> &nbsp;&nbsp;<br>
        <!--Iloœæ odwiedzin:  <A HREF='http://mycount.net/stats?zolty10' TARGET='_top'><IMG SRC='http://mycount.net/counter?zolty10' BORDER=0 ALT='counter'></A> -->
        </center> </TD>

</TR>
</TABLE>
</center>
</BODY>
</HTML>
";
?>