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
* @author Christian Ehret <chris@ehret.name> 
* @version $Id: addressselect.js,v 1.3 2006/02/24 21:46:13 ehret Exp $
*/

function switchLayer(layername)
{
	element1 = $("add_private");		
	element2 = $("add_business");
	element3 = $("add_other");
	element4 = $("e_add_private");		
	element5 = $("e_add_business");
	element6 = $("e_add_other");
	myelement = $(layername);
	if (layername.charAt(0) == 'e') {
		myelement2 =  $(layername.substr(2));
	} else {
		myelement2 =  $('e_'+layername);
	}		
	Element.hide(element1, element2, element3, element4, element5, element6);
	Element.show(myelement, myelement2);
	checkUnload = true;
}

function switchLayer2(layername)
{
	element1 = $("show");		
	element2 = $("edit");
	myelement = $(layername);	
	Element.hide(element1, element2);
	Element.show(myelement);
	checkUnload = true;
}
