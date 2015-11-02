var user = {};

user.getSession = function() {
	return localStorage.getItem("sessionID");
}

user.isLoggerIn = function() {
	var sessionID = user.getSession();
	
	if (sessionID === null || sessionID == "0") 
		return false;
	
	return true;
}

user.login = function(username, password, callback) {
	if (typeof callback != "function") alert('Error: No callback definied for login function');
	
	var method = {"method": "login", "username": username, "password": password};
	$.getJSON("lib/userAPI.php", method, function(data){
		if (data.sessionID == "0") 
			callback(false);
		else {
			localStorage.setItem("sessionID", data.sessionID);
			localStorage.setItem("userRole", data.role);
			localStorage.setItem("username", username);
			callback(true);
		}
	});
}

user.logout = function() {
	localStorage.setItem("sessionID", "0");
	localStorage.setItem("userRole", "");
	localStorage.setItem("username", "");
}

user.createAccount = function(username, password, email, callback) {
	if (typeof callback != "function") alert('Error: No callback definied for login function');
	
	var method = {"method": "register", "username": username, "password": password, "email": email};
	$.getJSON("lib/userAPI.php", method, function(data){
		callback(data.result);
	});
}