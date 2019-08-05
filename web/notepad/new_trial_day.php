<?php
session_start();
//unset ($_SESSION['clockingver']);
//session_destroy();

error_reporting(E_ALL);
ini_set('display_errors','On');

include("./inc/mysql.inc.php");
require('libs/Smarty.class.php');

$smarty = new Smarty;

$db = new CMySQL;
if (!$db->Open()) $db->Kill();

if (!isset($_POST['state'])) $state = 0; else $state = $_POST['state'];

if ($state==1){    //state = 1 new trial day
    $name=mysql_real_escape_string($_POST['name']);
    $surname=mysql_real_escape_string($_POST['surnamename']);
    $code=mysql_real_escape_string($_POST['code']);
    $out1 = "Insert into trialdays (ip,time,name,surname,code) values('".$_SERVER['REMOTE_ADDR']."', NOW() ,'$name','$surname','$code');";
    if (!$db->Query($out1)) $db->Kill();
    $out1="UPDATE `defaultvalues` SET `value`=CONCAT(UNIX_TIMESTAMP(),'T',FLOOR(RAND() * 1000))  WHERE `code`='clversion' LIMIT 1;";
    if (!$db->Query($out1)) $db->Kill();
    echo "<html><body onload='javascript:close()'><center><h1>You can close this window</h1></center></body></html> ";
}


if ($state==2){    //state = 2 update trial day
    $name=mysql_real_escape_string($_POST['name']);
    $surname=mysql_real_escape_string($_POST['surnamename']);
    $code=mysql_real_escape_string($_POST['code']);
    $id=mysql_real_escape_string($_POST['id']);
    $out1 = "Update trialdays set name = $name , surname = $surname ,code = $code where id = $id;";
    if (!$db->Query($out1)) $db->Kill();
    $out1="UPDATE `defaultvalues` SET `value`=CONCAT(UNIX_TIMESTAMP(),'T',FLOOR(RAND() * 1000))  WHERE `code`='clversion' LIMIT 1;";
    if (!$db->Query($out1)) $db->Kill();
    echo "<html><body onload='javascript:close()'><center><h1>You can close this window</h1></center></body></html> ";
}


if ($state==3){    //state = 3 delete trial day
    $id=mysql_real_escape_string($_POST['id']);
    $out1 = "Delete from trialdays where id = '$id';";
    if (!$db->Query($out1)) $db->Kill();
    $out1="UPDATE `defaultvalues` SET `value`=CONCAT(UNIX_TIMESTAMP(),'T',FLOOR(RAND() * 1000))  WHERE `code`='clversion' LIMIT 1;";
    if (!$db->Query($out1)) $db->Kill();
    echo "<html><body onload='javascript:close()'><center><h1>You can close this window</h1></center></body></html> ";
}


if ($state==0){    //state = 0 - new window

    echo "<html><head><link rel = 'stylesheet' type = 'text/css' href = 'style.css'/></head><body>";
    
    echo "<center><h1>Enter details of trial person:</h1></center>";
    echo "<form target = '_self' method = 'post'><table style='width:100%'><tr><th>First name</th><th>Surname</th><th>Code</th></tr>";
    echo "<tr><td><center><input type='text' name='name'/></center></td><td><center><input type='text' name='surnamename'/></center></td><td><center><input type='text' name='code'/></center></td></tr>";
    echo "<tr><td><br/></td><td><center><input class='Button' type='submit' value = 'submit' /></center></td><td></td></tr>";
    echo "</table><input type = 'hidden' value = '1' name ='state'/> </form>";

    $out1 = "select * from trialdays where date(time)=curdate() order by name;";
    if (!$db->Query($out1)) $db->Kill();

    if ($db->Rows()>0){    
    echo "<br/><br/><br/><center><h1>Current trial days</h1></center><br/>";
    echo "<table style='width:100%'><tr><th>First name</th><th>Surname</th><th>Code</th><th>Update</th><th>Remove</th></tr>";
    }
    while ($row=$db->Row()){
    echo "<tr><form target = '_self' method = post><td><center><input type = 'text' name = 'name' value = '".$row->name."'/></center></td><td><center><input type = 'text' name = 'surname' value ='".$row->surname."' /></center></td><td><center><input type = 'text' name = 'code' value = '".$row->code."'/></center></td><td><center><input type = 'hidden' name = 'state' value = '2'/><input type = 'hidden' name = 'id' value = '".$row->id."'/><input class='Button' type = 'submit' value = 'Update' /></center></td></form><form target = '_self' method = post><td><center><input type='hidden' name='state' value = '3'/><input type = 'hidden' name = 'id' value = '".$row->id."'/><input type = 'submit' class='Button' value = 'Remove'/></center></td></form></tr>\n";
    }

    echo "</table>";    
    
    echo "</body></html>";
}
?>