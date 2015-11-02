<?php 
require_once("db.php");

header('Content-Type: application/json'); 

$method = $_GET['method'];

if ($method == "login") {
	$res = array(
		"sessionID" => "hgasjd2",
		"role" => "guest"
	);
	
	$username = $_GET['username'];
	$password = $_GET['password'];
	
	// TO DO: Hard coded for now
	if ($username != 'violin') {
		$res = array(
			"sessionID" => "0",
			"role" => "guest"
		);
	}
	//$db = new db();
	//$db->open();
	
	// TO DO: 
	// 1) check if user exists and if password is correct
	// 2) logout any existing sessions for that user
	//		- update records in "sessions" table for that user to expired
	// 3) insert a new record in "sessions" with a new hash as sessionID
	// 4) return sessionID and role 

	// If we fail at any point return sessionID = 0 
	
	//$db->close();
	echo json_encode($res, JSON_FORCE_OBJECT);
} else if ($method == "register") {
	$res = array(
		"result" => "ok"
	);
	
	$username = $_GET['username'];
	$password = $_GET['password'];
	$email = $_GET['password'];
	
	//$db = new db();
	//$db->open();
	
	// TO DO: 
	// 1) check if user exists and if it does fail
	// 2) if email is already used fail - or if email is invalid
	// 3) create user account in database
	// 4) return "result" -> "ok" or userfriendly error message

	
	//$db->close();
	echo json_encode($res, JSON_FORCE_OBJECT);
} else {
	$error = array(
		"message" => "Unknown function"
	);
	echo json_encode($error, JSON_FORCE_OBJECT);
}

?>
