<?php
/* dostêp do bazy danych
$baza = 'hd_fam';
$server= 'localhost';
$uzyt = 'root';
$gw = '';
*/

function uprstr($aktualne,$wymagane) 
  { 
	if ($aktualne < $wymagane) 
	{ 
		echo "<script language='javascript'>window.location=\"upr.php\"</script>";
		exit;
	} 
  } 

function loguj($tabela, $operacja, $skrypt){
$id = $_COOKIE['id'];
$dzis      = date("Y-m-d");
$dblog = new CMySQL;
	if (!$dblog->Open()) $dblog->Kill();

		$godz      = date("G:m:s");
		$logi = "INSERT INTO hd_log ( lp, tabela, temat, kiedy, user_id, infodod) VALUES(null, '$tabela', '$operacja', '$dzis $godz', '$id', '$skrypt')";
		if (!$dblog->Query($logi)) {echo "<H1>ERRROR IN LOGING</H1>"; $dblog->Kill(); } 
		$dblog->Free();

}

/*
function upr2w($aktualne,$tab,$co) { 
if(!isset($aktualne)) { echo "Cos zle z PU: $aktualne";}
if(!isset($tab)) { echo "Cos zle z t: $tab";}
if(!isset($co)) { echo "Cos zle z co: $co";}
switch ($co)
  {
  case 1:
	$sql = ("SELECT sel FROM tabupraw WHERE tabela LIKE '%$tab' LIMIT 1");
    $akcja="ogladania";
	break;
  case 2:
	$sql = ("SELECT ins FROM tabupraw WHERE tabela LIKE '%$tab' LIMIT 1");
    $akcja="dopisania";
	break;
  case 3:
	$sql = ("SELECT upt FROM tabupraw WHERE tabela LIKE '%$tab' LIMIT 1");
    $akcja="poprawiania";
	break;
  }

   mysql_connect("localhost","pakt","sutek8936");
   mysql_select_db("magazyn");
   $wykonaj = mysql_query ($sql);
	
   while($wiersz = mysql_fetch_array($wykonaj))
	{
     $wymagane = $wiersz[0];
	 if($aktualne < $wymagane) 
	  { 
		//echo "<script language='javascript'>window.location=\"upr.php?ak=$akcja\"</script>";
		echo "$aktualne,$tab,$co";
		exit;
		//return $wymagane;
	  } 
	}
}
*/
?>