<?php 
require_once("db.php");

header('Content-Type: application/json'); 

$method = $_GET['call'];

if ($method == "getBook") {
	$book = array(
		"title" => "JavaScript: The Definitive Guide",
		"author" => "David Flanagan",
		"edition" => 6
	);
	$db = new db();
	$db->open();
	$db->close();
	echo json_encode($book, JSON_FORCE_OBJECT);
} else {
	$error = array(
		"message" => "Unknown function"
	);
	echo json_encode($error, JSON_FORCE_OBJECT);
}

?>
