// Percent Bar - Version 1.2
// Author: Brian Gosselin of http://scriptasylum.com

// RELEASE INFO:
// V1.0 - INITIAL RELEASE
// V1.1 - FIXED action() FUNCTION.
//        ADDED NUMERICAL INPUT TO THE incrCount() AND decrCount() FUNCTIONS.
// V1.2 - ADDED FUNCTIONALITY TO BE ABLE TO CONTROL ACTION WHEN BAR IS CLICKED.

var loadedcolor='navy' ;            // PROGRESS BAR COLOR
var unloadedcolor='lightgrey';      // BGCOLOR OF UNLOADED AREA
var barheight=15;                   // HEIGHT OF PROGRESS BAR IN PIXELS
var barwidth=350;                   // WIDTH OF THE BAR IN PIXELS
var bordercolor='black';            // COLOR OF THE BORDER

// THE FUNCTION BELOW CONTAINS THE ACTION(S) TAKEN ONCE BAR REACHES 100%.
// IF NO ACTION IS DESIRED, TAKE EVERYTHING OUT FROM BETWEEN THE CURLY BRACES ({})
// BUT LEAVE THE FUNCTION NAME AND CURLY BRACES IN PLACE.
// PRESENTLY, IT IS SET TO SIMPLY MAKE THE BAR DISAPPEAR, BUT CAN BE CHANGED EASILY.
// TO CAUSE A REDIRECT, INSERT THE FOLLOWING LINE IN BETWEEN THE CURLY BRACES:
// document.location.href="http://redirect_page.html";
// JUST CHANGE THE ACTUAL URL IT "POINTS" TO.

var action=function()
{
hidebar();
alert('The end of the task');
}

// THE FUNCTION BELOW CONTAINS THE ACTION(S) TO TAKE PLACE IF THE USER
// CLICKS THE PERCENTBAR. THIS CAN BE USED TO CANCEL THE PERCENTBAR.
// IF YOU WISH NOTHING TO HAPPEN, SIMPLY REMOVE EVERYTHING BETWEEN THE CURLY BRACES.

var clickBar=function(){
hidebar();
alert('Procedure cancelled.');
}

//*****************************************************//
//**********  DO NOT EDIT BEYOND THIS POINT  **********//
//*****************************************************//

var w3c=(document.getElementById)?true:false;
var ns4=(document.layers)?true:false;
var ie4=(document.all && !w3c)?true:false;
var ie5=(document.all && w3c)?true:false;
var ns6=(w3c && navigator.appName.indexOf("Netscape")>=0)?true:false;
var blocksize=(barwidth-2)/100;
barheight=Math.max(4,barheight);
var loaded=0;
var perouter=0;
var perdone=0;
var images=new Array();
var txt='';
if(ns4){
txt+='<table cellpadding=0 cellspacing=0 border=0><tr><td>';
txt+='<ilayer name="perouter" width="'+barwidth+'" height="'+barheight+'" onmouseup="clickBar()">';
txt+='<layer width="'+barwidth+'" height="'+barheight+'" bgcolor="'+bordercolor+'" top="0" left="0"></layer>';
txt+='<layer width="'+(barwidth-2)+'" height="'+(barheight-2)+'" bgcolor="'+unloadedcolor+'" top="1" left="1"></layer>';
txt+='<layer name="perdone" width="'+(barwidth-2)+'" height="'+(barheight-2)+'" bgcolor="'+loadedcolor+'" top="1" left="1"></layer>';
txt+='</ilayer>';
txt+='</td></tr></table>';
}else{
txt+='<div id="perouter" onmouseup="clickBar()" style="position:relative; visibility:hidden; background-color:'+bordercolor+'; width:'+barwidth+'px; height:'+barheight+'px;">';
txt+='<div style="position:absolute; top:1px; left:1px; width:'+(barwidth-2)+'px; height:'+(barheight-2)+'px; background-color:'+unloadedcolor+'; z-index:100; font-size:1px;"></div>';
txt+='<div id="perdone" style="position:absolute; top:1px; left:1px; width:0px; height:'+(barheight-2)+'px; background-color:'+loadedcolor+'; z-index:100; font-size:1px;"></div>';
txt+='</div>';
}

document.write(txt);

function incrCount(n){
loaded=loaded+n;
setCount(loaded);
}

function decrCount(n){
loaded=loaded-n;
setCount(loaded);
}

function setCount(prcnt){
loaded=prcnt;
if(loaded<0)loaded=0;
if(loaded>=100){
loaded=100;
setTimeout('action()', 400);
}
clipid(perdone, 0, blocksize*loaded, barheight-2, 0);
}

//THIS FUNCTION BY MIKE HALL OF BRAINJAR.COM
function findlayer(name,doc){
var i,layer;
for(i=0;i<doc.layers.length;i++){
layer=doc.layers[i];
if(layer.name==name)return layer;
if(layer.document.layers.length>0)
if((layer=findlayer(name,layer.document))!=null)
return layer;
}
return null;
}

function progressBarInit(){
perouter=(ns4)?findlayer('perouter',document):(ie4)?document.all['perouter']:document.getElementById('perouter');
perdone=(ns4)?perouter.document.layers['perdone']:(ie4)?document.all['perdone']:document.getElementById('perdone');
clipid(perdone,0,0,barheight-2,0);
if(ns4)perouter.visibility="show";
else perouter.style.visibility="visible";
}

function hidebar(){
(ns4)? perouter.visibility="hide" : perouter.style.visibility="hidden";
}

function clipid(id,t,r,b,l){
if(ns4){
id.clip.left=l;
id.clip.top=t;
id.clip.right=r;
id.clip.bottom=b;
}else id.style.width=r;
}

window.onload=progressBarInit;

window.onresize=function(){
if(ns4)setTimeout('history.go(0)' ,400);
}