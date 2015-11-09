<?php 
require_once("db.php");

header('Content-Type: application/json'); 

$method = $_GET['method'];

// Make sure user is logged in
$session = $_GET['session'];
$db = new db();
$db->open();
$stmt = $db->pdo()->prepare('SELECT userid FROM sessions WHERE validuntil > NOW() AND sessionid = :session');
$stmt->execute(array('session' => $session));
$result = $stmt->fetch();
if (!$result) {
	$db->close();
	echo json_encode(array("error" => "Unauthorized access!"), JSON_FORCE_OBJECT);
	return;
}
$userid = $result["userid"];
//---


if ($method == "getProject") {	
	$filter = $_GET['filter']; // all, others
	$id = "";
	if ($filter == "id")
		$id = $_GET['id'];
	
	$db = new db();
	$db->open();
	
	$res = null;
		
	if ($filter="all") {
		$stmt = $db->pdo()->prepare('SELECT * FROM projects');
		$stmt->execute();
		
		$numRows = 0;
		while ($row = $stmt->fetch()) {
			if ($res == null) 
				$res = $row;
			else
				$res = array($res, $row);
			$numRows++;
		}
		
		$res = array("rows"=>$numRows, "data"=>$res);
	}
	
	$db->close();
	echo json_encode($res, JSON_FORCE_OBJECT);
} else if ($method == "getProjectUsers") {
	$prjid = $_GET['id'];
	/*
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
	*/
	$db->close();
	echo json_encode($res, JSON_FORCE_OBJECT);
} else if($method == "deleteProject") {
	$prjid = $_GET['id'];

	$db = new db();
	$db->open();
	/*
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
	*/
	$db->close();
} else if($method == "renameProject") {
	$prjid = $_GET['id'];
	$name = $_GET['name'];

	$db = new db();
	$db->open();
	/*
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
	*/
	$db->close();
} else if($method == "createProject") {
	$name = $_GET['name'];
	$desc = $_GET['desc'];

	$db = new db();
	$db->open();
	/*
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
	*/
	$db->close();	
} else if($method == "addUserToProject") {
	$userid = $_GET['userid'];
	$prjid = $_GET['prjid'];
	$roleid = $_GET['roleid'];

	$db = new db();
	$db->open();
	/*
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
	*/
	$db->close();	
} else {
	$error = array(
		"message" => "Unknown function"
	);
	echo json_encode($error, JSON_FORCE_OBJECT);
}

?>
