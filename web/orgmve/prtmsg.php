<?php
if(!isset($sort)) $sort=1;

echo "<script language='javascript'>window.open(\"tmesprn.php?sort=$sort&startd=$startd&endd=$endd\",\"print\",\"left=0,top=0,width=700,height=600,resizable=yes,scrollbars=yes,menubar=no\")</script>";
echo "<script language='javascript'>window.location=\"tmes.php?sort=$sort&startd=$startd&endd=$endd\"</script>";

?>