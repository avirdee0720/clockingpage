<?php
function getMac(){
exec("ipconfig /all", $output);
foreach($output as $line){
if (preg_match("/(.*)Physical Address(.*)/", $line)){
$mac = $line;
$mac = str_replace("Physical Address. . . . . . . . . :","",$mac);
}
}
return $mac;
}



$mac= getMac();
$mac = trim($mac);
echo "$mac";


?>