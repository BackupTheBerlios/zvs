
var isIE, isDOM;
isIE = (document.all ? true : false);
isDOM = (document.getElementById ? true : false);


function switchLayer(layername)
{

	if (isIE)
	{
		element1 = document.all.list;
		element2 = document.all.verkauf;
		element3 = document.all.abrechnung;
		myelement = eval('document.all.'+layername);
	} else {
		element1 = document.getElementById("list");		
		element2 = document.getElementById("verkauf");
		element3 = document.getElementById("abrechnung");
		myelement = document.getElementById(layername);
	}	

	element1.style.display = 'none';
	element2.style.display = 'none';
	element3.style.display = 'none';
	myelement.style.display = '';
}
