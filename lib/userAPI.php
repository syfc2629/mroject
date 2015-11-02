<?php 
require_once("db.php");

header('Content-Type: application/json'); 

$method = $_GET['method'];

if ($method == "login") {	
	$username = $_GET['username'];
	$password = $_GET['password'];
	
	$db = new db();
	$db->open();
	
	// Is username and password valid
	$stmt = $db->pdo()->prepare('SELECT userid FROM users WHERE username = :name and password = :password');
	$stmt->execute(array('name' => $username, 'password' => md5($password)));
	$result = $stmt->fetch();
	if (!$result) {
		$db->close();
		echo json_encode(array("sessionID" => "0"), JSON_FORCE_OBJECT);
		return;
	}
	$userid = $result["userid"];

	// Logout any existing sessions for that user
	// Note: Not really needed. perhaps they want to use multiple devices at the same time?
	//$stmt = $db->pdo()->prepare('UPDATE sessions SET validuntil = now()-INTERVAL 1 HOUR WHERE userid = :userid');
	//$stmt->execute(array('userid' => $userid));
	
	// Create new session for user
	$newSessionID = uniqid();	// create a new unique session identifier
	$stmt = $db->pdo()->prepare("INSERT INTO sessions(sessionid, userid, loginat, validuntil) VALUES (:sessionid, :userid, NOW(), NOW()+INTERVAL 1 HOUR)");
	$params = array(
			'sessionid' => $newSessionID, 
			'userid' => $userid
		);
	$result = $stmt->execute($params);
	$res = array();
	if ($result) {
		$res = array(
			"sessionID" => $newSessionID,
			"role" => "creator"
		);
	} else {
		$res = array(
			"sessionID" => "0",
			"role" => "guest"
		);
	}

	$db->close();
	echo json_encode($res, JSON_FORCE_OBJECT);
} else if ($method == "register") {
	$res = array(
		"result" => "ok"
	);
	
	$fullname = $_GET['fullname'];
	$username = $_GET['username'];
	$password = $_GET['password'];
	$email = $_GET['email'];
	
	$db = new db();
	$db->open();
	
	// Check if username exists
	$stmt = $db->pdo()->prepare('SELECT username FROM users WHERE username = :name');
	$stmt->execute(array('name' => $username));
	$result = $stmt->fetch();
	if ($result) {
		$db->close();
		echo json_encode(array("result" => "Username already exists!"), JSON_FORCE_OBJECT);
		return;
	}
	
	// Check if email exists
	$stmt = $db->pdo()->prepare('SELECT email FROM users WHERE email = :email');
	$stmt->execute(array('email' => $email));
	$result = $stmt->fetch();
	if ($result) {
		$db->close();
		echo json_encode(array("result" => "Email already exists!"), JSON_FORCE_OBJECT);
		return;
	}
	
	// Create new record
	$stmt = $db->pdo()->prepare("INSERT INTO users(username, fullname, password, email, role) VALUES (:username, :fullname, :password, :email, 'creator')");
	$params = array(
			'username' => $username, 
			'fullname' => $fullname, 
			'password' => md5($password), 
			'email' => $email
		);
	$result = $stmt->execute($params);
	if ($result) {
		$res = array("result" => "ok");
	} else {
		$res = array("result" => "Failed to insert record");
	}
	
	$db->close();
	echo json_encode($res, JSON_FORCE_OBJECT);
} else if($method == "logout") {
	$sessionid = $_GET['sessionid'];
	$username = $_GET['username'];
	$db = new db();
	$db->open();
	
	// Get UserID
	$stmt = $db->pdo()->prepare('SELECT userid FROM users WHERE username = :name');
	$stmt->execute(array('name' => $username));
	$result = $stmt->fetch();
	if (!$result) {
		$db->close();
		return;
	}
	$userid = $result["userid"];

	// Delete Session
	$stmt = $db->pdo()->prepare('DELETE FROM sessions WHERE sessionid = :sessionid AND userid = :userid');
	$stmt->execute(array('sessionid' => $sessionid, 'userid' => $userid));
	
	$db->close();
} else {
	$error = array(
		"message" => "Unknown function"
	);
	echo json_encode($error, JSON_FORCE_OBJECT);
}

?>
