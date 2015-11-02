var user = {};

user.getSession = function() {
	return localStorage.getItem("sessionID");
}

user.getUsername = function() {
	return localStorage.getItem("username");
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
	var method = {"method": "logout", "sessionid": user.getSession(), "username": user.getUsername()};
	$.getJSON("lib/userAPI.php", method, function(data){});
	
	localStorage.setItem("sessionID", "0");
	localStorage.setItem("userRole", "");
	localStorage.setItem("username", "");
}

user.createAccount = function(fullname, username, password, email, callback) {
	if (typeof callback != "function") alert('Error: No callback definied for login function');
	
	var method = {"method": "register", "fullname": fullname, "username": username, "password": password, "email": email};
	$.getJSON("lib/userAPI.php", method, function(data){
		callback(data.result);
	});
}