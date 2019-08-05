
<script language="JavaScript">
function chkAll(frm, arr, arr1, mark) {
  for (i = 0; i <= frm.elements.length; i++) {
   try{
     if(frm.elements[i].name == arr) {
       frm.elements[i].1 == arr1;
       frm.elements[i].2 == mark;
		frm.elements[i].2 = frm.elements[i].name * frm.elements[i].1 ;
     }
   } catch(er) {}
  }
  return frm.elements[i].2;
}
</script>

<form name='foo'>
<input type="checkbox" name="ca" value="1" onChange="chkAll(this.form, 'formVar[chkValue][]', formVar[chkValue][1]), formVar[chkValue][2]">

<?php
for($i = 0; $i < 5; $i++){
echo("<input type='input' name='formVar[chkValue][]' value='$i'>");
echo("<input type='input' name='formVar[chkValue][1]' value='2'>");
echo("<input type='input' name='formVar[chkValue][2]' value=''><BR>");

}
?>

</form>