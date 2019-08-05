<?php
echo "<CENTER><A HREF='unlock.php'>Unlock computers in the Office</A></CENTER>
<CENTER><BR>
<form action='unlock.php' method='post' name='inout'>

<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
<tbody>

  <table border='0' cellpadding='3' cellspacing='1'>

 <tr>
		<td>Enter password</td>
        <td><INPUT TYPE='password' size='5' NAME='pass1' VALUE=''></td>
		<td><input class='Button' name='Nowy' type='submit' value='UNLOCK'></td>
  </tr>

  </TD></tr>

</tr>

<tr>
        <td align='right' colspan='4'>
			<input  name='ip' type='hidden' value='$ip'>
			<input  name='state' type='hidden' value='1'>
			


      </tr>

<input name='state' type='hidden' value='1'>
<input  name='czaswewy' type='hidden' value='$teraz'>

    </form>
  </tbody>
</table>
</center>

";
?>
