var utils = {};

/**
 * Load the HTML and shows a modal dialog
 * 
 * @param {String} dialogURL - HTML file that contains the dialog body
 * @param {String} title - Dialog title
 * @param {Object} openFunction - the function to call once the dialog loads
 * @param {Object} closeFunction - the function to call once the dialog closes
 */
utils.showDialog = function(dialogURL, title, openFunction, closeFunction) {
	var $dialog = $('<div />').appendTo('body');
	$dialog.load(dialogURL, openFunction).dialog({
		modal: true, 
		title: title,
		close: function(event, ui)
		{
			$(this).empty();    
			$(this).remove();
			if (typeof closeFunction === "function") closeFunction();
		}
	}); 
	return $dialog;
}	

/**
 * Redirect the browser to a new URL
 *
 * @param {String} url - The URL to redirect to
 */
utils.redirect = function(url) {
	document.location = url;
}

/**
 * Display an error message box
 *
 * @param {String} title - Dialog title
 * @param {String} message - Message to display
 * @param {Object} closeFunction - the function to call once the dialog closes
 */
utils.showErrorMessage = function(title, message, closeFunction) {
	var $dialog = $('<div></div>').appendTo('body');
	var $par = $('<p></p>').appendTo($dialog);
	var $icon = $('<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 50px 0;"></span>').appendTo($par);
	var $message = $('<span>'+ message +'</span>').appendTo($par);
	
	$dialog.dialog({
		modal: true,
		width: 500,
		title: title,
		close: function(event, ui)
		{
			$(this).empty();    
			$(this).remove();
			if (typeof closeFunction === "function") closeFunction();
		},
		buttons: {
			Ok: function() {
			  $(this).dialog("close");
			}
		}
	});
}

/**
 * Display an informational message box
 *
 * @param {String} title - Dialog title
 * @param {String} message - Message to display
 * @param {Object} closeFunction - the function to call once the dialog closes 
 */
utils.showMessage = function(title, message, closeFunction) {
	var $dialog = $('<div></div>').appendTo('body');
	var $par = $('<p></p>').appendTo($dialog);
	var $icon = $('<span class="ui-icon ui-icon-info" style="float:left; margin:0 7px 50px 0;"></span>').appendTo($par);
	var $message = $('<span>'+ message +'</span>').appendTo($par);
	
	$dialog.dialog({
		modal: true,
		width: 500,
		title: title,
		close: function(event, ui)
		{
			$(this).empty();    
			$(this).remove();
			if (typeof closeFunction === "function") closeFunction();
		},
		buttons: {
			Ok: function() {
			  $(this).dialog("close");
			}
		}
	});
}