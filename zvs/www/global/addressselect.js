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
* Javascript functions to switch between the several address types
* 
* @since 2003-09-17
* @author Christian Ehret <chris@uffbasse.de> 
* @version $Id: addressselect.js,v 1.2 2006/02/24 01:47:56 ehret Exp $
*/
var isIE, isDOM;
isIE = (document.all ? true : false);
isDOM = (document.getElementById ? true : false);


function switchLayer(layername)
{
	if (isIE)
	{
		element1 = document.all.add_private;
		element2 = document.all.add_business;
		element3 = document.all.add_other;
		element4 = document.all.e_add_private;
		element5 = document.all.e_add_business;
		element6 = document.all.e_add_other;
		myelement = eval('document.all.'+layername);
		if (layername.charAt(0) == 'e') {
			myelement2 = eval('document.all.'+layername.substr(2));
		} else {
			myelement2 = eval('document.all.e_'+layername);
		}
	} else {
		element1 = document.getElementById("add_private");		
		element2 = document.getElementById("add_business");
		element3 = document.getElementById("add_other");
		element4 = document.getElementById("e_add_private");		
		element5 = document.getElementById("e_add_business");
		element6 = document.getElementById("e_add_other");
		myelement = document.getElementById(layername);
		if (layername.charAt(0) == 'e') {
			myelement2 =  document.getElementById(layername.substr(2));
		} else {
			myelement2 =  document.getElementById('e_'+layername);
		}		
	}	

	element1.style.display = 'none';
	element2.style.display = 'none';
	element3.style.display = 'none';
	element4.style.display = 'none';
	element5.style.display = 'none';
	element6.style.display = 'none';	
	myelement.style.display = '';
	myelement2.style.display = '';
	checkUnload = true;
}

function switchLayer2(layername)
{
	if (isIE)
	{
		element1 = document.all.show;
		element2 = document.all.edit;
		myelement = eval('document.all.'+layername);
	} else {
		element1 = document.getElementById("show");		
		element2 = document.getElementById("edit");
		myelement = document.getElementById(layername);
	}	

	element1.style.display = 'none';
	element2.style.display = 'none';
	myelement.style.display = '';
	checkUnload = true;
}
