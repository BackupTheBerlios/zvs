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

/**
* Javascript functions to check if something was changed when a form is left
* 
* @since 2003-09-17
* @author Christian Ehret <chris@uffbasse.de> 
* @version $Id: confirmleave.js,v 1.1 2004/11/03 15:05:42 ehret Exp $
*/

var altered = false;
var checkUnload = true; 


function bypassCheck() 
{ 
	checkUnload  = false; 
}

function setaltered()
{
	altered = true;
}

function unsetaltered()
{

	altered = false;
}

function getAltered()
{
	return altered;
}

function addEvent(obj, evType, fn, useCapture){
  if (obj.addEventListener){
    obj.addEventListener(evType, fn, useCapture);
    return true;
  } else if (obj.attachEvent){
    var r = obj.attachEvent("on"+evType, fn);
    return r;
  } else {
    alert("Handler could not be attached");
  }
} 

function removeEvent(obj, evType, fn, useCapture){
  if (obj.removeEventListener){
    obj.removeEventListener(evType, fn, useCapture);
    return true;
  } else if (obj.detachEvent){
    var r = obj.detachEvent("on"+evType, fn);
    return r;
  } else {
    alert("Handler could not be removed");
  }
} 

function addonchangeevents()
{

	var element, elements, i, j, formelements;

	formelements = new Array("textarea", "input", "select");

	for (j = 0; j < formelements.length; j++)
	{
		elements = document.getElementsByTagName(formelements[j]);

		for (i = 0; i < elements.length; i++)
		{

			addEvent(elements[i], 'change', setaltered, false);

		}
	}
	
	if (is_nav || is_opera)
	{
		elements = document.getElementsByTagName("a");
		for (i = 0; i < elements.length; i++)
		{
			elements[i].addEventListener("click", function(e) { if (confirmNSLeave()) {e.preventDefault();}}, false);
		}
	}
	
}

function returnvalue()
{
   try
   {
   		document.activeElement.blur();
		window.focus();
	}
	catch(e)
	{
	}

	if (checkUnload) 
   	{
   		if (altered)
   		{
	   		event.returnValue = "Die Änderungen wurden nicht gespeichert! Trotzdem diese Seite verlassen?";
		}
		
	}
}


function confirmNSLeave() 
{

	if (checkUnload)
	{
		if (getAltered())
		{

			if (!confirm('Die Änderungen wurden nicht gespeichert! Trotzdem diese Seite verlassen?'))
			{
				return true;
  			}
  		} else
		{ 
		return false;
		}
	}	 
}





