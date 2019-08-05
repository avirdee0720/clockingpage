<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
uprstr($PU,90);



if (!$db->Open()) $db->Kill();
$q = "SELECT hd_users.lp, hd_users.login, hd_wydzial.dzial, hd_users.nazwa, hd_users.wydzial, hd_users.adm, hd_users.passwd, hd_users.PU, hd_users.miasto, hd_users.woj, hd_users.kraj, hd_users.tel1, hd_users.tel2 FROM (hd_users INNER JOIN hd_wydzial ON hd_users.wydzial = hd_wydzial.lp) ORDER BY hd_users.nazwa ASC";


  if ($db->Query($q)) 
  {
    while ($row=$db->Row())
    {

     echo "  ";
     } 
} else { echo "  error !";  $db->Kill(); }

echo "

</table>
</center>
<BR>
</td></tr>
</table>";
include_once("./footer.php");
?>