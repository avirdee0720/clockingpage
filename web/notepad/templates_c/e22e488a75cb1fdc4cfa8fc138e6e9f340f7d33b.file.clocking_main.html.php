<?php /* Smarty version Smarty-3.0.8, created on 2017-05-31 18:14:51
         compiled from "./templates/clocking_main.html" */ ?>
<?php /*%%SmartyHeaderCode:417378286592efa0b6ddf25-34470096%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e22e488a75cb1fdc4cfa8fc138e6e9f340f7d33b' => 
    array (
      0 => './templates/clocking_main.html',
      1 => 1496250887,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '417378286592efa0b6ddf25-34470096',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <?php if ($_smarty_tpl->getVariable('messagesign')->value=='1'){?>
        <META HTTP-EQUIV="refresh" CONTENT="5">
    <?php }?>
<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=utf-8">
<META HTTP-EQUIV='Content-Language' CONTENT='en'>
<META HTTP-EQUIV='Pragma' CONTENT='no-cache'>
<title>Memo page</title>
<link rel="stylesheet" type="text/css" href="style.css" />

<script type="text/javascript">
<!--
function createRequestObject() {
	var ro;
	var browser = navigator.appName;
	if(browser == 'Microsoft Internet Explorer') {
		ro = new ActiveXObject("Microsoft.XMLHTTP");
	} else {
		ro = new XMLHttpRequest();
	}
	return ro;
}
	
	var http = createRequestObject();
	var http2 = createRequestObject();
	var b=0;
	var clversion=0;

function sndReq() {
	http.open('get', 'clocking_data.php?do=clversion',true);
	http.onreadystatechange = handleResponse;
	http.send(null);
}

function sndReq2() {
	http2.open('get', 'clocking_data.php?do=cltable',true);
	http2.onreadystatechange = handleResponse2;
	http2.send(null);
}

function handleResponse() {	
    if(http.readyState == 4) {
        var response = http.responseText;
        if (response != "" && response != clversion) {
            clversion = response;
            sndReq2();
        }
    }
}

function handleResponse2() {
    var mydate=new Date()
    var messagesign = "<?php echo $_smarty_tpl->getVariable('messagesign')->value;?>
";
  
    if(http2.readyState == 4) {
        var response = http2.responseText;
        var word=response.split("<clocking>");
        if (response != "") {
            if (messagesign  != "1") {
                    document.getElementById('shopnumberx').innerHTML = word[0];
                    document.getElementById('shopnumbery').innerHTML = word[1];
                    //if (word[1] < word[2] && mydate.getHours()>9 && mydate.getHours()<20)
                    if (word[1] < 20 && mydate.getHours()>9 && mydate.getHours()<20)  {document.getElementById('understaffingtext').innerHTML = '<div><span class="blinker" style="visibility: visible;"><em><strong><font color="red">UNDERSTAFFING</font></strong></em></span></div>';}
                    else {document.getElementById('understaffingtext').innerHTML = ' ';}
            }
            document.getElementById('getlist').innerHTML = word[3];
        }
    }
}

if (b == 0) { 
    b=1;
    sndReq();
}

//-->
</script>

<script langauge="JavaScript">
<!--  

function page_OnLoad()
{
    var result;

    if (document.forms["inout"] && document.inout.pno) document.inout.pno.focus();
	document.getElementById('pno').focus();
    return result;
}

function bind_events() {
    page_OnLoad();
}


function appendToForm(text)
{
    document.getElementById('pno').value = document.getElementById('pno').value + text;
}

defaultStatus = "CLOCK IN OUT";  

//-->


<!-- This script and many more are available free online at -->
<!-- The JavaScript Source!! http://javascript.internet.com -->
<!-- Original:  Chris (javascript@crashedstar.com) -->
<!-- Web Site:  http://www.crashedstar.com/ -->

<!-- Begin
var startLocal = new Date();
var StartServ = new Date();

function initClock(){
    startLocal = new Date();
    startServ = new Date(<?php echo $_smarty_tpl->getVariable('time')->value;?>
);
    }

var dayarray=new Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday")
var montharray=new Array("January","February","March","April","May","June","July","August","September","October","November","December")
function getthedate(){
var tempLocal = new Date();
var mydate=new Date(tempLocal.getTime()+startServ.getTime()-startLocal.getTime());
var year=mydate.getYear()
if (year < 1000)
year+=1900
var day=mydate.getDay()
var month=mydate.getMonth()
var daym=mydate.getDate()
if (daym<10)
daym="0"+daym
var hours=mydate.getHours()
var minutes=mydate.getMinutes()
var seconds=mydate.getSeconds()

{
 d = new Date();
 Time24H = new Date();
 Time24H.setTime(d.getTime() + (d.getTimezoneOffset()*60000) + 3600000);
 }
if (hours==0)
hours=12
if (minutes<=9)
minutes="0"+minutes
if (seconds<=9)
seconds="0"+seconds
//change font size here
var cdate=hours+":"+minutes+":"+seconds+""
var cdate2=dayarray[day]+",&nbsp;"+daym+"&nbsp;"+montharray[month]+"&nbsp;"+year+""
if (document.all) {
document.all.clock.innerHTML=cdate
document.all.clock2.innerHTML=cdate2
}
else if (document.getElementById) {
document.getElementById("clock").style.font='bold 22px Helvetica';
document.getElementById("clock").innerHTML=cdate
document.getElementById("clock2").style.font='bold 12px Helvetica';
document.getElementById("clock2").innerHTML=cdate2
}
else {
document.write(cdate)
document.write(cdate2)
} 


}
if (!document.all&&!document.getElementById)
getthedate()

function goforit(){

  var messagesign = "<?php echo $_smarty_tpl->getVariable('messagesign')->value;?>
";

if (document.all||document.getElementById)
if (messagesign  != "1")	{
initClock();
setInterval("getthedate()",1000)
}
setInterval("sndReq()",5000);
bind_events();
}

window.onload=goforit

//  End -->

</script>

<script>
var blinkers;
window.addEventListener('load', init, false);
function init() {
    blinkers = document.getElementsByClassName('blinker');
    setInterval(function() { toggleBlinkHandler(); }, 2000);
}
function toggleBlinkHandler() {
    toggleBlink();
    setTimeout(function() { toggleBlink(); }, 1000);
}
function toggleBlink() {
    for(var i = 0; i < blinkers.length; i++) {
        if(blinkers[i].style.visibility == 'visible') {
            blinkers[i].style.visibility = 'hidden';
        } else {
            blinkers[i].style.visibility = 'visible';
        }
    }
}
</script>


</head>
 <body class="oneColFixCtrHdr" leftmargin="0px" topmargin="0px" marginwidth="0px" marginheight="0px">
 <div id="container">
   
    <?php if (($_smarty_tpl->getVariable('messagesign')->value=='0')||($_smarty_tpl->getVariable('messagesign')->value=='2')){?>
  <div id="header">
    <!-- end #header -->
    <form action='<?php echo $_SERVER['PHP_SELF'];?>
' method='POST' name='inout' autocomplete = 'off'>
    <input type='hidden' name='state' value='1'>
    <input type='hidden' name='ip'  value='<?php echo $_smarty_tpl->getVariable('ip')->value;?>
'>
    <input type='hidden' name='rnd'  value='<?php echo $_smarty_tpl->getVariable('rnd')->value;?>
'>
    <table class="table_header1a" border ="0" width="100%" >
      <tr>
        <td width="20%" scope="col" align="center"></td>
      
        <td width="10%" scope="col" align="center"><?php echo $_smarty_tpl->getVariable('prev')->value;?>
 </td>
        <td width="40%" scope="col" align="center">
		<font color="#000099"><span id="clock"></span></font>
		<br>
		<span id="clock2"></span></td>
        <td width="10%" scope="col" align="center"><?php echo $_smarty_tpl->getVariable('next')->value;?>
 </td>
        <td width="20%" scope="col" align="center"></td>
	
      </tr>
    </table>
    </form>
  </div>  
    <?php }?>
    
	<?php if ($_smarty_tpl->getVariable('messagesign')->value=='1'){?>
  <div id="header">
    <table border="0" class="table_header2" width="100%" >
      <tr>
        <td align="center"><?php echo $_smarty_tpl->getVariable('message')->value;?>
</td>
      </tr>
    </table>
    <!-- end #header -->
  </div>
    <?php }?>

  <div id="mainContent">
    <table border="0" width="100%" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td scope="col"><div id="getlist"></div></td>
    </tr>
  </table>
  </div>
    
    
        <?php if ($_smarty_tpl->getVariable('showtrial')->value!='0'){?>
  <div id="trialdayContent">
    <form action='<?php echo $_SERVER['PHP_SELF'];?>
' method='POST' name='trialmemo' autocomplete = 'off'>
    <input type='hidden' name='state' value='2'>
    <input type='hidden' name='ip'  value='$ip'>
    <table class="table_header1b" border ="0" width="100%" >
      <tr>
        <td height="30" width="25%"><input class="Button" name="action" type="submit" value="Add new trial day"></td>
        <td height="30" width="25%"><input class="Button" name="action" type="submit" value="Save trial day"></td>
        <td height="30" width="50%"></td>
      </tr>
    </table>
    
        <?php if ($_smarty_tpl->getVariable('trialnum')->value!='0'){?>
    <table align="center" width="100%">
    <tr>
    <td valign="top" width="49%">
        <table class="trial" width="100%" align="center">
        <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('trialtableleft')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['i']->key;
?>
            <tr valign="middle">
            <td width="95%" class="col3">
                <input type="text" class="trialinput" size="90" maxlength="255" name="trialtext[]" value="<?php echo $_smarty_tpl->tpl_vars['i']->value[3];?>
">
            </td>
            <td width="5%" class="col4">
                <a href="deltrial.php?url=<?php echo $_SERVER['PHP_SELF'];?>
&clver=<?php echo $_smarty_tpl->getVariable('clversion')->value;?>
&memo=<?php echo $_smarty_tpl->getVariable('memoclno')->value;?>
&delid=<?php echo $_smarty_tpl->tpl_vars['i']->value[0];?>
"><img src="img/delete_memo.png" width="13" height="13" border="0" align="top" /></a>
                <input type='hidden' name='trialid[]' value='<?php echo $_smarty_tpl->tpl_vars['i']->value[0];?>
'>
            </td>
            </tr>
        <?php }} ?>
        </table>
    </td>
    <td valign="top" width="1%"></td>
    <td valign="top" width="49%">
        <table class="trial" width="100%" align="center">
            <?php if ($_smarty_tpl->getVariable('trialnumright')->value!='0'){?>
            <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('trialtableright')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['i']->key;
?>
            <tr valign="middle">
                <td width="95%" class="col3">
                    <input type="text" class="trialinput" size="90" maxlength="255" name="trialtext[]" value="<?php echo $_smarty_tpl->tpl_vars['i']->value[3];?>
">
                </td>
                <td width="5%" class="col4">           
                    <a href="deltrial.php?url=<?php echo $_SERVER['PHP_SELF'];?>
&clver=<?php echo $_smarty_tpl->getVariable('clversion')->value;?>
&memo=<?php echo $_smarty_tpl->getVariable('memoclno')->value;?>
&delid=<?php echo $_smarty_tpl->tpl_vars['i']->value[0];?>
"><img src="img/delete_memo.png" width="13" height="13" border="0" align="top" /></a>
                    <input type='hidden' name='trialid[]' value='<?php echo $_smarty_tpl->tpl_vars['i']->value[0];?>
'>
                </td>
            </tr>
            <?php }} ?>
            <?php }else{ ?>
            <tr valign="middle"><td width="50%" border="1"></td></tr>        
            <?php }?>
        </table>
    </td>
    </tr>
    </table>
        <?php }?>
    </form>
<!-- end #container -->  </div>
    <?php }?>
    
    
        <?php if ($_smarty_tpl->getVariable('memoclno')->value!='0'){?>
  <div id="memoContent">
    <form action='<?php echo $_SERVER['PHP_SELF'];?>
?no=<?php echo $_smarty_tpl->getVariable('memoclno')->value;?>
' method='POST' name='memo' autocomplete = 'off'>
    <input type='hidden' name='state' value='3'>
    <input type='hidden' name='ip'  value='$ip'>
    <table class="table_header1b" border ="0" width="100%" >
      <tr>
        <td height="30" width="25%"><input class="Button" name="action" type="submit" value="Add new memo"></td>
        <td height="30" width="25%"><input class="Button" name="action" type="submit" value="Save"></td>
        <td height="30" width="50%"></td>
      </tr>
    </table>
    
        <?php if ($_smarty_tpl->getVariable('memosnum')->value!='0'){?>
    <table align="center" width="100%">
    <tr>
    <td valign="top" width="49%">
        <table class="memo" width="100%" align="center">
        <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('memotableleft')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['i']->key;
?>
            <tr valign="middle">
            <td width="95%" class="col1">
                <?php if ($_smarty_tpl->tpl_vars['i']->value[4]=='0'||$_smarty_tpl->tpl_vars['i']->value[4]=='1'){?>            
                    <div><span class="blinker" style="visibility: visible;"><input type="text" class="memoinputred" size="90" maxlength="255" name="memotext[]" value="<?php echo $_smarty_tpl->tpl_vars['i']->value[3];?>
"></span></div>
                <?php }else{ ?>
                    <input type="text" class="memoinput" size="90" maxlength="255" name="memotext[]" value="<?php echo $_smarty_tpl->tpl_vars['i']->value[3];?>
">
                <?php }?>
            </td>
            <td width="5%" class="col2">
                <a href="delmemo.php?url=<?php echo $_SERVER['PHP_SELF'];?>
?no=<?php echo $_smarty_tpl->getVariable('memoclno')->value;?>
&delid=<?php echo $_smarty_tpl->tpl_vars['i']->value[0];?>
"><img src="img/delete_memo.png" width="13" height="13" border="0" align="top" /></a>
                <input type='hidden' name='memoid[]' value='<?php echo $_smarty_tpl->tpl_vars['i']->value[0];?>
'>
            </td>
            </tr>
        <?php }} ?>
        </table>
    </td>
    <td valign="top" width="1%"></td>
    <td valign="top" width="49%">
        <table class="memo" width="100%" align="center">
            <?php if ($_smarty_tpl->getVariable('memosnumright')->value!='0'){?>
            <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('memotableright')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['i']->key;
?>
            <tr valign="middle">
                <td width="95%" class="col1">
                <?php if ($_smarty_tpl->tpl_vars['i']->value[4]=='0'||$_smarty_tpl->tpl_vars['i']->value[4]=='1'){?>
                    <div><span class="blinker" style="visibility: visible;"><input type="text" class="memoinputred" size="90" maxlength="255" name="memotext[]" value="<?php echo $_smarty_tpl->tpl_vars['i']->value[3];?>
"></span></div>
                <?php }else{ ?>
                    <input type="text" class="memoinput" size="90" maxlength="255" name="memotext[]" value="<?php echo $_smarty_tpl->tpl_vars['i']->value[3];?>
">
                <?php }?>
                </td>
                <td width="5%" class="col2">           
                    <a href="delmemo.php?url=<?php echo $_SERVER['PHP_SELF'];?>
&memo=<?php echo $_smarty_tpl->getVariable('memoclno')->value;?>
&delid=<?php echo $_smarty_tpl->tpl_vars['i']->value[0];?>
"><img src="img/delete_memo.png" width="13" height="13" border="0" align="top" /></a>
                    <input type='hidden' name='memoid[]' value='<?php echo $_smarty_tpl->tpl_vars['i']->value[0];?>
'>
                </td>
            </tr>
            <?php }} ?>
            <?php }else{ ?>
            <tr valign="middle"><td width="50%" border="1"></td></tr>        
            <?php }?>
        </table>
    </td>
    </tr>
    </table>
        <?php }?>
    </form>
<!-- end #container -->  </div>
    <?php }?>

</body>
</html>
