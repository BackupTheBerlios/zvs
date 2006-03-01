
function displayCalendar(wwwroot, month, year, view, step) {

  var loadingFunc = function(t) {
	  	Form.disable('choosedate');
        Element.show($("overlay"));
		
    }

    var loadedFunc = function(t) {
        Element.hide($("overlay"));
        Form.enable('choosedate');
    }


	var params = 'month='+month+'&year='+year+'&view='+view+'&step='+step;
	var url = wwwroot+'ajax_calendar.php';
	var options = {
		method: 'post',
		parameters: params,
		onLoading: loadingFunc,
		onLoaded: loadedFunc

	}
	new Ajax.Updater('calendar',url,options);
}
