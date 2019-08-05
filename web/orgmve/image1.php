<?php 
include("./inc/mysql.inc.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$lp=$_GET['cln'];
if (!isset($_GET['title']))
    $title = "";
else $title = $_GET['title'];
if (!isset($_GET['edit']))
    $edit = "";
else $edit = $_GET['edit'];
if (!isset($_GET['ID']))
    $ID = "";
else $ID = $_GET['ID'];

if ($edit != "1") {
$sql = "SELECT `photo_id`, `no`, `photo_alttext`, `photo_src`, `photo_desc`, `photo_filename`, `photo_filesize`, `photo_filetype` FROM `staffphotos` WHERE `no`=$lp  LIMIT 1";

}
else {
$sql = "SELECT `photo_alttext`, `photo_src`, `photo_desc`, `photo_filename`, `photo_filesize`, `photo_filetype` FROM `temp_nombers` WHERE `ID`=$ID  LIMIT 1";

}

if (!$db->Open()) $db->Kill();

          if ($db->Query($sql)) 
            {
				 while ($r=$db->Row())
			     {
					Header("Content-type: $r->photo_filetype"); 
                                        echo $r->photo_src;
					flush();
				}

			} else {
			echo " 
			  <tr>
			   <td class='DataTD'></td>
			    <td class='DataTD' colspan='3'>No photos</td>
			  </tr>";
			 $db->Kill();
			}
?> 
