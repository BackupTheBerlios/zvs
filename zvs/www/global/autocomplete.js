function autocomplete_guestsearch_lastname() {
    new Ajax.Autocompleter("frm_lastname", "search-results", "ajax_autocompleteguest.php", {paramName: "autocomplete", minChars: 1, afterUpdateElement: updatesearch_lastname });
}

function updatesearch_lastname(txt, li)
{
	$("frm_firstname").value = li.id;
	$("search").submit();
}

function autocomplete_guestsearch_firstname() {
	new Ajax.Autocompleter("frm_firstname", "search-results", "ajax_autocompleteguest2.php", {paramName: "autocomplete", minChars: 1, afterUpdateElement: updatesearch_firstname });
}

function updatesearch_firstname(txt, li)
{
	$("frm_lastname").value = li.id;
	$("search").submit();
}
