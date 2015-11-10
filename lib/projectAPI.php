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
	$db = new db();
	$db->open();
	
	$res = null;
	$stmt = $db->pdo()->prepare('SELECT * FROM projectusers where prjid=:projectid');
	$stmt->execute(array("projectid"=>$prjid));
	
	$numRows = 0;
	while ($row= $stmt->fetch()) {
		if ($res == null) 
			$res = $row;
		else
			$res = array($res, $row);
		$numRows++;
	}
		
	$res = array("rows"=>$numRows, "data"=>$res);
	
	$db->close();
	echo json_encode($res, JSON_FORCE_OBJECT);
} else if($method == "deleteProject") {
	$prjid = $_GET['id'];
	$db = new db();
	$db->open();
	$stmt=$db->pdo()->prepare('Delete FROM projects where prjid=:prjid');
	$stmt->execute(array("prjid"=>$prjid));
	$stmt=$db->pdo()->prepare('DELETE FROM projectusers where  prjid=:prjid');
	$result=$stmt->execute(array("prjid"=>$prjid));
	$db->close();
	if ($result) {
		$res = array("result" => "Project deleted!");
	} else {
		$res = array("result" => "Failed to delete project");
	}
	echo json_encode($res, JSON_FORCE_OBJECT);	
} else if($method == "renameProject") {
	$prjid = $_GET['id'];
	$name = $_GET['name'];
	$db = new db();
	$db->open();
	$stmt=$db->pdo()->prepare('UPDATE projects SET name =:name where prjid=:prjid');
	$result=$stmt->execute(array("name"=>$name,"prjid"=>$prjid));

	$db->close();
	if ($result) {
		$res = array("result" => "Project renamed!");
	} else {
		$res = array("result" => "Failed to rename project");
	}
	echo json_encode($res, JSON_FORCE_OBJECT);	
} else if($method == "createProject") {
	$n = $_GET['name'];
	$d = $_GET['desc'];

	$db = new db();
	$db->open();
	$stmt=$db->pdo()->prepare("INSERT INTO projects (name, description) VALUES (:name, :desc)");
	$result=$stmt->execute(array("name"=>$n,"desc"=>$d));
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
	if ($result) {
		$res = array("result" => "Project created!");
	} else {
		$res = array("result" => "Failed to create project");
	}
	echo json_encode($res, JSON_FORCE_OBJECT);	
} else if($method == "addUserToProject") {
	$userid = $_GET['userid'];
	$prjid = $_GET['prjid'];
	$roleid = $_GET['roleid'];
	$db = new db();
	$db->open();
	$stmt=$db->pdo()->prepare("select userid,prjid,roleid from projectusers where userid=:userid and prjid=:prjid and roleid=:roleid");
	$stmt->execute(array("userid"=>$userid,"prjid"=>$prjid,"roleid"=>$roleid));
	$exist=$stmt->fetch();
	if($exist){
		$db->close();
		echo json_encode(array("result" => "User already exists!"), JSON_FORCE_OBJECT);
		return;
	}
	$stmt=$db->pdo()->prepare("INSERT INTO projectusers (userid,prjid,roleid) VALUES(:userid,:prjid,:roleid)");
	$result=$stmt->execute(array("userid"=>$userid,"prjid"=>$prjid,"roleid"=>$roleid));
	$db->close();	
	if ($result) {
		$res = array("result" => "User added!");
	} else {
		$res = array("result" => "Failed to add user");
	}
	echo json_encode($res, JSON_FORCE_OBJECT);
} else {
	$error = array(
		"message" => "Unknown function"
	);
	echo json_encode($error, JSON_FORCE_OBJECT);
}

?>
