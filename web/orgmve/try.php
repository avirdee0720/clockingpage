<?php
global $user;
print $user->name;

	function MyPow($r, $w){
	 if($w==0)
	  return 1;
	 else
	  return MyPow($r, $w-1) * $r;
	}
	 
echo MyPow(10, 2);

?>
