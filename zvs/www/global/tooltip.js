/***************************************************************
*  Copyright notice
*  
*  (c) 2003-2004 Christian Ehret (chris@ehret.name)
*  All rights reserved
*
*  This script is part of the ZVS project. The ZVS project is 
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
* 
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*  A copy is found in the textfile GPL.txt and important notices to the license 
*  from the author is found in LICENSE.txt distributed with these scripts.
*
* 
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/***********************************************
* Cool DHTML tooltip script- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

function ietruebody(){
	return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function popup(msg, wwwroot){
	var thecolor = '#FFFFFF';
	var thewidth = 300;
	if (ns6||ie){
		if (typeof thewidth!="undefined"){
			tipobj.style.width=thewidth+"px";
		}
		if (typeof thecolor!="undefined" && thecolor!=""){
			tipobj.style.backgroundColor=thecolor
		}
		tipobj.innerHTML="<table width='300' border='0' cellpadding='1' cellspacing='0' bgcolor='#FFFFFF'><tr><td>"+
"<table  width='100%' border='0' cellpadding='0' cellspacing='0' class='Box'>"+
"<tr><td><img src='"+wwwroot+"img/box_corner01.gif' width='8' height='8'></td>"+
"<td class='BoxTop'><img src='"+wwwroot+"/img/spacer.gif' width='1' height='1'></td>"+
"<td><img src='"+wwwroot+"img/box_corner02.gif' width='8' height='8'></td>"+
"</tr>"+
"<tr>"+
"<td class='BoxLeft'><img src='"+wwwroot+"img/spacer.gif' width='1' height='1'></td>"+
"<td width='100%' class='DefText' height='100%'>"+msg+"</td>"+
"</td><td class='BoxRight'><img src='"+wwwroot+"img/spacer.gif' width='1' height='1'></td></tr>"+
"<tr><td><img src='"+wwwroot+"img/box_corner04.gif' width='8' height='8'></td>"+
"<td class='BoxBottom'><img src='"+wwwroot+"img/spacer.gif' width='1' height='1'></td>"+
"<td><img src='"+wwwroot+"img/box_corner03.gif' width='8' height='8'></td></tr>"+
"</table>";
		enabletip=true;
		return false;
	}
}

function positiontip(e){
	if (enabletip){

		var curX=(ns6)?e.pageX : event.x+ietruebody().scrollLeft;
		var curY=(ns6)?e.pageY : event.y+ietruebody().scrollTop;
		//Find out how close the mouse is to the corner of the window
		var rightedge=ie&&!window.opera? ietruebody().clientWidth-event.clientX-offsetxpoint : window.innerWidth-e.clientX-offsetxpoint-20
		var bottomedge=ie&&!window.opera? ietruebody().clientHeight-event.clientY-offsetypoint : window.innerHeight-e.clientY-offsetypoint-20

		var leftedge=(offsetxpoint<0)? offsetxpoint*(-1) : -1000

		//if the horizontal distance isn't enough to accomodate the width of the context menu
		if (rightedge<tipobj.offsetWidth) {
			//move the horizontal position of the menu to the left by it's width
			tipobj.style.left=ie? ietruebody().scrollLeft+event.clientX-tipobj.offsetWidth+"px" : window.pageXOffset+e.clientX-tipobj.offsetWidth+"px";
		} else if (curX<leftedge) {
			tipobj.style.left="5px";
		} else {
			//position the horizontal position of the menu where the mouse is positioned
			tipobj.style.left=curX+offsetxpoint+"px";
		}

		//same concept with the vertical position
		if (bottomedge<tipobj.offsetHeight) {
			tipobj.style.top=ie? ietruebody().scrollTop+event.clientY-tipobj.offsetHeight-offsetypoint+"px" : window.pageYOffset+e.clientY-tipobj.offsetHeight-offsetypoint+"px"
		} else {
			tipobj.style.top=curY+offsetypoint+"px";
		}
			tipobj.style.visibility="visible";		
	}
}

function kill(){
	if (ns6||ie){
		enabletip=false;
		tipobj.style.visibility="hidden";
		tipobj.style.left="-1000px";
		tipobj.style.backgroundColor='';
		tipobj.style.width='';
	}
}

