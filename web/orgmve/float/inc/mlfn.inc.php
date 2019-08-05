<?php 
include("./config.php");
include("./languages/$LANGUAGE.php");

$rown="15"; //number of rows to be display each page 

//The functions 
function first($start,$trows,$rown,$nazwaPliku) 
{ 
	if ($start == $trows-intval($trows%$rown)&&$trows>$rown ||$start<>intval(0)) 
	{ 
		$first="<a href=$nazwaPliku?start=0> <-| </a>";} 
	else 
	{ 
		$first=" < "; 
	} 
	return $first; 
} 

function previous($start,$trows,$rown,$nazwaPliku) 
{ 
	if ($start >= $trows-intval($trows%$rown)&&$trows>$rown||$start<>intval(0)) 
	{ 
		$prev=$start-$rown; 
		$previous="<a href=$nazwaPliku?start=$prev> << </a>"; 
	} 
	else 
	{ 
		$previous=" << "; 
	} 
	return $previous; 
	} 

function next1($start,$trows,$rown,$nazwaPliku) 
{ 
	if ($start < ($trows-intval($trows%$rown))&&(($start+$rown)-$trows<>"0")) 
	{ 
		$next=$start+$rown; 
		$next="<a href=$nazwaPliku?start=$next> >> </a>"; 
	} 
	else 
	{ 
		$next=" >> "; 
	} 
	return $next; 
	} 

function last($start,$trows,$rown,$nazwaPliku) 
	{ 
	if ($start < $trows-intval($trows%$rown)&&(($start+$rown)-$trows<>"0")) 
	{ 
		if (($rem=$trows%$rown)==0){$rem=$rown;} 
		$last=intval($trows-$rem); 
		$last="<a href=$nazwaPliku?start=$last> |-> </a>"; 
	} 
	else 
	{ 
		$last=" > "; 
	} 
	return $last; 
	} 
//end of the functions 
?> 
