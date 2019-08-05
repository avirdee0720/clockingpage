<?php
echo "
<link rel=\"stylesheet\" type=\"text/css\" href=\"style/mb/Style.css\">
<center>
<table cellspacing='4' cellpadding='4'>
<TR BGCOLOR='$kolorTlaRamki'>
        <td><FONT font class='FormHeaderFont' COLOR='$kolorTekstu'>&nbsp;&nbsp;Administracja</FONT></td>
</TR>

  <tr>
    <td class='DataTD'><a class='DataLink' href='adm_art.php'><img border='0' height='16' src='images/adminArticles-icon.gif' width='16'>&nbsp;&nbsp;$Artykuly</a></td>
  </tr>
  <tr>
    <td class='DataTD'><a class='DataLink' href='adm_zda.php'><img border='0' height='16' src='images/adminEvents-icon.gif' width='16'>&nbsp;&nbsp;$Zdarzenia</a></td>
  </tr>
  <tr>
    <td class='DataTD'><a class='DataLink' href='adm_news.php'><img border='0' height='16' src='images/adminNews-icon.gif' width='16'>&nbsp;&nbsp;$News</a></td>
  </tr>
  <tr>
    <td class='DataTD'><a class='DataLink' href='adm_link.php'><img border='0' height='16' src='images/adminLinks-icon.gif' width='16'>&nbsp;&nbsp;Linki</a></td>
  </tr>
  <tr>
    <td class='DataTD'><a class='DataLink' href='adm_szef.php'><img border='0' height='16' src='images/adminClubOfficerss-icon.gif' width='16'>&nbsp;&nbsp;Wazne osoby</a></td>
  </tr>
  <tr>
    <td class='DataTD'><a class='DataLink' href='adm_czl.php'><img border='0' height='16' src='images/adminMembers-icon.gif' width='16'>&nbsp;&nbsp; U¿ytkownicy</a></td>
  </tr>
  <tr>
    <td class='DataTD'><a class='DataLink' href='czl_inf.php'><img border='0' height='16' src='images/adminClubOfficerss-icon.gif' width='16'>&nbsp;&nbsp;Moje dane</a></td>
  </tr>
  <tr>
    <td class='DataTD'><a class='DataLink' href='adm_gal.php'><img border='0' height='16' src='images/adminClubOfficerss-icon.gif' width='16'>&nbsp;&nbsp;Galeria</a></td>
  </tr>
  <tr>
    <td class='DataTD'><a class='DataLink' href='ed_cfg.php'><img border='0' height='16' src='images/adminClubOfficerss-icon.gif' width='16'>&nbsp;&nbsp;Konfiguracja wyswietlania</a></td>
  </tr>
    <tr>
    <td class='DataTD'><a class='DataLink' href='adm_wygl.php'><img border='0' height='16' src='images/adminClubOfficerss-icon.gif' width='16'>&nbsp;&nbsp;Konfiguracja modulów</a></td>
  </tr>
  <tr>
    <td class='DataTD'><a class='DataLink' href='adm_mod.php'><img border='0' height='16' src='images/adminClubOfficerss-icon.gif' width='16'>&nbsp;&nbsp;Modu³y</a></td>
  </tr>
  <tr>
    <td class='DataTD'><a class='DataLink' href='tools.php'><img border='0' height='16' src='images/adminClubOfficerss-icon.gif' width='16'>&nbsp;&nbsp;Tools</a></td>
  </tr>
  <tr>
    <td class='DataTD'><a class='DataLink' href='logout.php'><img border='0' height='16' src='images/end.jpg' width='16'>&nbsp;&nbsp;Wyjdz</a></td>
  </tr>
</table>
</center>

";
?>