<?php
$order=$_GET['order'];
echo "<script language='javascript'>window.open(\"fax2.php?order=$order\",\"print\",\"left=0,top=0,width=700,height=600,resizable=yes,scrollbars=yes,menubar=no\")</script>";
echo "<script language='javascript'>window.location=\"order1.php?order=$order\"</script>";

?>