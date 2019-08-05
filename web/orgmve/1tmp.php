<?php



function loguj($tabela, $operacja, $skrypt){
	$dblog = new CMySQL;
	if (!$dblog->Open())$dblog->Kill();

	if ($dblog->Query($queryMsg[$i])) 
	{
		$godz      = date("G:m:s");
		$logi = "INSERT INTO hd_log ( lp, tabela, temat, kiedy, user_id, infodod) VALUES(null, '$tabela', '$operacja', '$dzis $godz', '$id', '$skrypt')";
		if (!$db->Query($logi)) $db->Kill();
	} else {
		echo "<H1>ERRROR IN LOGING</H1>";
	}
}

?>